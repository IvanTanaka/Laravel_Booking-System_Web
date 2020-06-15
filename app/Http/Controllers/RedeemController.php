<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Franchise;
use App\Models\Redeem;

class RedeemController extends Controller
{
    //
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
        $franchise = Franchise::where('owner_id', $user->id)->first();
        $redeem = Redeem::whereHas('franchise', function($query) use($user){
            $query->where('owner_id', $user->id);
        })->get();
        return view('owner.redeem.index', compact(['franchise', 'redeem']));
    }
}
