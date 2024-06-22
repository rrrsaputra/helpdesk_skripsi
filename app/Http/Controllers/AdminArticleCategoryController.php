<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleCategory;

class AdminArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articleCategories = ArticleCategory::all();

        return view('admin.article_categories.index', compact('articleCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.article_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $articleCategory = ArticleCategory::create($validatedData);

        return redirect()->route('admin.article_category.index')->with('success', 'Article category added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $articleCategory = ArticleCategory::find($id);

        return view('admin.article_categories.edit', compact('articleCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $articleCategory = ArticleCategory::findOrFail($id);
        $articleCategory->update($validatedData);

        return redirect()->route('admin.article_category.index')->with('success', 'Article category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $articleCategory = ArticleCategory::findOrFail($id);
        $articleCategory->delete();

        return redirect()->route('admin.article_category.index');
    }
}
