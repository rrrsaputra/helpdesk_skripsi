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

        $validSortColumns = ['created_at', 'references', 'status'];

        if (!in_array($sort, $validSortColumns)) {
            $sort = 'created_at'; // Default jika sort tidak valid
        }

        $tickets = Ticket::orderBy($sort, $direction)
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($since, function ($query) use ($since) {
                $query->where('created_at', '>=', $since);
            })
            ->when($until, function ($query) use ($until) {
                $query->where('created_at', '<=', $until);
            })
            ->paginate($paginationCount);

        // Summary data
        $totalTickets = Ticket::count();
        $totalOpen = Ticket::where('status', 'open')->count();
        $totalOnHold = Ticket::where('status', 'on hold')->count();
        $totalClosed = Ticket::where('status', 'closed')->count();

        $categories = Category::all();

        return view('admin.reports.index', compact('tickets', 'categories', 'sort', 'direction', 'totalTickets', 'totalOpen', 'totalOnHold', 'totalClosed'));
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
}
