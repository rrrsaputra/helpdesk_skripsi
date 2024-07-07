<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ScheduledCall;
use Illuminate\Support\Facades\Auth;

class AgentScheduledCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 10;
        $notifications = Auth::user()->notifications;
        $agent = Auth::user();
        $scheduledCalls = ScheduledCall::where('assigned_to', $agent->id)->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->paginate($paginationCount);

        return view('agent.scheduled_calls.index', compact('scheduledCalls', 'notifications'));
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
        $startTime = date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time));
        $request->merge(['start_time' => $startTime]);
        $scheduledCall = ScheduledCall::find($id);
        if ($scheduledCall) {
            $scheduledCall->link = $request->link;
            $scheduledCall->start_time = $request->start_time;
            $scheduledCall->duration = $request->duration;
            $scheduledCall->finish_time = date('Y-m-d H:i:s', strtotime($request->start_time) + ($request->duration * 60));
            $scheduledCall->status = 'Scheduled';
            $scheduledCall->save();
        } else {
            return redirect()->route('agent.scheduled_call.index')->with('error', 'Scheduled call not found.');
        }

        return redirect()->route('agent.scheduled_call.index')->with('success', 'Scheduled call updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
