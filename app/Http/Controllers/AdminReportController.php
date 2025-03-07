<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Ticket;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $since = $request->input('since');
        $until = $request->input('until');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'asc');
        $paginationCount = 10;

        $tickets = Ticket::orderBy($sort, $direction)
            ->when($search, function ($query) use ($search) {
                $query->where('category', 'like', "%{$search}%");
            })
            ->when($since, function ($query) use ($since) {
                $query->where('created_at', '>=', $since);
            })
            ->when($until, function ($query) use ($until) {
                $query->where('created_at', '<=', $until);
            })
            ->paginate($paginationCount);

        $categories = Category::all();

        return view('admin.reports.index', compact('tickets', 'categories', 'sort', 'direction'));
    }

    public function export(Request $request)
    {
        $since = $request->input('since');
        $until = $request->input('until');
        $search = $request->input('search');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'asc');

        return Excel::download(new TicketsExport($since, $until, $search, $sort, $direction), 'tickets.xlsx');
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $values = $request->input('values');

        // Update the ticket fields based on the values array
        $ticket->created_at = $values[1];
        $ticket->category = $values[2];
        $ticket->title = $values[7];
        $ticket->message = $values[8]; // Assuming title and message are combined
        $ticket->created_at = $values[9];
        $ticket->updated_at = $values[10];
        $ticket->status = $values[12];

        // Save the updated ticket
        $ticket->save();

        // Redirect back with a success message
        return redirect()->route('admin.report.index')->with('success', 'Ticket updated successfully.');
    }
}
