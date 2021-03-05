<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Knowledgebase\Entities\Knowledgebase;
use Modules\Knowledgebase\Events\ArticleViewed;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('kb');
    }
    public function index(Request $request)
    {
        return view('articles.list');
    }
    public function view(Knowledgebase $article)
    {
        $data['article'] = $article;
        event(new ArticleViewed($article));
        return view('articles.view')->with($data);
    }
}
