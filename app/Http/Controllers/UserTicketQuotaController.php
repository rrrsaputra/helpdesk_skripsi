<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserTicketQuotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 10;
        $users = User::role('user')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($paginationCount);

        return view('admin.ticket_quota.index', compact('users'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->ticket_quota = $request->ticket_quota;
        $user->save();

        return redirect()->route('admin.ticket_quota.index')->with('success', 'Ticket quota updated.');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('admin.ticket_quota.show', compact('user'));
    }
}
