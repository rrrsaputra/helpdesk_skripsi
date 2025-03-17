<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'created_at'); // default sort
        $direction = $request->input('direction', 'desc'); // default direction
        $paginationCount = 10;

        $faqs = Faq::orderBy($sort, $direction)
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->paginate($paginationCount);

        return view('admin.faq.index', compact('faqs', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faqCategories = FaqCategory::all();

        return view('admin.faq.create', compact('faqCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
        ]);

        $articleData = [
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'faq_category_id' => $validatedData['category'],
            'user_id' => auth()->id(),
        ];

        Faq::create($articleData);

        return redirect()->route('admin.faq.index')->with('success', 'FaQ created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faqs = Faq::all($id);

        return view('admin.faq.index', compact('faqs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $faq = Faq::find($id);
        $faqCategories = FaqCategory::all();

        return view('admin.faq.edit', compact('faq', 'faqCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
        ]);

        $faq = Faq::find($id);
        $faq->title = $request->title;
        $faq->content = $request->content;
        $faq->faq_category_id = $request->category;
        if ($request->hasFile('image')) {
            $file = $request->file('image')->store('faqs');
            $faq->image = $file;
        }
        $faq->save();
        return redirect()->route('admin.faq.index')->with('success', 'FaQ updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::find($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'FaQ deleted successfully');
    }
}
