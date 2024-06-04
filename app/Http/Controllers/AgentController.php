<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            return view('agent.index',compact('inbox'));
        }
        else if ($inbox == 'mine') {
            return view('agent.index', compact('inbox'));
        } else if ($inbox == 'assigned') {
            return view('agent.index', compact('inbox'));
        } else if ($inbox == 'closed') {
            return view('agent.index', compact('inbox'));
        }

        // Handle other cases or default view
        return view('agent.index');
    }
}
