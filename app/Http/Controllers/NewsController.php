<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Auth;
use DataTables;
use function App\Helpers\generateUuid;

class NewsController extends Controller
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
            $data = News::whereHas('franchise', function($query) use($user){
                $query->where('owner_id','=',$user->id);
            })
            ->latest()->get();
            
            
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('created', function($row){
                return date("d M Y H:i:s", strtotime($row->created_at));
            })
            ->addColumn('image', function($row){
                return '<img src="/storage/images/news/'.$row->image_path.'"/ style="height:300px; width:300px">';
            })
            ->addColumn('action', function($row){
                $deleteBtn = '<a class="p-1">'
                .'<button class="btn btn-danger btn-small" data-target="#deleteConfirmation" data-toggle="modal" data-id="'.$row->id.'" data-name="'.$row->name.'">'
                .'<i class="fas fa-trash" style="width:20px"></i>'
                .' Delete'
                .'</button>'
                .'</a>';
                $viewBtn = '<a href="'.url('news/'.$row->id).'" class="p-1">'
                .'<button class="btn btn-primary btn-small">'
                .'<i class="fas fa-eye" style="width:20px"></i>'
                .' View'
                .'</button>'
                .'</a>';
                $editBtn = '<a href="'.url('news/' . $row->id . '/edit').'" class="p-1">'
                .'<button class="btn btn-small btn-info">'
                .'<i class="fas fa-edit" style="width:20px"x></i>'
                .' Edit'
                .'</button>'
                .'</a>';
                $action = $editBtn.$deleteBtn;
                return $action;
            })
            ->rawColumns(['action', 'image','price_format'])
            ->make(true);
        }
        return view('owner.news.index');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('owner.news.create');
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
        $user->with('franchise')->get();
        
        $news = new News;
        $news->franchise_id = $user->franchise->id;
        $news->description = $request->news_description;

        $file = $request->file('news_image');
        $path = "public/images/news/";
        $news->image_path = generateUuid().".".$file->getClientOriginalExtension();

        $news->save();
        
        $file->storeAs($path,$news->image_path);
        
        
        return redirect()->route('news.index')
        ->with('success','News added successfully.');
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
        $news = News::with('franchise')->find($id);
        return view('owner.news.edit', compact('news'));
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
        $news = News::find($id);
        $news->description = $request->news_description;
        $news->update();
        
        return redirect()->route('news.index')
        ->with('success','News edited successfully.');
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
        $news = News::with('franchise')->find($id);
        $path = "public/images/news/";
        Storage::delete($path.$news->image_path);

        $news->delete($id);

        return redirect()->route('news.index')
                        ->with('success', 'News deleted successfully.');
    }
}
