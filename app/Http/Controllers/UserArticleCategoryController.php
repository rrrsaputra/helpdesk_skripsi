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
        $userType = auth()->user()->type; // Asumsikan tipe pengguna disimpan di kolom 'type' pada tabel users

        if ($userType == 'Standard') {
            $articles = Article::orderBy('created_at', 'desc')
                ->where('for_user', 'Standard')
                ->paginate($paginationCount);
        } else if ($userType == 'Premium') {
            $articles = Article::orderBy('created_at', 'desc')
                ->whereIn('for_user', ['Standard', 'Premium'])
                ->paginate($paginationCount);
        }
        $articleCategories = ArticleCategory::all();

        return view('user.category.show', compact('category', 'articles', 'articleCategories'));
    }
}
