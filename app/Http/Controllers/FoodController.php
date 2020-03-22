<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Storage;
use Auth;
use DataTables;
use function App\Helpers\generateUuid;

class FoodController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $user = Auth::user();
            $data = Food::whereHas('franchise', function($query) use($user){
                $query->where('user_id','=',$user->id);
            })
            ->latest()->get();
            
            
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $deleteBtn = '<a class="p-1">'
                .'<button class="btn btn-danger btn-small" data-target="#deleteConfirmation" data-toggle="modal" data-id="'.$row->id.'" data-name="'.$row->name.'">'
                .'<i class="fas fa-trash" style="width:20px"></i>'
                .' Delete'
                .'</button>'
                .'</a>';
                $viewBtn = '<a href="'.url('foods/'.$row->id).'" class="p-1">'
                .'<button class="btn btn-primary btn-small">'
                .'<i class="fas fa-eye" style="width:20px"></i>'
                .' View'
                .'</button>'
                .'</a>';
                $editBtn = '<a href="'.url('foods/' . $row->id . '/edit').'" class="p-1">'
                .'<button class="btn btn-small btn-info">'
                .'<i class="fas fa-edit" style="width:20px"x></i>'
                .' Edit'
                .'</button>'
                .'</a>';
                $action = $editBtn.$viewBtn.$deleteBtn;
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('foods.index');
        
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
        return view('foods.create');
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user->with('franchise')->get();
        
        $food = new Food;
        $food->franchise_id = $user->franchise->id;
        $food->name = $request->food_name;
        $food->description = $request->food_description;
        $food->price = $request->food_price;

        $file = $request->file('food_image');
        // Check if image file  Exist then insert to database table
        if($file!=null){
            $path = "public/images/".$user->franchise->id.'/'.'menu/';
            $food->image_path = generateUuid().$file->getClientOriginalExtension();
        }

        $food->save();
        
        // Check if image file Exist save to storage
        if($file!=null){
            $file->storeAs($path,$food->image_path);
        }
        
        
        return redirect()->route('foods.index')
        ->with('success','Store added successfully.');
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
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
    }
}
