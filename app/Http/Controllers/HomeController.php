<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Branch;
use App\Models\Franchise;
use App\Models\Rate;
use App\Enums\OrderStatus;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        //
        //  Change order status to no response and finished
        //
        $no_responses = Order::whereHas('franchise', function($query) use($user){
            $query->where('owner_id', $user->id);
        })->where('cashier_id',null)->where('status', OrderStatus::WAITING)
        ->whereDate('reserve_time','<=',Carbon::now()->addHours(7))
        ->whereTime('reserve_time','<=', Carbon::now()->addHours(7))
        ->get();
        foreach($no_responses as $no_response){
            $no_response->status = OrderStatus::NO_RESPONSE;
            $no_response->update();
            $wallet = Wallet::where('customer_id',$no_response->customer_id)->first();
            $wallet->amount += $no_response->total;
            $wallet->update();
        }

        $finisheds = Order::whereHas('franchise', function($query) use($user){
            $query->where('owner_id', $user->id);
        })->where('status', OrderStatus::ACCEPTED)
        ->whereDate('reserve_time','<=',Carbon::now()->addHours(7))
        ->whereTime('reserve_time','<=', Carbon::now()->addHours(7))->get();
        foreach ($finisheds as $finished) {
            $finished->status = OrderStatus::FINISHED;
            $finished->update();
            $franchise = Franchise::find($finished->franchise_id);
            $franchise->amount += $finished->total;
            $franchise->update();
        }
        //


        //
        //Sales Amount for 12 months
        //
        $monthlySalesData = Order::whereHas('franchise', function($query) use ($user){
            $query->where('owner_id', $user->id);
        })->whereDate('reserve_time','>=', Carbon::now()->addHours(7)->subYear())
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
            $key = Carbon::now()->addHours(7)->subMonth($i)->format('F Y');
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

        $rateTotal =Rate::whereHas('branch.franchise', function($query) use($user){
            $query->where('owner_id',$user->id);
        })->avg('stars');
        
        $totalAmount = 'Rp. '.number_format(Franchise::where('owner_id', $user->id)->first()->amount, 2, ',', '.');

        $totalMenu = Menu::whereHas('franchise', function($query) use($user){
            $query->where('owner_id','=',$user->id);
        })->get()->count();

        $todaySale = Order::whereHas('franchise', function($query) use ($user){
            $query->where('owner_id', $user->id);
        })->whereDate('reserve_time', Carbon::now()->addHours(7))->where('status', OrderStatus::FINISHED)->count();

        return view('owner.dashboard',compact(['monthlyArr', 'bestSellingMenu', 'bestBranch', 'rateTotal', 'totalAmount', 'totalMenu','todaySale']));
    }
}
