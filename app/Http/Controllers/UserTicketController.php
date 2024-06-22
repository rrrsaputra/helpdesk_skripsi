<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Message;
use Illuminate\Support\Facades\Auth;

class UserTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user = Auth::user();
        $tickets = Ticket::where('user_id', $user->id)->get();
    
        return view('user.tickets.ticket', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $user = Auth::user();
        
        // Cek apakah user memiliki ticket quota yang cukup
        if ($user->ticket_quota <= 0) {
            return redirect()->back()->with('error', 'You do not have enough ticket quota to create a new ticket. Please contact admin.');
        }

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'message' => $request->message,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        $ticket->categories()->create(
            [
                'name' => $request->category,
                'slug' => \Illuminate\Support\Str::slug($request->category)
            ]);
        $message = Message::create([
            'user_id' =>  $user->id,
            'ticket_id' => $ticket->id,
            'message' => $request->message,
        ]);

        // Kurangi ticket quota user
        $user->ticket_quota -= 1;
        $user->save();

        return redirect(route('user.ticket.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $ticket = Ticket::find($id);
        $ticket_id = $ticket->id;
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found');
        }
        $messages = $ticket->messages;
        return view('user.tickets.show-ticket',compact('messages','ticket_id'));
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



