<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Franchise;
use App\Models\Wallet;
use App\Enums\OrderStatus;
use Carbon\Carbon;
use function App\Helpers\api_response;

class OrderController extends Controller
{
    //
    public function index(Request $request){
        $token = $request->bearerToken();
        $no_responses = Order::whereHas('customer', function($query) use($token){
            $query->where('api_token',$token);
        })
        ->where('cashier_id',null)
        ->where('status', OrderStatus::WAITING)
        ->whereDate('reserve_time','<',Carbon::now())
        ->get();
        foreach($no_responses as $no_response){
            $no_response->status = OrderStatus::NO_RESPONSE;
            $no_response->update();
            $wallet = Wallet::where('customer_id',$no_response->customer_id)->first();
            $wallet->amount += $no_response->total;
            $wallet->update();
        }

        $finisheds = Order::whereHas('customer', function($query) use($token){
            $query->where('api_token',$token);
        })->where('status', OrderStatus::ACCEPTED)
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

        $order = Order::with('branch.franchise')->whereHas('customer', function($query) use($token){
            $query->where('api_token',$token);
        })->orderBy('reserve_time','desc')->paginate(10);
        return api_response(true, 200,"Success.",$order);
    }

    public function view(Request $request, $order_id){
        $token = $request->bearerToken();
        $order = Order::with('order_details.menu','branch.franchise','cashier')->find($order_id);
        if($order->cashier_id == null && 
        $order->status == OrderStatus::WAITING && 
        Carbon::parse($order->reserve_time)->lte(Carbon::now()->addHours(7))){
            $order->status = OrderStatus::NO_RESPONSE;
            $order->update();
            $wallet = Wallet::whereHas('customer',function($query) use($token){
                $query->where('api_token',$token);
            })->first();
            $wallet->amount += $order->total;
            $wallet->update();
        }else if($order->status == OrderStatus::ACCEPTED && 
        Carbon::parse($order->reserve_time)->lte(Carbon::now()->addHours(7))){
            $order->status = OrderStatus::FINISHED;
            $order->update();
            $franchise = Franchise::find($order->franchise_id);
            $franchise->amount += $order->total;
            $franchise->update();
        }
        return api_response(true, 200,"Success.",$order);
    }
    
    public function submit(Request $request){
        $token = $request->bearerToken();
        $user = Customer::where('api_token', $token)->first();
        $branch = Branch::with('franchise')->find($request->branch_id);
        $order = new Order();
        $order->customer_id = $user->id;
        $order->branch_id = $branch->id;
        $order->franchise_id = $branch->franchise->id;
        $order->people_count = $request->people_count;
        $order->total = $request->total;
        $order->status = OrderStatus::WAITING;
        $order->reserve_time = Carbon::parse($request->reserve_time);
        $order->save();

        foreach($request->carts as $cart){
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->id;
            $order_detail->menu_id = $cart["id"];
            $order_detail->price = $cart["price"];
            $order_detail->qty = $cart["qty"];
            $order_detail->subtotal = ($cart["price"]*$cart["qty"]);
            $order_detail->save();
        }
        $order = Order::with('order_details')->find($order->id);
        $wallet = Wallet::where('customer_id', $user->id)->first();
        $wallet->amount -= $order->total;
        $wallet->update();
        return api_response(true, 200,"Success.",$order);
    }
    
    public function cancel($order_id, Request $request){
        $token = $request->bearerToken();
        $user = Customer::where('api_token', $token)->first();
        $order = Order::find($order_id);
        if($order->status == OrderStatus::WAITING){
            $order->status = OrderStatus::CANCELED;
            $order->update();
            $wallet = Wallet::where('customer_id', $user->id)->first();
            $wallet->amount += $order->total;
            $wallet->update();
        }
        return api_response(true, 200,"Success.",$order);
    }

    public function finish($order_id, Request $request){
        $token = $request->bearerToken();
        $order = Order::find($order_id);
        if($order->status == OrderStatus::ACCEPTED){
            $order->status = OrderStatus::FINISHED;
            $order->update();
            $franchise = Franchise::find($order->franchise_id);
            $franchise->amount += $order->total;
            $franchise->update();
        }
        return api_response(true, 200,"Success.",$order);
    }
}
