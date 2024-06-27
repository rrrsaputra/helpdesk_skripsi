<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminTicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 10;
        $ticketCategories = Category::orderBy('name', 'asc')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($paginationCount);

        return view('admin.ticket_category.index', compact('ticketCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ticket_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255'
        ]);

        $slug = Str::slug($validatedData['name']);
        $ticketCategory = Category::create(array_merge($validatedData, ['slug' => $slug]));
        $ticketCategory->save();

        return redirect()->route('admin.ticket_category.index')->with('success', 'Ticket category added successfully');
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
        $ticketCategory = Category::find($id);

        return view('admin.ticket_category.edit', compact('ticketCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255'
        ]);

        $slug = Str::slug($validatedData['name']);
        $ticketCategory = Category::find($id);
        $ticketCategory->update(array_merge($validatedData, ['slug' => $slug]));

        return redirect()->route('admin.ticket_category.index')->with('success', 'Ticket category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticketCategory = Category::find($id);
        $ticketCategory->delete();

        return redirect()->route('admin.ticket_category.index')->with('success', 'Ticket category deleted successfully');
    }

    public function show_visible(string $id)
    {
        $ticketCategory = Category::find($id);
        $ticketCategory->is_visible = true;
        $ticketCategory->save();

        return redirect()->route('admin.ticket_category.index')->with('success', 'Ticket category visibility updated successfully');
    }

    public function hide_visible(string $id)
    {
        $ticketCategory = Category::find($id);
        $ticketCategory->is_visible = false;
        $ticketCategory->save();

        return redirect()->route('admin.ticket_category.index')->with('success', 'Ticket category visibility updated successfully');
    }
}
