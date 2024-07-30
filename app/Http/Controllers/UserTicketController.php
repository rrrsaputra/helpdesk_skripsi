<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\TicketCreated;
use App\Events\TicketSent;
use App\Jobs\ProcessTicket;
use App\Models\Article;
use App\Models\Attachment;
use App\Models\User;
use App\Notifications\TicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Message;
use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;


class UserTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');
        $paginationCount = 5;
        $user = Auth::user();
        $remainingTickets = $user;
        $tickets = Ticket::where('user_id', $user->id)->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })
            ->paginate($paginationCount);

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
            'references' => $this->generateTicketReference()
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

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

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
        // if ($request->hasFile('filepond')) {
        //     foreach ($request->file('filepond') as $file) {
        //         $path = $file->store('uploads', 'public');
        //         if ($path) {
        //             Attachment::create([
        //                 'name' => $file->getClientOriginalName(),
        //                 'path' => $path,
        //                 'message_id'=> $message->id
        //             ]);
        //         } else {
        //             return redirect()->back()->with('error', 'Failed to upload file. Please try again.');
        //         }
        //     }
        // }

        $agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->get();


        foreach ($agents as $agent) {
            $notification = [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\TicketNotification',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $agent->id,
                'data' => json_encode(['ticket_id' => $ticket->id, 'message' => 'A new ticket has been created.']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('notifications')->insert($notification);
        }
        event(new TicketSent($ticket));
        $toEmailAddress = Auth::user()->email;
        ProcessTicket::dispatch($ticket, $toEmailAddress);
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
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found');
        }
        if ($ticket->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'You do not have permission to view this ticket.');
        }

        $ticket_id = $ticket->id;
        $messages = $ticket->messages;

        foreach ($messages as $message) {
            $attachments = $message->attachments;
            $message->has_attachments = $attachments->isNotEmpty();
            $message->attachments_list = $message->has_attachments ? $message->attachments_list() : null;
        }

        if ($ticket->user_id == Auth::id()) {
            $ticket->messages()->where('user_id', '!=', Auth::id())->where('is_read', null)->update(['is_read' => now()]);
        }

        return view('user.tickets.show-ticket', compact('ticket', 'messages', 'ticket_id'));
    }

    public function storeFromEmail($userId, $title, $message)
    {
        $user = User::find($userId);

        if (!$user) {
            Log::error('User not found for ID: ' . $userId);
            return;
        }

        // Create a new ticket
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'references' => $this->generateTicketReference(),
            'category' => "email"
        ]);
        $message = Message::create([
            'user_id' =>  $user->id,
            'ticket_id' => $ticket->id,
            'message' => $message,
        ]);

        // event(new TicketCreated($ticket));
        event(new TicketSent($ticket));
        $toEmailAddress = $user->email;
        ProcessTicket::dispatch($ticket, $toEmailAddress);

        // Decrement ticket quota
        if (!$this->decrementTicketQuota($user)) {
            Log::error('Not enough ticket quota for user ID: ' . $userId);
        }
    }

    public function markMessagesAsRead(Request $request, string $ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        $unreadMessages = $ticket->messages()->where('user_id', '!=', Auth::id())->where('is_read', null)->get();


        $unreadMessages->each(function ($message) {
            $message->is_read = now();
            $message->save();
        });


        return response()->json(['success' => true, 'message' => 'Messages marked as read']);
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
    private function generateTicketReference()
    {
        // Get the last ticket reference
        $lastTicket = Ticket::orderBy('created_at', 'desc')->first();

        // If no tickets exist, return the default reference
        if (!$lastTicket) {
            return "T-0001";
        }

        $formerReference = $lastTicket->references;
        $parts = explode("-", $formerReference);
        $numbers = isset($parts[1]) && is_numeric($parts[1]) ? (int)$parts[1] : 0; // Ensure the part is numeric

        // Increment the number
        $nextNumbers = $numbers + 1;

        // Format the new reference
        return "T-" . str_pad($nextNumbers, 4, '0', STR_PAD_LEFT); // Ensure the number is zero-padded to 4 digits
    }
}
