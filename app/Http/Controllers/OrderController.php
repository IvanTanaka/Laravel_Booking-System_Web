<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        //
        //Sales Amount for 12 months
        //
        $monthlySalesData = Order::whereHas('franchise', function($query) use ($user){
            $query->where('owner_id', $user->id);
        })->whereDate('reserve_time','>=', Carbon::now()->subYear())->orderBy('reserve_time')->get()->groupBy(function($d) {
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
        ->limit(10)
        ->get();
        
        return view('owner.sales.index',compact(['monthlyArr', 'bestSellingMenu']));
    }
}
