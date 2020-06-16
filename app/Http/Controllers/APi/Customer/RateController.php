<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rate;
use App\Models\Customer;
use App\Models\Order;
use App\Enums\OrderStatus;
use function App\Helpers\api_response;

class RateController extends Controller
{
    //
    public function create(Request $request,$order_id){
        $token = $request->bearerToken();
        $user = Customer::where('api_token', $token)->first();
        $order = Order::with('rate')->find($order_id);
        if($order->status == OrderStatus::FINISHED && $order->customer_id == $user->id && $order->rate == null){
            $rate = new Rate();
            $rate->order_id = $order_id;
            $rate->customer_id = $user->id;
            $rate->branch_id = $order->branch_id;
            $rate->stars = $request->stars;
            $rate->comment = $request->comment;
            $rate->save();
        }

        $order = Order::with('order_details.menu','branch.franchise','cashier', 'rate')->find($order_id);

        return api_response(true, 200,"Success.",$order);
    }
}
