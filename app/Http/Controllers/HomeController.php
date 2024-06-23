<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleCategory;

class HomeController extends Controller
{
    public function index()
    {
        $articleCategories = ArticleCategory::all();

        return view('user.home', compact('articleCategories'));
    }
    public function about()
    {
        return view('user.about');
    }
    public function messages()
    {
        return view('user.messages');
    }

    public function show($slug){
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();
        $articles = $category->articles;
        $articleCategories = ArticleCategory::all();

        
        return view('user.home', compact('category', 'articles', 'articleCategories'));
    }
    
}

