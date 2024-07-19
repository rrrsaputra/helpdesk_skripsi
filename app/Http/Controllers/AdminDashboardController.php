<?php

namespace App\Http\Controllers;

use App\Models\ScheduledCall;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Coderflex\LaravelTicket\Models\Ticket;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $users = User::role('user')->get();

        // Ambil rentang tanggal dari request
        $startDate = $request->input('start_date', now()->subWeek()->startOfDay());
        $endDate = $request->input('end_date', now()->endOfDay());
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
        $paginationCount = 5;
        $agents = User::role('agent')->paginate($paginationCount);
        $agentPerformance = $agents->map(function ($agent) use ($tickets) {
            $agentTickets = $tickets->where('assigned_to', $agent->id);

            return [
                'name' => $agent->name,
                'total' => $agentTickets->count(),
                'open' => $agentTickets->where('status', 'open')->count(),
                'closed' => $agentTickets->where('status', 'closed')->count(),
            ];
        })->sortByDesc('total');

        // dd($ticketLabels, $ticketData);

        return view('admin.dashboard.index', compact('users', 'ticketLabels', 'ticketData', 'tickets', 'ticketCategories',  'ticketDataCategories', 'ticketStatus', 'ticketDataStatus', 'agentPerformance', 'agents'));
    }

    public function getUserData($id)
    {
        $user = User::findOrFail($id);
        $tickets = Ticket::where('user_id', $id)->get();
        $calls = ScheduledCall::where('user_id', $id)->get();

        // Data untuk grafik per user
        $userTicketLabels = $tickets->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('l'); // Group by day of the week
        })->keys();
        $userCallLabels = $calls->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('l'); // Group by day of the week
        })->keys();

        $userTicketData = $tickets->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('l'); // Group by day of the week
        })->map(function ($day) {
            return $day->count();
        });
        $userCallData = $calls->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('l'); // Group by day of the week
        })->map(function ($day) {
            return $day->count();
        });

        $userTicketCategories = $tickets->groupBy('category')->keys();

        $userTicketDataCategories = $tickets->groupBy('category')->map(function ($category) {
            return $category->count();
        })->values();

        return response()->json([
            'name' => $user->name,
            'tickets_count' => $tickets->count(),
            'calls_count' => $calls->count(),
            'userTicketLabels' => $userTicketLabels,
            'userTicketData' => $userTicketData,
            'userCallLabels' => $userCallLabels,
            'userCallData' => $userCallData,
            'userTicketCategories' => $userTicketCategories,
            'userTicketDataCategories' => $userTicketDataCategories,
        ]);
    }
}
