<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cashier;
use App\Models\Wallet;
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
        $this->middleware('auth:cashier');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    { 
        if ($request->ajax()) {
            $user = Cashier::with(['franchise'])->find(Auth::id());
            Order::whereHas('franchise', function($query) use($user){
                $query->where('id','=',$user->franchise->id);
            })->where('cashier_id',null)->where('status', OrderStatus::WAITING)->whereDate('reserve_time','<',Carbon::now())->update([
                'status' => OrderStatus::NO_RESPONSE
            ]);
            Order::whereHas('franchise', function($query) use($user){
                $query->where('id','=',$user->franchise->id);
            })->where('status', OrderStatus::ACCEPTED)->whereDate('reserve_time','<=',Carbon::now())
            ->whereTime('reserve_time','<=', Carbon::now()->addHours(7))->update([
                'status' => OrderStatus::FINISHED
            ]);
            if($request->is('cashier/today/order*')){
                $data = Order::with(['customer','order_details.menu'])->whereHas('branch', function($query) use($user){
                    $query->where('id','=',$user->branch->id);
                })
                ->where('reserve_time', '>',Carbon::parse('-24 hours'))
                ->orderBy('reserve_time', 'desc')
                ->orderBy('created_at','desc')
                ->get();
            }else{
                $data = Order::with(['customer','order_details.menu'])->whereHas('branch', function($query) use($user){
                    $query->where('id','=',$user->branch->id);
                })
                ->orderBy('reserve_time', 'desc')
                ->orderBy('created_at','desc')
                ->get();
            }

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('customer_name', function($row){
                        return $row->customer->name;
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
                    ->addColumn('action', function($row){
                            if($row->status == OrderStatus::WAITING){
                                $acceptBtn = '<a href="'.url('cashier/order/'.$row->id.'/accept').'" class="p-1">'
                                .'<button class="btn btn-success btn-small">'
                                .'<i class="fas fa-check" style="width:20px"></i>'
                                .' Accept'
                                .'</button>'
                                .'</a>';
                                $rejectBtn = '<a href="'.url('cashier/order/'.$row->id.'/reject').'" class="p-1">'
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
                    ->rawColumns(['action','orders', 'status'])
                    ->make(true);
        }
        return view('cashier.order');
    }

    public function accept($order_id){
        $order = Order::find($order_id);
        $order->cashier_id = Auth::id();
        $order->status = OrderStatus::ACCEPTED;
        $order->update();  
        return back();
    }

    public function reject($order_id){
        $order = Order::find($order_id);
        $order->cashier_id = Auth::id();
        $order->status = OrderStatus::DENIED;
        $order->update();  
        $wallet = Wallet::where('customer_id',$order->customer_id)->first();
        $wallet->amount += $order->total;
        $wallet->update();
        return back();
    }
}
