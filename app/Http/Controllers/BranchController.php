<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Auth;
use DataTables;

class BranchController extends Controller
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
            $data = Branch::with(['franchise' => function($userId) use($user){
                        $userId->where('user_id',$user->id);
                    }])
                    ->latest()->get();


            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $deleteBtn = '<form style="display:inline-block !important;"action="'.url('stores/'.$row->id).'" method="post">'
                            .'<div class="p-1">'
                            .'<button class="btn btn-danger btn-small" type="submit">'
                            .'<i class="fas fa-trash" style="width:20px"></i>'
                            .' Delete'
                            .'</button>'
                            .'<input type="hidden" name="_method" value="DELETE" />'
                            .csrf_field()
                            .'</div>'
                            .'</form>';
                            $viewBtn = '<a href="'.url('stores/'.$row->id).'" class="p-1">'
                            .'<button class="btn btn-primary btn-small">'
                            .'<i class="fas fa-eye" style="width:20px"></i>'
                            .' View'
                            .'</button>'
                            .'</a>';
                            $editBtn = '<a href="'.url('stores/' . $row->id . '/edit').'" class="p-1">'
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
        return view('stores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
