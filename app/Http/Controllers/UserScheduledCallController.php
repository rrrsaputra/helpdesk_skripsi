<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledCall;
use Illuminate\Support\Facades\Auth;

class UserScheduledCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $scheduledCalls = ScheduledCall::where('user_id', $user->id)->get();

        return view('user.scheduled_calls.scheduled_call', compact('scheduledCalls'));
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
        $user = Auth::user();
        $scheduledCall = ScheduledCall::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect(route('scheduled_call'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $scheduledCall = ScheduledCall::find($id);

    return view('user.scheduled_calls.single-scheduled-call', compact('scheduledCall'));
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
        //
    }
}
