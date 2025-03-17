<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Coderflex\LaravelTicket\Enums\Status;
use Coderflex\LaravelTicket\Models\Ticket;

class AdminTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $agents = User::role('agent')->get();
        $inbox = $request->query('inbox', 'unassigned');

        $search = $request->input('search');
        $paginationCount = 5;

        $ticketsQuery = Ticket::opened()->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });

        switch ($inbox) {
            case 'unassigned':
                $tickets = $ticketsQuery->where('assigned_to', null)->paginate($paginationCount);
                return view('admin.ticket.index', compact('tickets', 'inbox', 'agents'));
            case 'mine':
                $tickets = $ticketsQuery->where('assigned_to', Auth::id())->paginate($paginationCount);
                return view('agent.index', compact('tickets', 'inbox'));
            case 'assigned':
                $tickets = $ticketsQuery->whereNotNull('assigned_to')
                    ->orWhere('status', 'on hold')
                    ->paginate($paginationCount);
                return view('admin.ticket.index', compact('tickets', 'inbox', 'agents'));
            case 'closed':
                $tickets = Ticket::closed()->orderBy('created_at', 'desc')
                    ->when($search, function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%")
                            ->orWhere('category', 'like', "%{$search}%")
                            ->orWhere('message', 'like', "%{$search}%");
                    })->paginate($paginationCount);
                return view('admin.ticket.index', compact('tickets', 'inbox', 'agents'));
            default:
                return redirect()->route('admin.ticket.index', ['inbox' => 'unassigned']);
        }
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
        $ticket = Ticket::find($id);
        $ticket->assigned_to = $request->agent_id;
        
        // Check if latitude and longitude are provided in the request
        if ($request->has('latitude') && $request->has('longitude')) {
            $ticket->latitude = $request->latitude;
            $ticket->longitude = $request->longitude;
        }
        
        $ticket->save();
        return redirect()->route('admin.ticket.index', ['inbox' => 'unassigned']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function unassign(string $id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $ticket->assigned_to = null;
        $ticket->status = "open";
        $ticket->save();


        return redirect(route('admin.ticket.index', ['inbox' => 'assigned']));
    }

    public function close(string $id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $ticket->status = "closed";
        $ticket->save();

        return redirect(route('admin.ticket.index', ['inbox' => 'assigned']));
    }

    public function reopen_ticket(string $id)
    {

        $ticket = Ticket::where('id', $id)->first();
        $ticket->status = "open";
        $ticket->save();


        return redirect(route('admin.ticket.index', ['inbox' => 'closed']));
    }
}
