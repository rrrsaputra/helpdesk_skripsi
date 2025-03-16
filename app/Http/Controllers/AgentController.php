<?php
namespace App\Http\Controllers;

use Coderflex\LaravelTicket\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function index(Request $request)
    {   
        
        $notifications = $request->user()->notifications;
        $inbox = $request->query('inbox', 'unassigned'); // 'default_value' can be replaced with a default value if 'inbox' is not provided
        if (is_null($inbox)) {
            // Redirect to the default URL with 'inbox=unassigned'
            return redirect()->route('agent.index', ['inbox' => 'unassigned']);
        }
        
        $search = $request->input('search');
        $paginationCount = 5; // Adjusted pagination count

        if ($inbox == 'unassigned') {
            $tickets = Ticket::opened()->where('assigned_to', null)->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })->paginate($paginationCount); // Fixed pagination
            return view('agent.index', compact('tickets', 'inbox','notifications'));
        }
        else if ($inbox == 'mine') {
            $tickets = Ticket::where(function ($query) {
                $query->where('assigned_to', Auth::id())
                      ->orWhere(function ($query) {
                          $query->where('status', 'open')
                                ->whereNotNull('assigned_to');
                      })
                      ->orWhere('status', 'on hold');
            })->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })->paginate($paginationCount); // Fixed pagination
            return view('agent.index', compact('tickets', 'inbox','notifications'));
        } else if ($inbox == 'assigned') {
            $tickets = Ticket::opened()->whereNotNull('assigned_to')->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })->paginate($paginationCount); // Fixed pagination
            return view('agent.index', compact('tickets', 'inbox','notifications'));
        } else if ($inbox == 'closed') {
            $tickets = Ticket::closed()->orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })->paginate($paginationCount); // Fixed pagination
            return view('agent.index', compact('tickets', 'inbox','notifications'));
        }

        // Handle other cases or default view
        return view('agent.index');
    }
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }
}
