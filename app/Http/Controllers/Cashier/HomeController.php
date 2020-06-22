<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cashier;
use App\Models\Rate;
use App\Models\Order;
use App\Enums\OrderStatus;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
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
    public function index()
    {
        $user = Cashier::with(['franchise'])->find(Auth::id());

        $rateTotal =Rate::whereHas('branch', function($query) use($user){
            $query->where('id',$user->branch_id);
        })->avg('stars');
        $todaySale = Order::whereHas('branch', function($query) use ($user){
            $query->where('id', $user->branch_id);
        })->whereDate('reserve_time', Carbon::now()->addHours(7))
        ->where('status', OrderStatus::FINISHED)
        ->count();

        return view('cashier.dashboard', compact('rateTotal', 'todaySale'));
    }
}
