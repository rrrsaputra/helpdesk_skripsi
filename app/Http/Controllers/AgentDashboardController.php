<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ScheduledCall;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Coderflex\LaravelTicket\Models\Ticket;

class AgentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications;

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
        $paginationCount=5;
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

        $hoursUntilFirstReply = Ticket::selectRaw('TIMESTAMPDIFF(HOUR, created_at, updated_at) as hours_until_reply')
            ->get()
            ->pluck('hours_until_reply');

        $timeCategories = [
            '0-1' => 0,
            '1-8' => 0,
            '8-24' => 0,
            '>24' => 0,
        ];

        foreach ($hoursUntilFirstReply as $hours) {
            if ($hours <= 1) {
                $timeCategories['0-1']++;
            } elseif ($hours <= 8) {
                $timeCategories['1-8']++;
            } elseif ($hours <= 24) {
                $timeCategories['8-24']++;
            } else {
                $timeCategories['>24']++;
            }
        }

        // dd($ticketLabels, $ticketData);

        return view('agent.dashboard.index', compact('users', 'ticketLabels', 'ticketData', 'tickets', 'ticketCategories',  'ticketDataCategories', 'ticketStatus', 'ticketDataStatus','agentPerformance', 'agents', 'notifications', 'hoursUntilFirstReply', 'timeCategories'));
    }

    public function getUserData($id, Request $request)
    {
        $startDate = $request->input('start_date', now()->subWeek()->startOfDay());
        $endDate = $request->input('end_date', now()->endOfDay());
    
        $user = User::findOrFail($id);
        $tickets = Ticket::where('user_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        $calls = ScheduledCall::where('user_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    
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
