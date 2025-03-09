<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;

class UserArticleCategoryController extends Controller
{
    public function show($slug)
    {
        $paginationCount = 10;
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();
        $articles = Article::orderBy('created_at', 'desc')->paginate($paginationCount);
        $articleCategories = ArticleCategory::all();

        return view('user.category.show', compact('category', 'articles', 'articleCategories'));
    }
}
