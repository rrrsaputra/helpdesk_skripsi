<?php
namespace App\Http\Controllers;

use Coderflex\LaravelTicket\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function index(Request $request)
    {   

        
        $inbox = $request->query('inbox', 'unassigned'); // 'default_value' can be replaced with a default value if 'inbox' is not provided
        if (is_null($inbox)) {
            // Redirect to the default URL with 'inbox=unassigned'
            return redirect()->route('agent.index', ['inbox' => 'unassigned']);
        }
        
        $paginationCount = 5; // Adjusted pagination count

        if ($inbox == 'unassigned') {
            $tickets = Ticket::opened()->where('assigned_to', null)->paginate($paginationCount); // Fixed pagination
            return view('agent.index', compact('tickets', 'inbox'));
        }
        else if ($inbox == 'mine') {
            $tickets = Ticket::opened()->where('assigned_to', Auth::id())->paginate($paginationCount); // Fixed pagination
            return view('agent.index', compact('tickets', 'inbox'));
        } else if ($inbox == 'assigned') {
            $tickets = Ticket::opened()->whereNotNull('assigned_to')->paginate($paginationCount); // Fixed pagination
            return view('agent.index', compact('tickets', 'inbox'));
        } else if ($inbox == 'closed') {
            $tickets = Ticket::closed()->paginate($paginationCount); // Fixed pagination
            return view('agent.index', compact('tickets', 'inbox'));
        }

        // Handle other cases or default view
        return view('agent.index');
    }
}
