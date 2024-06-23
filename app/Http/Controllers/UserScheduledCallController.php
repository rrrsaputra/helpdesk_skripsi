<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
        $paginationCount = 5;
        $scheduledCalls = ScheduledCall::where('user_id', $user->id)->orderBy('updated_at', 'desc')->paginate($paginationCount);
        $scheduledCalls = ScheduledCall::where('user_id', $user->id)->orderBy('updated_at', 'desc')->get();
        $articles = Article::all();

        return view('user.scheduled_calls.scheduled_call', compact('scheduledCalls', 'articles'));
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
        $startTime = date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time));
        $request->merge(['start_time' => $startTime]);
        $scheduledCall = ScheduledCall::create([
            'user_id' => $user->id,
            'duration' => $request->duration,
            'title' => $request->title,
            'message' => $request->message,
            'start_time' => $request->start_time,
            'finish_time' => date('Y-m-d H:i:s', strtotime($request->start_time) + ($request->duration * 60)),
        ]);
        return redirect(route('scheduled_call.index'));
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
