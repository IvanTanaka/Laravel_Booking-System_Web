<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\ServiceType;
use App\Models\Franchise;
use App\Models\Branch;
use function App\Helpers\convertToTime;
use Auth;

class FranchiseController extends Controller
{
    //
    public function create(){
        return view('register_franchise', ['service_type' => ServiceType::getAll]);
    }


    public function store(Request $request){
        $this->validate($request, [
            'store_phone_number' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/'],
        ]);

        $user = Auth::user();
        $franchise =  new Franchise();
        $franchise->id = uniqid();
        $franchise->owner_id = $user->id;
        $franchise->name = $request->franchise_name;
        $franchise->type = $request->franchise_type;
        $franchise->save();
        
        $branch = new Branch();
        $branch->id = uniqid();
        $branch->franchise_id = $franchise->id;
        $branch->name = $request->franchise_name;
        $branch->address = $request->store_address;
        $branch->phone_number = $request->store_phone_number;
        $branch->open_time = convertToTime($request->store_open_time);
        $branch->close_time = convertToTime($request->store_close_time);
        $branch->save();

        return redirect('login')->with('alert-success','Register success.');
    }
}
