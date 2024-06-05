<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function index(){
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('user.articles.article', compact('articles'));
    }

    public function show(string $id)
    {
        $article = Article::find($id);
        return view('user.articles.single-article', compact('article'));
    }
}
