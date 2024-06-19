<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserTicketQuotaController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.ticket_quota.index', compact('users'));
    }
    public function update(Request $request, string $id)
    {
        //
    }


}
