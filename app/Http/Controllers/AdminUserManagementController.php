<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 50;
        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })
            ->paginate($paginationCount);

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'url' => '/path/to/resource1',
                'values' => [$user->name, $user->type],
                'ticket_quota' => $user->ticket_quota,
                'type' => $user->type,
                'role' => $user->roles->pluck('name')->first(), // Assuming a user has one role
            ];
        })->toArray();

        return view('admin.user_management.index', compact('users', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user_management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->password !== $request->password_confirmation) {
            return redirect()->back()->withErrors(['password' => 'Password tidak cocok.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.user_management.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->type = $request->input('type');
            $user->save();

            $role = $request->input('role');
            if ($role) {
                $user->syncRoles([$role]);
            }

            return redirect()->route('admin.user_management.index')->with('success', 'User type updated successfully.');
        } else {
            return redirect()->route('admin.user_management.index')->with('error', 'User not found.');
        }
    }

    public function updatePassword(Request $request, string $id)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.user_management.index')->with('error', 'User not found.');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password does not match.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('admin.user_management.index')->with('success', 'Password updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = User::find($id);
        if ($user && Hash::check($request->password, $user->password)) {
            $user->delete();
            return redirect()->route('admin.user_management.index')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->route('admin.user_management.index')->with('error', 'The password is incorrect.');
        }
    }
}
