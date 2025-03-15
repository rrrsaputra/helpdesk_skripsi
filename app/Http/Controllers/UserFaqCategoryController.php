<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class UserFaqCategoryController extends Controller
{
    public function show($slug)
    {
        $paginationCount = 10;
        $faqCategory = FaqCategory::where('slug', $slug)->firstOrFail();

        $faqs = Faq::orderBy('created_at', 'desc')
            ->where('faq_category_id', $faqCategory->id)
            ->paginate($paginationCount);

        $faqCategories = FaqCategory::all();

        return view('user.faq_category.show', compact('faqCategory', 'faqs', 'faqCategories'));
    }
}
