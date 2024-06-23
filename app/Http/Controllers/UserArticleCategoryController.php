<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleCategory;

class UserArticleCategoryController extends Controller
{
    public function show($slug)
    {
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();
        $articles = $category->articles;
        $articleCategories = ArticleCategory::all();

        return view('user.category.show', compact('category', 'articles', 'articleCategories'));
    }
}
