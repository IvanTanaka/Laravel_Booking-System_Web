<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Franchise;
use function App\Helpers\api_response;

class FranchiseController extends Controller
{
    //
    public function search(Request $request){
        $name = $request->name;
        $franchise = Franchise::where('name',"like","%".$name."%")->with('branches')->paginate(10);
        
        return api_response(true, 200,"Success.",$franchise);
    }

}
