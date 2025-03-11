<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudyProgram;
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
    $paginationCount = 10;
    $users = User::when($search, function ($query) use ($search) {
        $query->where('name', 'like', "%{$search}%");
    })
        ->paginate($paginationCount);

    $data = $users->map(function ($user) {
        $studyProgramName = StudyProgram::find($user->study_program_id)->name ?? 'N/A';
        return [
            'id' => $user->id,
            'url' => '/path/to/resource1',
            'values' => [$user->email, $user->name, $studyProgramName, $user->roles->pluck('name')->first()],
            'ticket_quota' => $user->ticket_quota,
        ];
    })->toArray();

    $studyPrograms = StudyProgram::all(); // Ambil semua program studi

    return view('admin.user_management.index', compact('users', 'data', 'studyPrograms'));
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
            $user->study_program_id = $request->input('type'); // Ubah 'type' menjadi 'study_program_id'
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
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.user_management.index')->with('error', 'Pengguna tidak ditemukan.');
        }

        if ($request->password !== $request->password_confirmation) {
            return redirect()->route('admin.user_management.index')->with('error', 'Konfirmasi kata sandi tidak cocok.');
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
        $user->delete();

        return redirect()->route('admin.user_management.index')->with('success', 'User deleted successfully.');
    }
}
