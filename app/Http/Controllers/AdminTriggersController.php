<?php

namespace App\Http\Controllers;

use App\Models\Trigger;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTriggersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 10;
        $triggers = Trigger::orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($paginationCount);

        return view('admin.triggers.index', compact('triggers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agents = User::role('agent')->get();

        return view('admin.triggers.create', compact('agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $query = $request->trigger_query;

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:triggers,name',
            'description' => 'nullable|string|max:255',
            'trigger_query' => 'required|string',
        ]);

        try {
            DB::unprepared($query);

            $trigger = new Trigger();
            $trigger->name = $request->name;
            $trigger->query = $query;
            $trigger->description = $request->description;
            $trigger->save();

            return redirect()->route('admin.triggers.index')->with('success', 'Trigger created successfully');
        } catch (Exception $e) {
            return redirect()->route('admin.triggers.create')->with('error', 'Failed to create trigger: ' . $e->getMessage());
        }
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
        $trigger = Trigger::findOrFail($id);
        $agents = User::role('agent')->get();

        return view('admin.triggers.edit', compact('trigger', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trigger = Trigger::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:triggers,name,' . $id,
            'description' => 'nullable|string|max:255',
            'trigger_query' => 'required|string',
        ]);

        try {
            // Drop the existing trigger
            DB::unprepared('DROP TRIGGER IF EXISTS ' . $trigger->name);

            // Create the new trigger
            DB::unprepared($request->trigger_query);

            // Update the trigger details
            $trigger->name = $request->name;
            $trigger->query = $request->trigger_query;
            $trigger->description = $request->description;
            $trigger->save();

            return redirect()->route('admin.triggers.index')->with('success', 'Trigger updated successfully');
        } catch (Exception $e) {
            return redirect()->route('admin.triggers.edit', $id)->with('error', 'Failed to update trigger: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        
        $trigger = Trigger::find($id);
        if ($trigger) {
            DB::unprepared('DROP TRIGGER IF EXISTS ' . $trigger->name);
            $trigger->delete();
        }
        Trigger::destroy($id);

        return redirect()->route('admin.triggers.index')->with('success', 'Trigger deleted successfully');
        
    }
}
