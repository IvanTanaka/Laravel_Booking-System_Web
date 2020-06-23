<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = Auth::user();
        $bank_accounts = BankAccount::whereHas('owner', function($query) use($user){
            return $query->where('id',$user->id);
        })
        ->where('is_deleted', false)
        ->get();
        return view('owner.bank_account.index', compact(['bank_accounts']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('owner.bank_account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        $bank_account = BankAccount::where('owner_id',$user->id)->update(['is_default'=> false]);
        $bank_account = new BankAccount();
        $bank_account->owner_id = $user->id;
        $bank_account->name = $request->bank_account_name;
        $bank_account->bank = $request->bank_account_bank;
        $bank_account->account_number = $request->bank_account_number;
        $bank_account->is_default = true;
        $bank_account->save();

        return redirect()->route('bank-account.index')
        ->with('success','Bank Account added successfully.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $bank_account = BankAccount::find($id);
        return view('owner.bank_account.edit', compact(['bank_account']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = Auth::user();
        $bank_account = BankAccount::where('owner_id',$user->id)->update(['is_default'=> false]);
        $bank_account = BankAccount::find($id);
        $bank_account->name = $request->bank_account_name;
        $bank_account->bank = $request->bank_account_bank;
        $bank_account->account_number = $request->bank_account_number;
        $bank_account->is_default = true;
        $bank_account->save();

        return redirect()->route('bank-account.index')
        ->with('success','Bank Account edited successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $bank_account = BankAccount::find($id);
        $bank_account->is_deleted = true;
        $bank_account->is_default = false;
        $bank_account->update();
        $user = Auth::user();
        $bank_account = BankAccount::where('owner_id',$user->id)
        ->where('is_deleted', false)
        ->latest()
        ->first()
        ->update(['is_default'=>true]);
        return redirect()->route('bank-account.index');
    }

    public function setDefault(Request $request){
        $user = Auth::user();
        $bank_account = BankAccount::where('owner_id',$user->id)->update(['is_default'=>false]);
        $bank_account = BankAccount::find($request->bank_account_id);
        $bank_account->is_default = true;
        $bank_account->update();
        
    }
}
