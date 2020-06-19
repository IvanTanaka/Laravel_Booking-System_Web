<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Franchise;
use App\Models\Redeem;
use App\Models\BankAccount;
use App\Enums\RedeemStatus;

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
        $bank_account = BankAccount::where('owner_id', $user->id)->where('is_default', true)->first();
        return view('owner.redeem.index', compact(['franchise', 'redeem','bank_account']));
    }

    public function create(Request $request){
        $user = Auth::user();
        $franchise = Franchise::where('owner_id', $user->id)->first();
        $redeem = new Redeem();
        $redeem->owner_id = $user->id;
        $redeem->franchise_id = $franchise->id;
        $redeem->bank_account_id = $request->bank_account_id;
        $redeem->amount = $request->redeem_amount;
        $redeem->status = RedeemStatus::WAITING;
        $redeem->save();
        return redirect('redeem');
    }
}
