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
    public function __construct()
    {
        $this->redisGet = Redis::connection('read');
        $this->redisWrite = Redis::connection('default');

        if ($this->redisGet->get('categories')) {
            $categoriesRedis = json_decode($this->redisGet->get('categories'), true);
            $this->categories = Category::hydrate($categoriesRedis);
        } else {
            $this->categories = Category::all();
            $this->redisWrite->set('categories', json_encode($this->categories));
        }
    }

    public function index(Request $request)
    {
        $page = 1;
        $categories = $this->categories;

        if ($request->get('page')) {
            $page = $request->get('page');
        }
        
        if ($this->redisGet->get('page:articles:index' . $page)) {
            $articlesRedis = json_decode($this->redisGet->get('page:articles:index:' . $page), true);
            $collection = Article::hydrateWith($articlesRedis['data'], ['category', 'author']);
            $collection->flatten();
            $articles = new LengthAwarePaginator($collection, $articlesRedis['total'], $articlesRedis['per_page'], $articlesRedis['current_page']);
        } else {
            $articles = Article::with(['category','author'])
                ->orderBy('date', 'desc')
                ->paginate(15);

            $this->redisWrite->set('page:articles:index', json_encode($articles));
        }

        return view('front.article.index', compact('articles', 'categories'));
    }

    public function searchArticle(Request $request)
    {
        $categories = $this->categories;
        $keyword = $request->query('q');
        $articles = Article::with(['category','author'])
            ->where('headline', 'like', '%'.$keyword.'%')
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('front.article.search', compact('articles', 'categories', 'keyword'));
    }

    public function searchCategory(Request $request, $slug)
    {
        $page = 1;
        $categories = $this->categories;
        if ($request->get('page')) {
            $page = $request->get('page');
        }
        $category = Category::where('slug', $slug)->first();
        if ($this->redisGet->get('page:category:' . $page)) {
            $articlesRedis = json_decode($this->redisGet->get('page:category:' . $page), true);
            $collection = Article::hydrateWith($articlesRedis['data'], ['category', 'author']);
            $collection->flatten();
            $articles = new LengthAwarePaginator($collection, $articlesRedis['total'], $articlesRedis['per_page'], $articlesRedis['current_page']);
        } else {
            $articles = Article::with(['category','author'])
                ->where('category_id', $category->id)
                ->orderBy('date', 'desc')
                ->paginate(15);

            $this->redisWrite->set('page:category:' . $page, json_encode($articles));
        }

        return view('front.category.index', compact('articles', 'categories', 'category'));
    }

    public function author(Request $request, User $author)
    {
        $page = 1;
        $categories = $this->categories;
        if ($request->get('page')) {
            $page = $request->get('page');
        }

        if ($this->redisGet->get('page:author:' . $page)) {
            $articlesRedis = json_decode($this->redisGet->get('page:author:' . $page), true);
            $collection = Article::hydrateWith($articlesRedis['data'], ['category', 'author']);
            $collection->flatten();
            $articles = new LengthAwarePaginator($collection, $articlesRedis['total'], $articlesRedis['per_page'], $articlesRedis['current_page']);
        } else {
            $articles = Article::with(['category','author'])
                ->where('author_id', $author->id)
                ->orderBy('date', 'desc')
                ->paginate(15);

            $this->redisWrite->set('page:author:' . $page, json_encode($articles));
        }

        return view('front.author.index', compact('articles', 'categories', 'author'));
    }
}
