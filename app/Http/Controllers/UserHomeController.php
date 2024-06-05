<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function index(){
        $articles = Article::all();
        return view('user.articles.article', compact('articles'));
    }

    public function show(string $id)
    {
        
    }
}
