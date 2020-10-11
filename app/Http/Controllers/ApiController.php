<?php

namespace App\Http\Controllers;

use App\Classes\ListBuilder;
use App\Models\Author;
use App\Models\News;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Rusbitech API Single Page Application ",
 *     version="1.0")
 * @OA\Tag(
 *     name="ApiController",
 *     description="Контроллер для передачи SPA данных в JSON-формате")
 * @OA\Server(
 *     url="http://rusbitech/api",
 *     description="Laravel Swagger API Server")
 */

class ApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/newsList",
     *     tags = {"ApiController"},
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Номер страницы:",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *          name="date_from",
     *          in="query",
     *          description="Дата публикации от: (вводить в формате YYYY-MM-DD, например 2020-10-7)",
     *          required=false,
     *          @OA\Schema(type="date")
     *     ),
     *     @OA\Parameter(
     *          name="date_to",
     *          in="query",
     *          description="Дата публикации до: (вводить в формате YYYY-MM-DD, например 2020-10-7)",
     *          required=false,
     *          @OA\Schema(type="date")
     *     ),
     *     @OA\Parameter(
     *          name="author",
     *          in="query",
     *          description="Автор публикации, доступные id-авторов указаны в JSON-ответе по этому запросу в массиве (authors)",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Сервер вернул 'список новостей'"),
     *     @OA\Response(response="404", description="Ресурс не найден"),
     *     @OA\Response(response="500", description="Внутренняя ошибка сервера")
     * )
     */

    public function newsList(Request $request)
    {
        $list = (new ListBuilder($request))->getList()->paginate(5)->withPath("?" . $request->getQueryString());
        $authors = Author::select('id', 'name')->get();
        return compact('list', 'authors');
    }

    /**
     * @OA\Get(
     *     path="/news/{news_id}",
     *     tags = {"ApiController"},
     *     @OA\Parameter(
     *          name="news_id",
     *          in="path",
     *          description="Id новости",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Сервер вернул 'список новостей'"),
     *     @OA\Response(response="404", description="Ресурс не найден"),
     *     @OA\Response(response="500", description="Внутренняя ошибка сервера")
     * )
     */

    public function news($news_id)
    {
        $info = News::where('news.id', $news_id)->leftJoin('authors', 'news.author_id', '=',
            'authors.id')->select('news.name', 'news.content', 'news.date', 'news.author_id', 'authors.rating',
            'authors.name as author_name')->first();
        $info['count_news'] = count(News::where('author_id', $info['author_id'])->get());
        return $info;
    }
}
