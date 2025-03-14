<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;

class AdminDataRepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 10;
        $dataRepositories = Attachment::orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('message.user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('ticket_id', 'like', "%{$search}%");
                    });
            })
            ->paginate($paginationCount);

        return view('admin.data_repositories.index', compact('dataRepositories'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataRepository = Attachment::find($id);
        $dataRepository->delete();

        return redirect()->route('admin.data_repositories.index');
    }
}
