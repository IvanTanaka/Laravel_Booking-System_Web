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
        
        $franchise = Franchise::whereHas('branches',function($query) use($name){
                        // Search by branch name
                        $query->where('name',"like","%".$name."%");
                    })
                    ->orWhereHas('menus',function($query) use($name){
                        // Search by menu name
                        $query->where('name',"like","%".$name."%");
                    })
                    // Search by franchise name
                    ->orWhere('name',"like","%".$name."%")
                    ->with('branches')
                    ->paginate(10);
        
        return api_response(true, 200,"Success.",$franchise);
    }

}
