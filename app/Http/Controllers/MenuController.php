<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Auth;
use DataTables;
use function App\Helpers\generateUuid;

class MenuController extends Controller
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
            $data = Menu::whereHas('franchise', function($query) use($user){
                $query->where('owner_id','=',$user->id);
            })
            ->where('is_deleted',false)
            ->latest()->get();
            
            
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('price_format', function($row){
                $formattedPrice = 'Rp '.number_format($row->price, 2, ',', '.');
                return $formattedPrice;
            })
            ->addColumn('action', function($row){
                $deleteBtn = '<a class="p-1">'
                .'<button class="btn btn-danger btn-small" data-target="#deleteConfirmation" data-toggle="modal" data-id="'.$row->id.'" data-name="'.$row->name.'">'
                .'<i class="fas fa-trash" style="width:20px"></i>'
                .' Delete'
                .'</button>'
                .'</a>';
                $viewBtn = '<a href="'.url('menus/'.$row->id).'" class="p-1">'
                .'<button class="btn btn-primary btn-small">'
                .'<i class="fas fa-eye" style="width:20px"></i>'
                .' View'
                .'</button>'
                .'</a>';
                $editBtn = '<a href="'.url('menus/' . $row->id . '/edit').'" class="p-1">'
                .'<button class="btn btn-small btn-info">'
                .'<i class="fas fa-edit" style="width:20px"x></i>'
                .' Edit'
                .'</button>'
                .'</a>';
                $action = $editBtn.$deleteBtn;
                return $action;
            })
            ->rawColumns(['action', 'price_format'])
            ->make(true);
        }
        return view('owner.menus.index');
        
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
        return view('owner.menus.create');
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
        
        $menu = new Menu;
        $menu->franchise_id = $user->franchise->id;
        $menu->name = $request->menu_name;
        $menu->description = $request->menu_description;
        $menu->price = $request->menu_price;

        $file = $request->file('menu_image');
        // Check if image file  Exist then insert to database table
        if($file!=null){
            $path = "public/images/menu/";
            $menu->image_path = generateUuid().".".$file->getClientOriginalExtension();
        }

        $menu->save();
        
        // Check if image file Exist save to storage
        if($file!=null){
            $file->storeAs($path,$menu->image_path);
        }
        
        
        return redirect()->route('menus.index')
        ->with('success','Menu added successfully.');
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
        $menu = Menu::with('franchise')->find($id);
        return view('owner.menus.edit', compact('menu'));
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
        $menu = Menu::find($id);
        $menu->name = $request->menu_name;
        $menu->description = $request->menu_description;
        $menu->price = $request->menu_price;

        $path = "public/images/menu/";
        $oldFileName = $menu->image_path;
        
        $file = $request->file('menu_image');
        // Check if image file Exist then insert to database table
        if($file!=null){
            //Check if image is not remove then insert new image to database;
            if($request->menu_image_remove == "false"){
                $menu->image_path = generateUuid().$file->getClientOriginalExtension();
            }else{
                $menu->image_path = null;
            }
        }elseif($request->menu_image_remove == "true"){
            $menu->image_path = null;
        }
        $menu->update();
        
        // Check if image file Exist save to storage
        if($file!=null){
            Storage::delete($path.$oldFileName);
            $file->storeAs($path,$menu->image_path);
        }elseif($request->menu_image_remove == "true"){
            Storage::delete($path.$oldFileName);
        }

        
        return redirect()->route('menus.index')
        ->with('success','Menu edited successfully.');
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
        $menu = Menu::with('franchise')->find($id);
        $path = "public/images/menu/";
        Storage::delete($path.$menu->image_path);

        $menu->is_deleted = true;
        $menu->update();

        return redirect()->route('menus.index')
                        ->with('success', 'Menu deleted successfully.');
    }
}
