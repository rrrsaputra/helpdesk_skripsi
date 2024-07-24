<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Message;
use Illuminate\Support\Facades\Auth;
use Laravel\Reverb\Events\MessageSent as EventsMessageSent;

class AgentMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
        
        $ticket = Ticket::find($id);
        if (!$ticket) {
            // Handle the case where the ticket is not found
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        $messageContent = $request->input('message');
        $isOnline = $request->input('is_online');
        if (!$messageContent) {
            // Handle the case where the message content is not provided
            return response()->json(['error' => 'Message content is required'], 400);
        }

        $message = new Message();
        $message->ticket_id = $ticket->id;
        $message->user_id = auth()->id();
        $message->message = $messageContent;
        $message->is_read = $isOnline ? null : now();
        $message->save();
        
        $user = $message->user;
        if (!$user) {
            // Handle the case where the user is not found
            return response()->json(['error' => 'User not found'], 404);
        }
        $filepondData = json_decode($request->input('filepond'), true);
        
        if ($filepondData) {
            foreach ($filepondData as $fileData) {
                $serverId = json_decode($fileData['serverId'], true);
                $path = $serverId['path'];
                $name = $fileData['name'];
                
                Attachment::create([
                    'name' => $name,
                    'path' => $path,
                    'message_id' => $message->id
                ]);
            }
        }

        
        event(new MessageSent($message, $user));

        // Return the current view
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::find($id);
        $ticket_id = $ticket->id;

        if ($ticket->assigned_to == Auth::id()) {
            $ticket->messages->where('user_id', '!=', Auth::id())->where('is_read', '')->each(function ($message) {
                $message->is_read = now();
                $message->save();
            });
        }

        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found');
        }
        $messages = $ticket->messages;
        return view('agent.messages.index',compact('messages','ticket_id','ticket'));
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
