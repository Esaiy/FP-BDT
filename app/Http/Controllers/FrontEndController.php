<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Redis;


class FrontEndController extends Controller
{
    public function index()
    {
        
        $articles = Article::with(['category','author'])
            ->orderBy('date', 'desc')
            ->paginate(15);
        $categories = Category::all();

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
