<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Franchise;
use DataTables;

class CategoryController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request){
        $categories = Category::all();
        
        if ($request->ajax()) {
            
            $data = Franchise::with(['category','branches', 'owner'])
            ->latest()
            ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('owner_name', function($row){
                        return $row->owner->name;
                    })
                    ->addColumn('owner_phone_number', function($row){
                        return $row->owner->phone_number;
                    })
                    ->addColumn('category_select', function($row) use($categories){
                        $select = '<select class="custom-select category-select" onChange = setCategory(this,"'.$row->id.'")>';
                        $select = $select.'<option  '.(($row->category==null)?'selected':'').'>No Category</option>';
                        foreach ($categories as  $category) {
                          $select =$select.'<option  '.(($row->category!=null && $row->category->id == $category->id)?'selected':'').' value="'.$category->id.'">'.$category->name.'</option>';
                        }    
                        $select =$select.'</select>';
                        return $select;
                    })
                    ->rawColumns(['category_select'])
                    ->make(true);
        }
        return view('admin.category');
    }

    public function update(Request $request){
        $franchise = Franchise::find($request->franchise_id);
        $franchise->category_id = $request->category_id;
        $franchise->update();
        return $franchise;
    }
}
