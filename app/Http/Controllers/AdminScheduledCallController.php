<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BusinessHour;
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

        
        $businessHours = BusinessHour::where('day', '>=', now()->format('Y-m-d'))->select('day')->get();
        // $categories = Category::all();
        $agents = User::role('agent')->get();
        $scheduledCalls = ScheduledCall::all();

        return view('admin.scheduled_calls.index', compact('scheduledCalls', 'agents', 'businessHours'));
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
    public function store(Request $request, string $id)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $scheduledCall = ScheduledCall::find($id);
        $agents = User::role('agent')->get();

        $agentId = request()->query('agent', null);
        $date = request()->query('date', null);

        if ($agentId && $date) {
            $scheduledCall->agent_id = $agentId;
            $scheduledCall->date = $date;

            // Get business hours for the specific date
            $businessHours = BusinessHour::where('day', $date)->first();
            if ($businessHours) {
                $startTime = new \DateTime($businessHours->from);
                $endTime = new \DateTime($businessHours->to);
                $step = $businessHours->step ?? 30; // Default to 30 minutes if step is not set
                
                // Create a list of intervals within the business hours
                $availableTimes = [];
                while ($startTime < $endTime) {
                    $availableTimes[] = $startTime->format('H:i');
                    $startTime->modify("+{$step} minutes");
                }

                // Remove duplicate times and sort
                $availableTimes = array_unique($availableTimes);
                sort($availableTimes);
                
            } else {
                $availableTimes = [];
            }
            $existingCalls = ScheduledCall::where('assigned_to', $agentId)
                ->whereDate('start_time', $date)
                ->get();

            $blockedTimes = [];
            foreach ($existingCalls as $call) {
                $startTime = new \DateTime($call->start_time);
                $duration = $call->duration;
                while ($duration > 0) {
                    $blockedTimes[] = $startTime->format('H:i');
                    $startTime->modify('+30 minutes');
                    $duration -= 30;
                }
            }
            // Filter out available times that are in the blocked times
            $availableTimes = array_filter($availableTimes, function($time) use ($blockedTimes) {
                return !in_array($time, $blockedTimes);
            });
            

            $businessHours = BusinessHour::where('day', '>=', now()->format('Y-m-d'))->select('day')->get();
            return view('admin.scheduled_calls.show', compact('scheduledCall', 'agents', 'businessHours', 'availableTimes'));
        } else {
            $businessHours = BusinessHour::where('day', '>=', now()->format('Y-m-d'))->select('day')->get();
            return view('admin.scheduled_calls.show', compact('scheduledCall', 'agents', 'businessHours'));
        }

    }
    
    public function reject(Request $request, string $id)
    {
        $scheduledCall = ScheduledCall::find($id);
        if ($scheduledCall) {
            $scheduledCall->assigned_to = null;
            $scheduledCall->assigned_from = null;
            $scheduledCall->status = 'rejected';
            $scheduledCall->rejected_by = Auth::id();
            $scheduledCall->rejected_reason = $request->input('reason');
            $scheduledCall->save();

            return redirect()->route('admin.scheduled_call.index')->with('success', 'Scheduled call rejected successfully.');
        } else {
            return redirect()->route('admin.scheduled_call.index')->with('error', 'Scheduled call not found.');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $scheduledCall = ScheduledCall::find($id);
        $agents = User::role('agent')->get();
        $startTime = $scheduledCall->start_time;
        $duration = $scheduledCall->duration;
        return view('admin.scheduled_calls.edit', compact('scheduledCall', 'agents', 'startTime', 'duration'));



    }
   
    public function get_time(Request $request)
    {
        dd($request);
    }              
    public function update(Request $request, string $id)
    {   
       
        $scheduledCall = ScheduledCall::find($id);
        if ($scheduledCall) {
            $scheduledCall->assigned_to = $request->agent_id;
            $scheduledCall->assigned_from = Auth::id();
            $scheduledCall->status = 'assigned';
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

    // Controller

}
