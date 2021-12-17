<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redis;


class FrontEndController extends Controller
{
    public function index()
    {
        $redisGet = Redis::connection('read');
        $redisWrite = Redis::connection('default');
        if ($redisGet->get('categories')) {
            $categories = json_decode($redisGet->get('categories'), true);
        } else {
            $categories = Category::all();
            $redisWrite->set('categories', json_encode($categories));
        }
        
        if ($redisGet->get('page:articles:index')) {
            $articlesRedis = json_decode($redisGet->get('articles'), true);
            // dd($categories, $redisGet->get('page:articles:index'));
            dd($articlesRedis['data']);
            dd($articlesRedis['current_page']);
            dd($articlesRedis['last_page']);
            dd($articlesRedis['per_page']);
            dd($articlesRedis['total']);
            $articles = new LengthAwarePaginator(array_values($articlesRedis['data']), $articlesRedis['total'], $articlesRedis['per_page'], $articlesRedis['current_page']);
        } else {
            $articles = Article::with(['category','author'])
                ->orderBy('date', 'desc')
                ->paginate(15);

            $redisWrite->set('page:articles:index', json_encode($articles));
        }
        dd($articles, $categories, $redisGet->get('page:articles:index'));

        return view('front.article.index', compact('articles', 'categories'));
    }

    public function searchArticle(Request $request)
    {
        $keyword = $request->query('q');
        $categories = Category::all();
        $articles = Article::with(['category','author'])
            ->where('headline', 'like', '%'.$keyword.'%')
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('front.article.search', compact('articles', 'categories', 'keyword'));
    }

    public function searchCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $categories = Category::all();
        $articles = Article::with(['category','author'])
            ->whereHas('category', function($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('front.category.index', compact('articles', 'categories', 'category'));
    }

    public function author(User $author)
    {
        $categories = Category::all();
        $articles = Article::with(['category','author'])
            ->whereHas('author', function($query) use ($author) {
                $query->where('id', $author->id);
            })
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('front.author.index', compact('articles', 'categories', 'author'));
    }
}
