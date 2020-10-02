<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Table;
use App\Models\Branch;
use App\Models\Franchise;
use DataTables;
use Illuminate\Database\Eloquent\Builder;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Table::whereHas('branch', function($query) use( $branch_id ){ $query->where('id',$branch_id);})->get();
        // $branches = $franchise->branches;
        // $tables = Table::whereHas('branch_id',$branches->id);
        $user = Auth::user();

        $branch_id = Branch::all();
        $franchise = Franchise::where('owner_id',$user->id)->with([
            'branches' => function ($query){
                $query->where('is_deleted',false);
            }
        ])
        ->get()
        ->first();
        $branches = $franchise->branches;
        $tables = Table::all();
        return view('table.index',compact('tables','branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tables = Table::all();
        return view('table.create',compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $table = new Table(['number'=>$request->number, 'size'=> $request->size, 'branch_id'=> $request->branch_id]);
        $table = new Table(['branch_id'=>'30fdfb50-02ef-11eb-819a-6fef213b2d4b', 'number'=>'A5', 'size'=>'5' ]);
        $table->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tables = Table::all()->where('branch_id',$id);
        return view('table.show',compact('tables'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $table = Table::findOrFail($id);
        return view('table.edit',compact('table'));
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
        $tables = Table::findOrFail($id);
        // $tables->update(['number'=>$request->number, 'size'=>$request->size]);
        $tables->update(['number'=>'A2', 'size'=>5]);
        return redirect()->route('/')
                        ->with('success','Table updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tables = Table::findOrFail($id);
        $tables->delete();
        return redirect()->route('table.index')
                        ->with('success', 'Table deleted successfully.');
    }

}
