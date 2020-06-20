<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Franchise;
use function App\Helpers\convertToTime;
use function App\Helpers\generateUuid;
use Illuminate\Support\Facades\Storage;
use Auth;

class FranchiseController extends Controller
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

    public function index(){
        $user = Auth::user();
        $franchise = Franchise::whereHas('owner', function($query) use($user){
            $query->where('owner_id',$user->id);
        })->first();
        return view('owner.franchise', ['user' => $user, 'franchise' => $franchise ]);
    }

    public function update(Request $request){
        $user = Auth::user();
        $user->name = $request->owner_name;
        $user->email = $request->owner_email;
        $user->phone_number = $request->owner_phone_number;
        $user->update();

        $franchise = Franchise::whereHas('owner', function($query) use($user){
            $query->where('owner_id',$user->id);
        })->first();

        $franchise->name = $request->franchise_name;

        $path = "public/images/".$franchise->id."/";
        $oldFileName = $franchise->image_path;
        
        $file = $request->file('franchise_logo');
        // Check if image file Exist then insert to database table
        if($file!=null){
            //Check if image is not remove then insert new image to database;
            if($request->franchise_logo_remove == "false"){
                $franchise->image_path = generateUuid().$file->getClientOriginalExtension();
            }else{
                $franchise->image_path = null;
            }
        }elseif($request->franchise_logo_remove == "true"){
            $franchise->image_path = null;
        }
        $franchise->update();
        
        // Check if image file Exist save to storage
        if($file!=null){
            Storage::delete($path.$oldFileName);
            $file->storeAs($path,$franchise->image_path);
        }elseif($request->franchise_logo_remove == "true"){
            Storage::delete($path.$oldFileName);
        }


        $franchise->update();
        return view('owner.franchise', ['user' => $user, 'franchise' => $franchise ]);

    }

}
