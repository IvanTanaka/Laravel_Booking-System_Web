<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Models\Franchise;
use App\Models\Redeem;
use App\Models\BankAccount;
use App\Enums\RedeemStatus;

class RedeemController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $franchise = Franchise::where('owner_id', $user->id)->first();
        $bank_account = BankAccount::where('owner_id', $user->id)
        ->where('is_default', true)
        ->where('is_deleted', false)
        ->first();
        
        if ($request->ajax()) {
            $data = Redeem::with(['bank_account'])->whereHas('franchise', function($query) use($user){
                $query->where('owner_id','=',$user->id);
            })
            ->latest()->get();
            
            
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('created', function($row){
                return date("d M Y H:i:s", strtotime($row->created_at));
            })
            ->addColumn('amount', function($row){
                $formattedPrice = 'Rp '.number_format($row->amount, 2, ',', '.');
                return $formattedPrice;
            })
            ->addColumn('account_number',function($row){
                return $row->bank_account->account_number;
            })
            ->addColumn('bank',function($row){
                return $row->bank_account->bank;
            })
            ->addColumn('bank_name',function($row){
                return $row->bank_account->name;
            })
            ->addColumn('status', function($row){
                switch($row->status){
                    case RedeemStatus::ACCEPTED:
                        return "<span class='accepted_redeem_status'>Accepted</span>";
                    case RedeemStatus::REJECTED:
                        return "<span class='rejected_redeem_status'>Rejected</span>";
                    case RedeemStatus::WAITING:
                        return "<span class='waiting_redeem_status'>Waiting</span>";
                    case RedeemStatus::CANCELED:
                        return "<span class='canceled_redeem_status'>Canceled</span>";
                }
            })
            ->addColumn('action', function($row){
                if($row->status == RedeemStatus::WAITING){

                    $cancelBtn = '<div class="col-6">'
                    .'<form action="'.url('redeem/cancel').'" method="post">'
                    .'<input type="hidden" name="redeem_id" value="'.$row->id.'" />'
                    .csrf_field()
                    .'<button class="btn btn-danger btn-small">'
                    .'Canceled'
                    .'</button>'
                    .'</form>'
                    .'</div>';

                    $action = $cancelBtn;
                    return $action;
                }
                return "";
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
        }
        return view('owner.redeem.index', compact(['franchise','bank_account']));
    }

    public function create(Request $request){
        $user = Auth::user();
        $franchise = Franchise::where('owner_id', $user->id)->first();
        $redeem = new Redeem();
        $redeem->owner_id = $user->id;
        $redeem->franchise_id = $franchise->id;
        $redeem->bank_account_id = $request->bank_account_id;
        $redeem->amount = $request->redeem_amount;
        $redeem->status = RedeemStatus::WAITING;
        $redeem->save();
        $franchise->amount -= $redeem->amount;
        $franchise->update();
        return redirect('redeem');
    }

    public function cancel(Request $request){
        $redeem = Redeem::find($request->redeem_id);
        if($redeem->owner_id == Auth::id()&&$redeem->status == RedeemStatus::WAITING){
            $redeem->status = RedeemStatus::CANCELED;
            $franchise = Franchise::find($redeem->franchise_id);
            $franchise->amount += $redeem->amount;
            $redeem->update();  
            $franchise->update();
        }
        return back();
    }
}
