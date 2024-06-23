<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Message;
use Coderflex\LaravelTicket\Models\Category;

class UserTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginationCount = 5;
        $user = Auth::user();
        $remainingTickets = $user;
        $tickets = Ticket::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate($paginationCount);
        $articles = Article::all();
        // $ticketCategory = Category::whereIn('id', $tickets->pluck('category_id'))->paginate($paginationCount);

        return view('user.tickets.ticket', compact('tickets', 'remainingTickets', 'articles'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ticketCategories = Category::where('is_visible', true)->get();
        
        return view('user.tickets.ticket-submit', compact('ticketCategories'));
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
            'category' => $request->category,
            'title' => $request->title,
            'message' => $request->message,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        // $ticket->categories()->create(
        //     [
        //         'name' => $request->category,
        //         'slug' => \Illuminate\Support\Str::slug($request->category)
        //     ]);
        $message = Message::create([
            'user_id' =>  $user->id,
            'ticket_id' => $ticket->id,
            'message' => $request->message,
        ]);

        // Kurangi ticket quota user
        if (!$this->decrementTicketQuota($user)) {
            return redirect()->back()->with('error', 'You do not have enough ticket quota to create a new ticket. Please contact admin.');
        }

        return redirect(route('user.ticket.index'));
    }

    private function decrementTicketQuota($user)
    {
        // Cek apakah user memiliki ticket quota yang cukup
        if ($user->ticket_quota <= 0) {
            return false;
        }

        // Kurangi ticket quota user
        $user->ticket_quota -= 1;
        $user->save();

        return true;
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
        return view('user.tickets.show-ticket', compact('messages', 'ticket_id'));
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
