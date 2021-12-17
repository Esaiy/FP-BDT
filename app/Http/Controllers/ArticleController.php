<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['author', 'category'])->orderBy('id', 'desc')->paginate(10);
        return view('admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.article.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'headline' => 'required',
            'link' => 'required',
            'kategori' => 'required|exists:categories,id',
            'deskripsi' => 'required',
            'tanggal' => 'required',
        ]);

        $author = auth()->user();

        $article = Article::create([
            'headline' => $request->headline,
            'slug' => Str::slug($request->headline),
            'category_id' => $request->kategori,
            'author_id' => $author->id,
            'description' => $request->deskripsi,
            'link' => $request->link,
            'date' => $request->tanggal,
            'is_active' => true,
        ]);

        return redirect()->route('dashboard.article.index')->with('success', 'Berhasil menambahkan artikel');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('admin.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('admin.article.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'headline' => 'required',
            'link' => 'required',
            'kategori' => 'required|exists:categories,id',
            'deskripsi' => 'required',
            'tanggal' => 'required',
        ]);

        $article->update([
            'headline' => $request->headline,
            'slug' => Str::slug($request->headline),
            'category_id' => $request->kategori,
            'description' => $request->deskripsi,
            'link' => $request->link,
            'date' => $request->tanggal,
        ]);

        return redirect()->route('dashboard.article.index')->with('success', 'Artikel berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('dashboard.article.index')->with('success', 'Artikel berhasil dihapus');
    }
}
