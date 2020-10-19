<?php

namespace App\Classes;

use App\Models\News;
use Illuminate\Http\Request;

class ListBuilder
{
    private $params;
    private $list;

    public function __construct(Request $request)
    {
        $this->params = $request;
        $this->basicQuery()->checkAuthor()->checkDateFrom()->checkDateTo()->checkNewsTitle();
    }

    public function getList()
    {
        return $this->list;
    }

    private function basicQuery()
    {
        $this->list = News::leftJoin('authors', 'news.author_id', '=', 'authors.id')->select('news.id', 'news.name',
            'news.announce', 'news.date', 'authors.name as author_name');
        return $this;
    }

    private function checkAuthor()
    {
        if($this->params['author'] > 0){
            $this->list = $this->list->where('author_id', $this->params['author']);
        }
        return $this;
    }

    private function checkDateFrom()
    {
        if(!is_null($this->params['dateFrom'])){
            $this->list = $this->list->where('date', '>=', $this->params['dateFrom']);
        }
        return $this;
    }

    private function checkDateTo()
    {
        if(!is_null($this->params['dateTo'])){
            $this->list = $this->list->where('date', '<=', $this->params['dateTo']);
        }
        return $this;
    }

    private function checkNewsTitle()
    {
        if(!is_null($this->params['newsSearch'])){
            $this->list = $this->list->where('news.name', 'like', '%' . $this->params['newsSearch'] . '%');
        }
        return $this;
    }
}
