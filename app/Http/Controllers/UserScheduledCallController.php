<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessScheduledCall;
use App\Mail\SendMail;
use App\Models\Article;
use App\Models\Attachment_Call;
use Illuminate\Http\Request;
use App\Models\ScheduledCall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserScheduledCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = Auth::user();
        $paginationCount = 5;
        $scheduledCalls = ScheduledCall::where('user_id', $user->id)->orderBy('updated_at', 'desc')
        ->when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('message', 'like', "%{$search}%");
        })
        ->paginate($paginationCount);
        // $scheduledCalls = ScheduledCall::where('user_id', $user->id)->orderBy('updated_at', 'desc')->get();
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

        
        $filepondData = json_decode($request->input('filepond'), true);
        
        if ($filepondData) {
            foreach ($filepondData as $fileData) {
                $serverId = json_decode($fileData['serverId'], true);
                $path = $serverId['path'];
                $name = $fileData['name'];
                
                Attachment_Call::create([
                    'name' => $name,
                    'path' => $path,
                    'scheduled_call_id' => $scheduledCall->id
                ]);
            }
        }
        $toEmailAddress = Auth::user()->email;
        ProcessScheduledCall::dispatch($scheduledCall, $toEmailAddress);

        return redirect(route('scheduled_call.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $scheduledCall = ScheduledCall::find($id);
        $articles = Article::orderBy('created_at', 'desc')->get();

        return view('user.scheduled_calls.single-scheduled-call', compact('scheduledCall', 'articles'));
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
