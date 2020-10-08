<?php

namespace App\Http\Controllers;

use App\Classes\ListBuilder;
use App\Models\Author;
use App\Models\News;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function list(Request $request)
    {
        $list = (new ListBuilder($request))->getList()->paginate(7)->withPath("?" . $request->getQueryString());
        $authors = Author::select('id', 'name')->get();
        return view('list', compact('list', 'authors'));
    }

    public function news($news_id)
    {
        $info = News::where('news.id', $news_id)->leftJoin('authors', 'news.author_id', '=',
            'authors.id')->select('news.name', 'news.content', 'news.date', 'news.author_id', 'authors.rating',
            'authors.name as author_name')->first();
        $info['count_news'] = count(News::where('author_id', $info['author_id'])->get());
        return view('news', compact('info'));
    }
}
