<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Redeem;
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
            
            $data = Redeem::with(['franchise','owner'])
            ->latest()
            ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
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
                                return "<span class='accepted_order_status'>Accepted</span>";
                            case RedeemStatus::REJECTED:
                                return "<span class='denied_order_status'>Rejected</span>";
                            case RedeemStatus::WAITING:
                                return "<span class='waiting_order_status'>Waiting</span>";
                        }
                    })
                    ->addColumn('action', function($row){
                            if($row->status == RedeemStatus::WAITING){
                                $acceptBtn = '<a href="'.url('admin/redeem/'.$row->id.'/accept').'" class="p-1">'
                                .'<button class="btn btn-success btn-small">'
                                .'<i class="fas fa-check" style="width:20px"></i>'
                                .' Accept'
                                .'</button>'
                                .'</a>';
                                $rejectBtn = '<a href="'.url('admin/redeem/'.$row->id.'/reject').'" class="p-1">'
                                .'<button class="btn btn-danger btn-small">'
                                .'<i class="fas fa-times" style="width:20px"></i>'
                                .' Reject'
                                .'</button>'
                                .'</a>';
                                $action = $acceptBtn.$rejectBtn;
                                return $action;
                            }
                            return "";
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
        }
        return view('admin.redeem');
    }

    public function accept($redeem_id){
        $redeem = Redeem::find($order_id);
        $redeem->status = Redeem::ACCEPTED;
        $redeem->update();  
        return back();
    }

    public function reject($redeem_id){
        $redeem = Redeem::find($order_id);
        $redeem->status = Redeem::REJECTED;
        $franchise = Franchise::find($redeem->franchise_id);
        $franchise->amount += $redeem->amount;
        $redeem->update();  
        $franchise->update();
        return back();
    }
}
