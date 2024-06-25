<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Coderflex\LaravelTicket\Models\Ticket;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil rentang tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $users = User::role('user')->get();
        $tickets = Ticket::whereBetween('created_at', [$startDate, $endDate])->get();

        // Ticket per Day
        $ticketLabels = $tickets->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('l'); // Group by day of the week
        })->keys();

        $ticketData = $tickets->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('l'); // Group by day of the week
        })->map(function ($day) {
            return $day->count();
        });

        // Ticket per Category
        $ticketCategories = $tickets->groupBy('category')->keys();

        $ticketDataCategories = $tickets->groupBy('category')->map(function ($category) {
            return $category->count();
        })->values();

        // Ticket per Status
        $ticketStatus = $tickets->groupBy('status')->keys();

        $ticketDataStatus = $tickets->groupBy('status')->map(function ($status) {
            return $status->count();
        })->values();

        // Proses data untuk tabel Agent Performance
        // Proses data untuk tabel Agent Performance
        $agents = User::role('agent')->get();
        $agentPerformance = $agents->map(function ($agent) use ($tickets) {
            $agentTickets = $tickets->where('assigned_to', $agent->id);
            
            return [
                'name' => $agent->name,
                'open' => $agentTickets->where('status', 'open')->count(),
                'closed' => $agentTickets->where('status', 'closed')->count(),
            ];
        });

        // dd($ticketLabels, $ticketData);

        return view('admin.dashboard.index', compact('users', 'ticketLabels', 'ticketData', 'tickets', 'ticketCategories',  'ticketDataCategories', 'ticketStatus', 'ticketDataStatus','agentPerformance'));
    }
}
