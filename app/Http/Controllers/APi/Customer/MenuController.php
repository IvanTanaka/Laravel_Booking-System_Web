<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use function App\Helpers\api_response;

class MenuController extends Controller
{
    //
    public function index(Request $request, $branch_id){
        $franchise = Menu::whereHas("franchise", function($query) use($branch_id){
            $query -> whereHas("branches", function($query) use($branch_id){
                $query->where('id', $branch_id);
            });
        })->paginate(10);
        
        return api_response(true, 200,"Success.",$franchise);
    }
}
