<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class UserArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 10;
        $userType = auth()->user()->type; // Asumsikan tipe pengguna disimpan di kolom 'type' pada tabel users

        if ($userType == 'Standard') {
            $articles = Article::orderBy('created_at', 'desc')
                ->where('for_user', 'Standard')
                ->when($search, function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->paginate($paginationCount);
        } else if ($userType == 'Premium') {
            $articles = Article::orderBy('created_at', 'desc')
                ->whereIn('for_user', ['Standard', 'Premium'])
                ->when($search, function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->paginate($paginationCount);
        }
        // $articles = Article::orderBy('created_at', 'desc')
        //     ->when($search, function ($query) use ($search) {
        //         $query->where('title', 'like', "%{$search}%");
        //     })
        //     ->paginate($paginationCount);

        $articleCategories = ArticleCategory::all();

        return view('user.articles.article', compact('articles', 'articleCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        $article = Article::find($id);
        $articleCategories = ArticleCategory::all();
        $category = ArticleCategory::find($id);

        return view('user.articles.single-article', compact('article', 'articleCategories', 'articles', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
