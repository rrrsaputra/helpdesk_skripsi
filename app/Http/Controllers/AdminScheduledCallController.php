<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ScheduledCall;
use Illuminate\Support\Facades\Auth;

class AdminScheduledCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheduledCalls = ScheduledCall::all();
        // $categories = Category::all();
        $agents = User::role('agent')->get();

        return view('admin.scheduled_calls.index', compact('scheduledCalls', 'agents'));
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
    public function store(Request $request,string $id)
    {


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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $scheduledCall = ScheduledCall::find($id);
        if ($scheduledCall) {
            $scheduledCall->assigned_to = $request->agent_id;
            $scheduledCall->assigned_from = Auth::id();
            $scheduledCall->save();
        } else {
            return redirect()->route('admin.scheduled_call.index')->with('error', 'Scheduled call not found.');
        }
    
        return redirect()->route('admin.scheduled_call.index')->with('success', 'Scheduled call created successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
