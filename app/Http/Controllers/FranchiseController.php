<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\ServiceType;

class FranchiseController extends Controller
{
    //
    public function showRegisterFranchise(){
        return view('register_franchise', ['service_type' => ServiceType::getAll]);
    }


    public function registerFranchise(Request $request){
        $this->validate($request, [
            'store_phone_number' => 'required|phone_number',
        ]);

        $data =  new UserModel();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone_number = $request->phone_number;
        $data->password = bcrypt($request->password);
        $data->save();
        return redirect('login')->with('alert-success','Register success.');
    }
}
