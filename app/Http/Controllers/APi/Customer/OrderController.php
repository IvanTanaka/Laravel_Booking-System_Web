<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Branch;
use App\Enums\OrderStatus;
use function App\Helpers\api_response;

class OrderController extends Controller
{
    //
    public function index(Request $request){

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
        $order->reserve_time = \Carbon\Carbon::parse($request->reserve_time);
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
        return api_response(true, 200,"Success.",$order);
    }
}
