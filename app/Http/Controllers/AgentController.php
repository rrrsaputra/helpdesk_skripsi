<?php
namespace App\Http\Controllers;

use Coderflex\LaravelTicket\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function index(Request $request)
    {   
        $inbox = $request->query('inbox', 'unassigned'); // 'default_value' can be replaced with a default value if 'inboc' is not provided
        if (is_null($inbox)) {
            // Redirect to the default URL with 'inbox=unassigned'
            return redirect()->route('agent.index', ['inbox' => 'unassigned']);
        }
        else if ($inbox == 'unassigned') {
            $tickets = Ticket::opened()->where('assigned_to',null)->get();

            return view('agent.index',compact('tickets','inbox'));
        }
        else if ($inbox == 'mine') {
            $tickets = Ticket::opened()->where('assigned_to', Auth::id())->get();
            return view('agent.index', compact('tickets','inbox'));
        } else if ($inbox == 'assigned') {
            $tickets = Ticket::opened()->where('assigned_to',!null)->get();
            return view('agent.index', compact('tickets','inbox'));
        } else if ($inbox == 'closed') {
            $tickets = Ticket::closed()->get();
            return view('agent.index', compact('tickets','inbox'));
            
        }

        // Handle other cases or default view
        return view('agent.index');
    }
}
