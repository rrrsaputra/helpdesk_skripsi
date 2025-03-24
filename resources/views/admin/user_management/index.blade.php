@extends('layouts.admin')

@section('header')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert"
            style="opacity: 1; transition: opacity 0.5s;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('success-alert').style.opacity = '0';
            }, 4500); // Mengurangi 500ms untuk transisi lebih halus
            setTimeout(function() {
                document.getElementById('success-alert').style.display = 'none';
            }, 5000);
        </script>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="danger-alert"
            style="opacity: 1; transition: opacity 0.5s;">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('danger-alert').style.opacity = '0';
            }, 4500); // Mengurangi 500ms untuk transisi lebih halus
            setTimeout(function() {
                document.getElementById('danger-alert').style.display = 'none';
            }, 5000);
        </script>
    @endif
    <x-admin.header title='User Management' />
@endsection

@section('content')
    @php
        $columns = ['Email', 'Name', 'NIM', 'Study Program', 'Program Kuliah', 'Role'];
        $data = $users
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'url' => '/path/to/resource1',
                    'values' => [
                        $user->email,
                        $user->name,
                        $user->username,
                        $user->studyProgram->name ?? 'N/A',
                        $user->lecture_program ?? 'N/A',
                        $user->roles->pluck('name')->first(),
                    ],
                    'ticket_quota' => $user->ticket_quota,
                ];
            })
            ->toArray();
        $columnSizes = array_map(function ($column) {
            return $column === 'User Name' ? '30%' : 'auto';
        }, $columns);
    @endphp

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">

    <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <!-- Search + Role Filter -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('admin.user_management.index') }}" method="GET">
                                <div class="row align-items-end">
                                    <!-- Search -->
                                    <div class="col-md-8 col-sm-12 mb-2">
                                        <label for="search">Search User</label>
                                        <input type="search" class="form-control" id="search" name="search"
                                            placeholder="Search user" value="{{ request('search') }}">
                                    </div>

                                    <!-- Search Button -->
                                    <div class="col-md-2 col-sm-6 mb-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>

                                    <!-- Add User -->
                                    <div class="col-md-2 col-sm-6 mb-2 text-md-right">
                                        <a href="{{ route('admin.user_management.create') }}" class="btn btn-success w-100">
                                            <i class="fas fa-user-plus"></i> Add User
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <!-- Role Filter -->
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.user_management.index') }}"
                                        class="btn {{ request('role') == null ? 'btn-secondary' : 'btn-outline-secondary' }} rounded-pill shadow-sm">
                                        <i class="fas fa-users"></i> Semua
                                    </a>
                                    <a href="{{ route('admin.user_management.index', array_merge(request()->all(), ['role' => 'user'])) }}"
                                        class="btn {{ request('role') == 'user' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill shadow-sm">
                                        <i class="fas fa-user-graduate"></i> Mahasiswa
                                    </a>
                                    <a href="{{ route('admin.user_management.index', array_merge(request()->all(), ['role' => 'agent'])) }}"
                                        class="btn {{ request('role') == 'agent' ? 'btn-success' : 'btn-outline-success' }} rounded-pill shadow-sm">
                                        <i class="fas fa-user-cog"></i> Staf
                                    </a>
                                    <a href="{{ route('admin.user_management.index', array_merge(request()->all(), ['role' => 'admin'])) }}"
                                        class="btn {{ request('role') == 'admin' ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill shadow-sm">
                                        <i class="fas fa-user-shield"></i> Admin
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table id="example2" class="table table-hover">
                            <thead>
                                <tr>
                                    @foreach ($columns as $index => $column)
                                        <th style="width: {{ $columnSizes[$index] ?? 'auto' }}">
                                            @php
                                                // Mapping nama kolom dengan nama kolom di database
                                                $columnMap = [
                                                    'Email' => 'email',
                                                    'Name' => 'name',
                                                    'NIM' => 'username',
                                                    'Study Program' => 'study_program_name',
                                                    'Program Kuliah' => 'lecture_program',
                                                ];
                                                $sortColumn = $columnMap[$column] ?? null;
                                            @endphp

                                            @if ($sortColumn)
                                                <a
                                                    href="{{ route('admin.user_management.index', array_merge(request()->all(), ['sort' => $sortColumn, 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                                    {{ $column }}
                                                    @if (request('sort') === $sortColumn)
                                                        <i
                                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                                    @endif
                                                </a>
                                            @else
                                                {{ $column }}
                                            @endif
                                        </th>
                                    @endforeach
                                    <th>Actions</th> <!-- Added Actions column -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr style="cursor: pointer" data-id="{{ $row['id'] }}">
                                        @foreach ($row['values'] as $value)
                                            <td>
                                                @if (is_array($value))
                                                    @foreach ($value as $index => $subValue)
                                                        <div>
                                                            @php
                                                                $charLimit =
                                                                    isset($columnSizes[$index]) &&
                                                                    is_numeric($columnSizes[$index])
                                                                        ? intval($columnSizes[$index] * 0.5)
                                                                        : 70;
                                                            @endphp
                                                            @if ($index === 0)
                                                                <strong>{!! strlen($subValue) > $charLimit ? substr($subValue, 0, $charLimit) . '...' : $subValue !!}</strong>
                                                            @else
                                                                {!! strlen($subValue) > $charLimit ? substr($subValue, 0, $charLimit) . '...' : $subValue !!}
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        @endforeach
                                        <td> <!-- Added Actions buttons -->
                                            <div class="btn-group" role="group" aria-label="Action buttons"
                                                style="gap: 5px;">
                                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#editModal-{{ $row['id'] }}" title="Password">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#typeModal-{{ $row['id'] }}" title="Edit User">
                                                    <i class="fas fa-cogs"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteModal-{{ $row['id'] }}" title="Delete User">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>

                                            <!-- Update Password Modal -->
                                            <div class="modal fade" id="editModal-{{ $row['id'] }}" tabindex="-1"
                                                role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Update Password
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                                            </p>
                                                            <form id="updatePasswordForm-{{ $row['id'] }}"
                                                                action="{{ route('admin.user_management.updatePassword', $row['id']) }}"
                                                                method="POST" class="mt-6 space-y-6">
                                                                @csrf
                                                                @method('POST')

                                                                @if ($errors->any())
                                                                    <div class="alert alert-danger">
                                                                        <ul>
                                                                            @foreach ($errors->all() as $error)
                                                                                <li>{{ $error }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                @endif

                                                                <div class="form-group">
                                                                    <label for="password-{{ $row['id'] }}"
                                                                        class="form-label">{{ __('New Password') }}</label>
                                                                    <input id="password-{{ $row['id'] }}"
                                                                        name="password" type="password"
                                                                        class="form-control mt-1 block w-full" required>
                                                                    {{-- @if ($errors->has('password'))
                                                                        <span
                                                                            class="text-danger mt-2">{{ $errors->first('password') }}</span>
                                                                    @endif --}}
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="password_confirmation-{{ $row['id'] }}"
                                                                        class="form-label">{{ __('Confirm New Password') }}</label>
                                                                    <input id="password_confirmation-{{ $row['id'] }}"
                                                                        name="password_confirmation" type="password"
                                                                        class="form-control mt-1 block w-full" required>
                                                                    {{-- @if ($errors->has('password_confirmation'))
                                                                        <span
                                                                            class="text-danger mt-2">{{ $errors->first('password_confirmation') }}</span>
                                                                    @endif --}}
                                                                </div>

                                                                <div class="form-group flex items-center gap-4">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">{{ __('Update Password') }}</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal-{{ $row['id'] }}" tabindex="-1"
                                                role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Once your account is deleted, all of its resources and data will
                                                            be permanently deleted. Are you sure you want to delete this
                                                            user?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="POST"
                                                                action="{{ route('admin.user_management.destroy', $row['id']) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- UPDATE STUDY PROGRAM AND ROLE -->
                                    <form method="POST"
                                        action="{{ route('admin.user_management.update', $row['id']) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal fade" id="typeModal-{{ $row['id'] }}" tabindex="-1"
                                            role="dialog" aria-labelledby="typeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="typeModalLabel">Update Study Program
                                                            and
                                                            Role</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="userType">Study Program:</label>
                                                        <select id="userType" name="type" class="form-control"
                                                            required>
                                                            @foreach ($studyPrograms as $program)
                                                                <option value="{{ $program->id }}"
                                                                    {{ $row['values'][2] == $program->name ? 'selected' : '' }}>
                                                                    {{ $program->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="userRole" class="mt-3">User Role:</label>
                                                        <select id="userRole" name="role" class="form-control"
                                                            required>
                                                            <option value="user"
                                                                {{ $row['values'][3] == 'user' ? 'selected' : '' }}>
                                                                User
                                                            </option>
                                                            <option value="agent"
                                                                {{ $row['values'][3] == 'agent' ? 'selected' : '' }}>
                                                                Agent
                                                            </option>
                                                            <option value="admin"
                                                                {{ $row['values'][3] == 'admin' ? 'selected' : '' }}>
                                                                Admin
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="8">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- DataTables & Plugins -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"], // Tambahkan koma di sini
                "order": [
                    [3, 'asc']
                ] // Mengurutkan berdasarkan kolom "Role"
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
