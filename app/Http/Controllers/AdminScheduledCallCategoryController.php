<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\CallCategory;
use Illuminate\Http\Request;

class AdminScheduledCallCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 10;
        $callCategories = CallCategory::orderBy('name', 'asc')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($paginationCount);

        return view('admin.scheduled_call_categories.index', compact('callCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $slug = Str::slug($validatedData['name']);
        $callCategory = CallCategory::create(array_merge($validatedData, ['slug' => $slug]));
        $callCategory->save();

        return redirect()->route('admin.scheduled_call_category.index')->with('success', 'Scheduled call category added successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $slug = Str::slug($validatedData['name']);
        $callCategory = CallCategory::find($id);
        $callCategory->update(array_merge($validatedData, ['slug' => $slug]));
        $callCategory->save();

        return redirect()->route('admin.scheduled_call_category.index')->with('success', 'Scheduled call category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $callCategory = CallCategory::find($id);
        $callCategory->delete();

        return redirect()->route('admin.scheduled_call_category.index')->with('success', 'Scheduled call category deleted successfully.');
    }

    public function show_visible(string $id)
    {
        $callCategory = CallCategory::find($id);
        $callCategory->is_visible = true;
        $callCategory->save();

        return redirect()->route('admin.scheduled_call_category.index')->with('success', 'Scheduled call category visibility updated successfully');
    }

    public function hide_visible(string $id)
    {
        $callCategory = CallCategory::find($id);
        $callCategory->is_visible = false;
        $callCategory->save();

        return redirect()->route('admin.scheduled_call_category.index')->with('success', 'Scheduled call category visibility updated successfully');
    }
}
