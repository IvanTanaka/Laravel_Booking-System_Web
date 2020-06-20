<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Redeem;
use App\Models\Franchise;
use DataTables;
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
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    { 
        $user = Auth::user();
        if ($request->ajax()) {

            $data = Redeem::with(['franchise','owner','bank_account'])
            ->latest()
            ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('created', function($row){
                        return date("d M Y H:i:s", strtotime($row->created_at));
                    })
                    ->addColumn('bank_account_number',function($row){
                        return $row->bank_account->account_number;
                    })
                    ->addColumn('bank',function($row){
                        return $row->bank_account->bank;
                    })
                    ->addColumn('bank_name',function($row){
                        return $row->bank_account->name;
                    })
                    ->addColumn('franchise_name', function($row){
                        return $row->franchise->name;
                    })
                    ->addColumn('owner_name', function($row){
                        return $row->owner->name;
                    })
                    ->addColumn('owner_phone_number', function($row){
                        return $row->owner->phone_number;
                    })
                    ->addColumn('amount', function($row){
                        return $formattedPrice = 'Rp '.number_format($row->amount, 2, ',', '.');
                    })
                    ->addColumn('status', function($row){
                        switch($row->status){
                            case RedeemStatus::ACCEPTED:
                                return "<span class='accepted_redeem_status'>Accepted</span>";
                            case RedeemStatus::REJECTED:
                                return "<span class='rejected_redeem_status'>Rejected</span>";
                            case RedeemStatus::WAITING:
                                return "<span class='waiting_redeem_status'>Waiting</span>";
                        }
                    })
                    ->addColumn('action', function($row){
                            if($row->status == RedeemStatus::WAITING){
                                $acceptBtn = '<div class="col-6">'
                                .'<form action="'.url('admin/redeem/accept').'" method="post">'
                                .'<input type="hidden" name="redeem_id" value="'.$row->id.'" />'
                                .csrf_field()
                                .'<button class="btn btn-success btn-small" type="submit">'
                                .'<i class="fas fa-check" style="width:20px"></i>'
                                .' Accept'
                                .'</button>'
                                .'</form>'
                                .'</div>';

                                $rejectBtn = '<div class="col-6">'
                                .'<form action="'.url('admin/redeem/reject').'" method="post">'
                                .'<input type="hidden" name="redeem_id" value="'.$row->id.'" />'
                                .csrf_field()
                                .'<button class="btn btn-danger btn-small">'
                                .'<i class="fas fa-times" style="width:20px"></i>'
                                .' Reject'
                                .'</button>'
                                .'</form>'
                                .'</div>';
                                $action = '<div class="row">'.$acceptBtn.$rejectBtn.'</div>';
                                return $action;
                            }
                            return "";
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
        }
        return view('admin.redeem');
    }

    public function accept(Request $request){
        $redeem = Redeem::find($request->redeem_id);
        $redeem->status = RedeemStatus::ACCEPTED;
        $redeem->update();  
        return back();
    }

    public function reject(Request $request){
        $redeem = Redeem::find($request->redeem_id);
        $redeem->status = RedeemStatus::REJECTED;
        $franchise = Franchise::find($redeem->franchise_id);
        $franchise->amount += $redeem->amount;
        $redeem->update();  
        $franchise->update();
        return back();
    }
}
