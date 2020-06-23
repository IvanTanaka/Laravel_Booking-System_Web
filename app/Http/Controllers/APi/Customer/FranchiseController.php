<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Franchise;
use function App\Helpers\api_response;
use DB;

class FranchiseController extends Controller
{
    //
    public function search(Request $request){
        $name = $request->name;
        $category = $request->category;
        
        $franchise = Franchise::where(function($q) use($name){
            $q->whereHas('branches',function($query) use($name){
                // Search by branch name
                $query->where('is_deleted',false)->where('name',"like","%".$name."%");
            })
            ->orWhereHas('menus',function($query) use($name){
                // Search by menu name
                $query->where('is_deleted',false)->where('name',"like","%".$name."%");
            })
            // Search by franchise name
            ->orWhere('franchises.name',"like","%".$name."%");
        })
        ->with([
            'branches' => function ($query){
                $query->where('is_deleted',false);
                $query->with('rates');
            },
        ]);
        if($category != null){
            $franchise = $franchise->whereNotNull('category_id')
            ->whereHas('category', function($query) use($category){
                $query->where('slug',$category);
            });
        }
        $franchise = $franchise->leftJoin('branches','franchise_id','franchises.id')
        ->leftJoin('rates','branch_id','branches.id')
        ->select('franchises.name','franchises.id',DB::raw('CAST(AVG(rates.stars) AS DECIMAL(10,2)) as rating_stars'))
        ->groupBy('franchises.name','franchises.id')
        ->orderBy('rating_stars','desc')
        ->paginate(10);

        
        return api_response(true, 200,"Success.",$franchise);
    }

}
