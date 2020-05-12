<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Branch;
use function App\Helpers\api_response;

class NewsController extends Controller
{
    //
    public function index(Request $request){
        $news = News::with('franchise')->paginate(10);
        
        return api_response(true, 200,"Success.",$news);
    }

    public function view(String $news_id){
        $news = News::with('franchise')->find($news_id);
        $news->branches = Branch::where('franchise_id',$news->franchise->id)->get(); 
        
        return api_response(true, 200,"Success.",$news);
    }
}
