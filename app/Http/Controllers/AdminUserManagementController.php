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
    $roleFilter = $request->input('role');
    $sort = $request->input('sort', 'created_at');
    $direction = $request->input('direction', 'desc');
    $paginationCount = 10;

    $users = User::with('studyProgram', 'roles')
        ->when($roleFilter, function ($query) use ($roleFilter) {
            $query->whereHas('roles', function ($q) use ($roleFilter) {
                $q->where('name', $roleFilter);
            });
        })
        ->when($sort === 'study_program_name', function ($query) use ($direction) {
            $query->leftJoin('study_programs', 'users.study_program_id', '=', 'study_programs.id')
                ->orderBy('study_programs.name', $direction)
                ->select('users.*');
        }, function ($query) use ($sort, $direction) {
            $query->orderBy($sort, $direction);
        })
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhereHas('studyProgram', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        })
        ->paginate($paginationCount);

    $studyPrograms = StudyProgram::all();

    return view('admin.user_management.index', compact('users', 'studyPrograms', 'sort', 'direction', 'roleFilter'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $studyPrograms = StudyProgram::all();

        return view('admin.user_management.create', compact('studyPrograms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'study_program_id' => 'required|exists:study_programs,id',
        ]);

        if ($request->password !== $request->password_confirmation) {
            return redirect()->back()->withErrors(['password' => 'Password tidak cocok.']);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'study_program_id' => $request->study_program_id,
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
