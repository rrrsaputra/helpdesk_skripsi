<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;
use Coderflex\LaravelTicket\Models\Label;

class AgentTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        Ticket::create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
        ]);

        return redirect(route('agent.index'));
    }


    public function get(string $id)
    {
        $user = Auth::user();
        $ticket = Ticket::where('id', $id)->first();
        $ticket->assigned_to = $user->id;
        $ticket->save();


        return redirect(route('agent.index'));
    }
    public function unassign(string $id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $ticket->assigned_to = null;
        $ticket->save();


        return redirect(route('agent.index', ['inbox' => 'mine']));
    }
    public function close(string $id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $ticket->status = "closed";
        $ticket->save();

        return redirect(route('agent.index', ['inbox' => 'mine']));
    }
    public function reopen_ticket(string $id)
    {

        $ticket = Ticket::where('id', $id)->first();
        $ticket->status = "open";
        $ticket->save();


        return redirect(route('agent.index', ['inbox' => 'closed']));
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
        $ticket = Ticket::findOrFail($id);
        $ticket->latitude = $request->latitude;
        $ticket->longitude = $request->longitude;
        $ticket->save();
        return redirect(route('agent.index', ['inbox' => 'unassigned']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
