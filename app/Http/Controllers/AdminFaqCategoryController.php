<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminFaqCategoryController extends Controller
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


        $faqCategories = FaqCategory::orderBy($sort, $direction)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->paginate($paginationCount);

        return view('admin.faq_categories.index', compact('faqCategories', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faq_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validatedData['name']);
        $faqCategory = FaqCategory::create(array_merge($validatedData, ['slug' => $slug]));
        $faqCategory->save();

        return redirect()->route('admin.faq_category.index')->with('success', 'FAQ category added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $faqCategory = FaqCategory::find($id);

        return view('admin.faq_categories.edit', compact('faqCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validatedData['name']);
        $faqCategory = FaqCategory::find($id);
        $faqCategory->update(array_merge($validatedData, ['slug' => $slug]));

        return redirect()->route('admin.faq_category.index')->with('success', 'FAQ category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faqCategory = FaqCategory::find($id);
        $faqCategory->delete();

        return redirect()->route('admin.faq_category.index')->with('success', 'FAQ category deleted successfully.');
    }
}
