<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Branch;
use App\Models\Franchise;
use App\Enums\OrderStatus;
use Auth;
use DataTables;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function index(Request $request)
    {
        $user = Auth::user();
        $franchise = Franchise::whereHas('owner', function($query) use($user){
            $query->where('owner_id',$user->id);
        })->first();
        $no_responses = Order::whereHas('franchise', function($query) use($franchise){
            $query->where('id','=',$franchise->id);
        })->where('cashier_id',null)->where('status', OrderStatus::WAITING)
        ->whereDate('reserve_time','<',Carbon::now())
        ->get();
        foreach($no_responses as $no_response){
            $no_response->status = OrderStatus::NO_RESPONSE;
            $no_response->update();
            $wallet = Wallet::where('customer_id',$no_response->customer_id)->first();
            $wallet->amount += $no_response->total;
            $wallet->update();
        }
        $finisheds = Order::whereHas('franchise', function($query) use($franchise){
            $query->where('id','=',$franchise->id);
        })
        ->where('status', OrderStatus::ACCEPTED)
        ->whereDate('reserve_time','<=',Carbon::now())
        ->whereTime('reserve_time','<=', Carbon::now()->addHours(7))
        ->get();

        foreach ($finisheds as $finished) {
            $finished->status = OrderStatus::FINISHED;
            $finished->update();
            $franchise = Franchise::find($finished->franchise_id);
            $franchise->amount += $finished->total;
            $franchise->update();
        }
        if ($request->ajax()) {
            
            $data = Order::with(['customer','order_details.menu','cashier','branch','rate'])->whereHas('franchise', function($query) use($franchise){
                $query->where('id','=',$franchise->id);
            })
            ->orderBy('reserve_time', 'desc')
            ->orderBy('created_at','desc')
            ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('customer', function($row){
                        return $row->customer->name;
                    })
                    ->addColumn('cashier', function($row){
                        return $row->cashier->name;
                    })
                    ->addColumn('branch', function($row){
                        return $row->branch->name;
                    })
                    ->addColumn('rate', function($row){
                        if($row->rate!=null){
                            return $row->rate->stars." <i class='fas fa-star'></i>";
                        }
                        return "";
                    })
                    ->addColumn('comment', function($row){
                        if($row->rate!=null){
                            return $row->rate->comment;
                        }
                        return "";
                    })
                    ->addColumn('status', function($row){
                        switch($row->status){
                            case OrderStatus::ACCEPTED:
                                return "<span class='accepted_order_status'>Accepted</span>";
                            case OrderStatus::DENIED:
                                return "<span class='denied_order_status'>Denied</span>";
                            case OrderStatus::WAITING:
                                return "<span class='waiting_order_status'>Waiting</span>";
                            case OrderStatus::NO_RESPONSE:
                                return "<span class='no_response_order_status'>No Response</span>";
                            case OrderStatus::CANCELED:
                                return "<span class='canceled_order_status'>Canceled</span>";
                            case OrderStatus::FINISHED:
                                return "<span class='finished_order_status'>Finished</span>";
                        }
                    })
                    ->addColumn('reserve_time', function($row){
                        return date('d M Y, H:i', strtotime($row->reserve_time));
                    })
                    ->addColumn('orders', function($row){
                        $orders = "<ul>";
                        foreach($row->order_details as $order_detail){
                            $orders = $orders."<li>".$order_detail->menu->name." (".$order_detail->qty.") </li>";
                        }
                        $orders =  $orders."</ul>";
                        return $orders;
                    })
                    ->addColumn('total', function($row){
                        $formattedPrice = 'Rp '.number_format($row->total, 2, ',', '.');
                        return $formattedPrice;
                    })
                    ->addColumn('dine_in_or_take_out', function($row){
                        if($row->people_count>0){
                            return "DINE IN (".$row->people_count.")";
                        }
                        return "TAKE OUT";
                    })
                    ->rawColumns(['orders', 'status', 'rate'])
                    ->make(true);
        }
        return view('owner.order.index');
    }
}
