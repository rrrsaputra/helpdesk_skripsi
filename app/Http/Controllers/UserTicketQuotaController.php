<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserTicketQuotaController extends Controller
{
    public function index()
    {
        $users = User::role('user')->get();

        return view('admin.ticket_quota.index', compact('users'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->ticket_quota = $request->ticket_quota;
        $user->save();

        return redirect()->route('admin.ticket_quota.index')->with('success', 'Ticket quota updated.');
    }

    public function show ($id){
        $user = User::find($id);

        return view('admin.ticket_quota.show', compact('user'));
    }
}