<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Branch;
use App\Enums\OrderStatus;
use Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        //
        //  Change order status to no response and finished
        //
        Order::whereHas('franchise', function($query) use($user){
            $query->where('owner_id', $user->id);
        })->where('cashier_id',null)->where('status', OrderStatus::WAITING)->whereDate('reserve_time','<',Carbon::now())->update([
            'status' => OrderStatus::NO_RESPONSE
        ]);
        Order::whereHas('franchise', function($query) use($user){
            $query->where('owner_id', $user->id);
        })->where('status', OrderStatus::ACCEPTED)->whereDate('reserve_time','<=',Carbon::now())
        ->whereTime('reserve_time','<=', Carbon::now()->addHours(7))->update([
            'status' => OrderStatus::FINISHED
        ]);
        //


        //
        //Sales Amount for 12 months
        //
        $monthlySalesData = Order::whereHas('franchise', function($query) use ($user){
            $query->where('owner_id', $user->id);
        })->whereDate('reserve_time','>=', Carbon::now()->subYear())
        ->where('status', OrderStatus::FINISHED)
        ->orderBy('reserve_time')
        ->get()
        ->groupBy(function($d) {
            return Carbon::parse($d->reserve_time)->format('F Y');
        });

        $monthlySalesCount = [];
        $monthlyArr = [];

        foreach ($monthlySalesData as $key => $value) {
            $monthlySalesCount[$key] = count($value);
        }

        for($i = 0; $i <= 11; $i++){
            $key = Carbon::now()->subMonth($i)->format('F Y');
            if(!empty($monthlySalesCount[$key])){
                $monthlyArr[$key] = $monthlySalesCount[$key];    
            }else{
                $monthlyArr[$key] = 0;    
            }
        }
        $monthlyArr = array_reverse($monthlyArr);
        //

        //
        // Best Selling Menu
        //

        $bestSellingMenu = Menu::whereHas('franchise', function($query) use($user){
            $query->where('owner_id', $user->id);
        })
        ->withCount('orderDetails')
        ->orderBy('order_details_count', 'desc')
        ->limit(5)
        ->get();

        //
        // Best Sales Branch Store
        //

        $bestBranch = Order::whereHas('franchise', function($query) use($user){
            $query->where('owner_id', $user->id);
        })
        ->where('status', OrderStatus::FINISHED)
        ->with('branch')
        ->get()
        ->groupBy('branch.name');
        foreach($bestBranch as $key=>$value){
            $bestBranch[$key] = count($value);
        }
        //
        
        return view('owner.sales.index',compact(['monthlyArr', 'bestSellingMenu', 'bestBranch']));
    }
}
