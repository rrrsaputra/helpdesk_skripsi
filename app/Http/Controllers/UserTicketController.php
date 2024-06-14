<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;
use Coderflex\LaravelTicket\Models\Label;
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
        
        return redirect(route('ticket-submit'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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



