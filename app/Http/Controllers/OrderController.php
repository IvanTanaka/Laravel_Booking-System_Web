<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
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

        return view('owner.sales.index',compact(['monthlyArr']));
    }
}
