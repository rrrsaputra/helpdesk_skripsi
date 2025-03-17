<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Http\Request;

class AdminStudyProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 10;
        $studyPrograms = StudyProgram::orderBy('name', 'asc')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })->paginate($paginationCount);

        return view('admin.study_programs.index', compact('studyPrograms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.study_programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        StudyProgram::create($validatedData);

        return redirect()->route('admin.study_programs.index')->with('success', 'Study program created successfully');
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
        $studyProgram = StudyProgram::find($id);

        return view('admin.study_programs.edit', compact('studyProgram'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $studyProgram = StudyProgram::find($id);
        $studyProgram->update($validatedData);

        return redirect()->route('admin.study_programs.index')->with('success', 'Study program updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $studyProgram = StudyProgram::find($id);
        $studyProgram->delete();

        return redirect()->route('admin.study_programs.index')->with('success', 'Study program deleted successfully');
    }
}
