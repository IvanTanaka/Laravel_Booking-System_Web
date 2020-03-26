<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cashier;
use Auth;
use DataTables;

class CashierController extends Controller
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
            $data = Cashier::with('branch')->whereHas('franchise', function($query) use($user){
                $query->where('user_id','=',$user->id);
            })
            ->latest()->get();
            
            
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('branch_name', function($row){
                return $row->branch->name;
            })
            ->addColumn('action', function($row){
                $deleteBtn = '<a class="p-1">'
                .'<button class="btn btn-danger btn-small" data-target="#deleteConfirmation" data-toggle="modal" data-id="'.$row->id.'" data-name="'.$row->name.'">'
                .'<i class="fas fa-trash" style="width:20px"></i>'
                .' Delete'
                .'</button>'
                .'</a>';
                $viewBtn = '<a href="'.url('cashiers/'.$row->id).'" class="p-1">'
                .'<button class="btn btn-primary btn-small">'
                .'<i class="fas fa-eye" style="width:20px"></i>'
                .' View'
                .'</button>'
                .'</a>';
                $editBtn = '<a href="'.url('cashiers/' . $row->id . '/edit').'" class="p-1">'
                .'<button class="btn btn-small btn-info">'
                .'<i class="fas fa-edit" style="width:20px"x></i>'
                .' Edit'
                .'</button>'
                .'</a>';
                $action = $editBtn.$deleteBtn;
                return $action;
            })
            ->rawColumns(['action', 'branch_name'])
            ->make(true);
        }
        return view('cashiers.index');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();
        $franchise = $user->franchise->with('branches')->get()->first();
        $branches = $franchise->branches;
        return view('cashiers.create',['branches'=>$branches]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        $cashier = new Cashier;
        $cashier->franchise_id = $user->franchise->id;
        $cashier->branch_id = $request->cashier_branch;
        $cashier->name = $request->cashier_name;
        $cashier->username = ($request->cashier_username).'_'.strtolower($user->franchise->name);
        $cashier->password = bcrypt($request->cashier_password);
        $cashier->save();


        return redirect()->route('cashiers.index')
        ->with('success','Cashier added successfully.');
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

        $user = Auth::user();
        $franchise = $user->franchise->with('branches')->get()->first();
        $branches = $franchise->branches;
        $cashier = Cashier::with('franchise')->find($id);
        return view('cashiers.edit',compact(['cashier','branches']));
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

        $user = Auth::user();
        $cashier = Cashier::find($id);
        $cashier->branch_id = $request->cashier_branch;
        $cashier->name = $request->cashier_name;
        $cashier->username = ($request->cashier_username).'_'.strtolower($user->franchise->name);
        $cashier->password = bcrypt($request->cashier_password);
        $cashier->update();


        return redirect()->route('cashiers.index')
        ->with('success','Cashier updated successfully.');
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
        $cashier = Cashier::destroy($id);

        return redirect()->route('cashiers.index')
                        ->with('success', 'Cashier deleted successfully.');
    }
}
