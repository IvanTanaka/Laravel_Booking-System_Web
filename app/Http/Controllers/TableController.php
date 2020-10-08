<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTableRequest;
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
        // Table::whereHas('branch', function($query) use( $branch_id ){ $query->where('id',$branch_id);})->get();
        // $branches = $franchise->branches;
        // $tables = Table::whereHas('branch_id',$branches->id);
        if($request->branch_id==null){
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
        }else{

            $tables = Table::all()->where('branch_id',$request->branch_id);
            return view('table.show',compact('tables'));
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
        // $table = new Table(['branch_id'=>'30fdfb50-02ef-11eb-819a-6fef213b2d4b', 'number'=>'A5', 'size'=>'5' ]);
        $table->save();
        return redirect(route('table.index'));
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

        // $tables->update(['number'=>$request->number, 'size'=>$request->size]);
        $tables->update(['number'=>$request->number, 'size'=>$request->size]);
        return redirect(route('table.index',['branch_id'=>$request->branch_id]))->with('message','update success');

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
