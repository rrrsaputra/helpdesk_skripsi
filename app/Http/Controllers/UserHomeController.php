<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        $articles = Article::orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            });
        return view('user.articles.article', compact('articles'));
    }

    public function show(string $id)
    {
        $faqCategory = FaqCategory::find($id);
        return view('user.faq_category.show)', compact('faqCategory'));
    }
}
