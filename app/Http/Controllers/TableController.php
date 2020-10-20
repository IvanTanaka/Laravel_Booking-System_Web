<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Table;
use App\Models\Branch;
use App\Models\Franchise;
use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->branch_id==null){
            if($request->ajax()){
            $user = Auth::user();
            $franchise = Franchise::where('owner_id',$user->id)->with([
                'branches' => function ($query){
                    $query->where('is_deleted',false);
                }
            ])
            ->get()
            ->first();
            $branches = $franchise->branches;
                return DataTables::of($branches)
                    ->addIndexColumn()
                    ->addColumn('name',function($row){
                                $showBtn = '<a href="'.route('table.index',['branch_id'=>$row->id]).'" class="p-1">'
                                .'<button class="btn btn-small">'
                                .$row->name
                                .'</button>'
                                .'</a>';
                                return $showBtn;
                    })->rawColumns(['name'])->make(true);
            }
            return view('table.index');
        }else{
            if($request->ajax()){

            $tables = Table::where('branch_id',$request->branch_id)->latest()->get();
            return DataTables::of($tables)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                            $deleteBtn = '<a class="p-1">'
                            .'<button class="btn btn-danger btn-small" data-target="#deleteConfirmation" data-toggle="modal" data-id="'.$row->id.'" data-name="'.$row->name.'">'
                            .'<i class="fas fa-trash" style="width:20px"></i>'
                            .' Delete'
                            .'</button>'
                            .'</a>';
                            $editBtn = '<a href="'.url('table/' . $row->id . '/edit').'" class="p-1">'
                            .'<button class="btn btn-small btn-info">'
                            .'<i class="fas fa-edit" style="width:20px"x></i>'
                            .' Edit'
                            .'</button>'
                            .'</a>';
                            $action = $editBtn.$deleteBtn;
                            return $action;
                })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        return view('table.show');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $branch_id = $request->branch_id;
        $franchise = Franchise::where('owner_id',$user->id)->with([
            'branches' => function ($query){
                $query->where('is_deleted',false);
            }
        ])
        ->get()
        ->first();
        $branches = $franchise->branches;
        $tables = Table::all()->where('branch_id',$request->branch_id);
        return view('table.create',compact('branches','branch_id','tables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $selectedBranch = $request->get('branches');

        Validator::make($request->all(),[
            'number'=>[
                'required',
                Rule::unique('tables')->where(function($query) use($selectedBranch){
                    $query->where('deleted_at', null)->where('branch_id', $selectedBranch);
                })
            ],
            'size'=>'required'
        ])->validate();

        $table = new Table(['branch_id'=> $selectedBranch,'number'=>$request->number, 'size'=> $request->size]);
        $table->save();
        return redirect(route('table.index',['branch_id'=>$selectedBranch]))->with('success','Table created succesfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $selectedBranch = $request->get('branch_id');
        $tables = Table::findOrFail($id);
        if($request->number == $tables->number){
            Validator::make($request->all(),[
                'number'=>
                    'required',
                'size'=>'required'
            ])->validate();
        }else{
            Validator::make($request->all(),[
                'number'=>[
                    'required',
                    Rule::unique('tables')->where(function($query) use($selectedBranch){
                        $query->where('deleted_at', null)->where('branch_id', $selectedBranch);
                    })
                ],
                'size'=>'required'
            ])->validate();
        }

        $tables->update(['number'=>$request->number, 'size'=>$request->size]);
        return redirect(route('table.index',['branch_id'=>$request->branch_id]))->with('success','Table updated succesfully.');

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
        return redirect()->route('table.index',['branch_id'=>$tables->branch_id])
                        ->with('success', 'Table deleted successfully.');
    }

}
