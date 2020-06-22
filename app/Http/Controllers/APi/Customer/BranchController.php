<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use function App\Helpers\api_response;

class BranchController extends Controller
{
    //
    public function view($branch_id){
        $branch = Branch::with('franchise')->where('is_deleted',false)->find($branch_id);
        return api_response(true, 200,"Success.",$branch);
    }

}
