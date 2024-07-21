<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::check() ? Auth::user()->roles->pluck('name')->first() ?? 'guest' : 'guest';

        if ($role == 'admin') {
            return redirect()->route('admin.dashboard.index');
        } else if ($role == 'user') {
            $articleCategories = ArticleCategory::all();

            return view('user.home', compact('articleCategories'));
        } else if ($role == 'agent') {
            return redirect()->route('agent.dashboard.index');
        } else {
            return redirect()->route('login');
        }
    }
    public function about()
    {
        return view('user.about');
    }
    public function messages()
    {
        return view('user.messages');
    }

    public function show($slug)
    {
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();
        $articles = $category->articles;
        $articleCategories = ArticleCategory::all();


        return view('user.home', compact('category', 'articles', 'articleCategories'));
    }
}
