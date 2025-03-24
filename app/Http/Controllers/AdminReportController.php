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

        $query = Ticket::with(['user.studyProgram', 'assignedToUser']);

        // Sorting dinamis berdasarkan kolom relasi
        if ($sort === 'user_name') {
            $query->join('users as u', 'tickets.user_id', '=', 'u.id')
                ->orderBy('u.name', $direction)
                ->select('tickets.*');
        } elseif ($sort === 'study_program_name') {
            $query->join('users as u', 'tickets.user_id', '=', 'u.id')
                ->join('study_programs as sp', 'u.study_program_id', '=', 'sp.id')
                ->orderBy('sp.name', $direction)
                ->select('tickets.*');
        } elseif ($sort === 'agent_name') {
            $query->join('users as a', 'tickets.assigned_to', '=', 'a.id')
                ->orderBy('a.name', $direction)
                ->select('tickets.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        // Pencarian semua kolom, termasuk relasi
        $query->when($search, function ($query) use ($search) {
            $query->where('tickets.title', 'like', "%{$search}%")
                ->orWhere('tickets.message', 'like', "%{$search}%")
                ->orWhere('tickets.references', 'like', "%{$search}%")
                ->orWhere('tickets.status', 'like', "%{$search}%")
                ->orWhere('tickets.category', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('lecture_program', 'like', "%{$search}%")
                        ->orWhereHas('studyProgram', function ($sp) use ($search) {
                            $sp->where('name', 'like', "%{$search}%");
                        });
                })
                ->orWhereHas('assignedToUser', function ($aq) use ($search) {
                    $aq->where('name', 'like', "%{$search}%");
                });
        });

        // Filter berdasarkan tanggal
        $query->when($since, function ($q) use ($since) {
            $q->where('tickets.created_at', '>=', $since);
        })->when($until, function ($q) use ($until) {
            $q->where('tickets.created_at', '<=', $until);
        });

        $tickets = $query->paginate($paginationCount);

        // Summary data
        $totalTickets = Ticket::count();
        $totalOpen = Ticket::where('status', 'open')->count();
        $totalOnHold = Ticket::where('status', 'on hold')->count();
        $totalClosed = Ticket::where('status', 'closed')->count();

        $categories = Category::all();

        return view('admin.reports.index', compact(
            'tickets',
            'categories',
            'sort',
            'direction',
            'totalTickets',
            'totalOpen',
            'totalOnHold',
            'totalClosed'
        ));
    }



    public function export(Request $request)
    {
        $since = $request->input('since');
        $until = $request->input('until');
        $search = $request->input('search');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'asc');
        $format = $request->input('format', 'xlsx');

        $exportFormat = $format === 'csv'
            ? \Maatwebsite\Excel\Excel::CSV
            : \Maatwebsite\Excel\Excel::XLSX;

        return Excel::download(
            new \App\Exports\TicketsExport($since, $until, $search, $sort, $direction),
            'tickets.' . $format,
            $exportFormat
        );
    }
}
