<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Coderflex\LaravelTicket\Models\Ticket;

class AdminTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $agents = User::role('agent')->get();
        $inbox = $request->query('inbox', 'unassigned'); // 'default_value' can be replaced with a default value if 'inbox' is not provided
        if (is_null($inbox)) {
            // Redirect to the default URL with 'inbox=unassigned'
            return redirect()->route('admin.ticket.index', ['inbox' => 'unassigned']);
        }

        $search = $request->input('search');
        $paginationCount = 5; // Adjusted pagination count

        if ($inbox == 'unassigned') {
            $tickets = Ticket::opened()->where('assigned_to', null)->orderBy('created_at', 'desc')
                ->when($search, function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                })
                ->paginate($paginationCount); // Fixed pagination
            return view('admin.ticket.index', compact('tickets', 'inbox', 'agents'));
        } else if ($inbox == 'mine') {
            $tickets = Ticket::opened()->where('assigned_to', Auth::id())->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })->paginate($paginationCount); // Fixed pagination
            return view('agent.index', compact('tickets', 'inbox'));
        } else if ($inbox == 'assigned') {
            $tickets = Ticket::opened()->whereNotNull('assigned_to')->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })->paginate($paginationCount); // Fixed pagination
            return view('admin.ticket.index', compact('tickets', 'inbox', 'agents'));
        } else if ($inbox == 'closed') {
            $tickets = Ticket::closed()->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })->paginate($paginationCount); // Fixed pagination
            return view('admin.ticket.index', compact('tickets', 'inbox', 'agents'));
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
        if ($ticket) {
            $ticket->assigned_to = $request->agent_id;
            $ticket->save();
        } else {
            return redirect()->route('admin.ticket.index');
        }

        return redirect()->route('admin.ticket.index');
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
