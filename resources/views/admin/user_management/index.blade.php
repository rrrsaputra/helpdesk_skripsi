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
        $columns = ['Email', 'Customer', 'Study Program', 'Role'];
        $data = $users
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'url' => '/path/to/resource1',
                    'values' => [$user->email, $user->name, $user->studyProgram->name ?? 'N/A', $user->roles->pluck('name')->first()],
                    'ticket_quota' => $user->ticket_quota,
                ];
            })
            ->toArray();
        $columnSizes = array_map(function ($column) {
            return $column === 'Customer' ? '30%' : 'auto';
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
                    <div class="form-group">
                        <form action="{{ route('admin.user_management.index') }}" method="GET" class="form-inline">
                            <div class="form-group">
                                <input type="search" class="form-control" id="search" name="search"
                                    style="width: 500px;" placeholder="Search by customer name">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>

                    <a href="{{ route('admin.user_management.create') }}" class="btn btn-primary mb-3">Add User</a>

                    <div class="table-responsive">
                        <table id="example2" class="table table-hover">
                            <thead>
                                <tr>
                                    @foreach ($columns as $index => $column)
                                        <th style="width: {{ $columnSizes[$index] ?? 'auto' }}">{{ $column }}</th>
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
                                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editModal-{{ $row['id'] }}">Edit</button>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#typeModal-{{ $row['id'] }}">Manage</button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteModal-{{ $row['id'] }}">Delete</button>

                                            <!-- Update Password Modal -->
                                            <div class="modal fade" id="editModal-{{ $row['id'] }}" tabindex="-1"
                                                role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Update Password</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 mb-6">
                                                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                                            </p>
                                                            <form id="updatePasswordForm-{{ $row['id'] }}"
                                                                action="{{ route('admin.user_management.updatePassword', $row['id']) }}"
                                                                method="POST" class="mt-6 space-y-6">
                                                                @csrf
                                                                @method('POST')

                                                                <div class="form-group">
                                                                    <label for="current_password-{{ $row['id'] }}"
                                                                        class="form-label">{{ __('Current Password') }}</label>
                                                                    <input id="current_password-{{ $row['id'] }}"
                                                                        name="current_password" type="password"
                                                                        class="form-control mt-1 block w-full" required>
                                                                    @if ($errors->has('current_password'))
                                                                        <span
                                                                            class="text-danger mt-2">{{ $errors->first('current_password') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="password-{{ $row['id'] }}"
                                                                        class="form-label">{{ __('New Password') }}</label>
                                                                    <input id="password-{{ $row['id'] }}"
                                                                        name="password" type="password"
                                                                        class="form-control mt-1 block w-full" required>
                                                                    @if ($errors->has('password'))
                                                                        <span
                                                                            class="text-danger mt-2">{{ $errors->first('password') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="password_confirmation-{{ $row['id'] }}"
                                                                        class="form-label">{{ __('Confirm New Password') }}</label>
                                                                    <input id="password_confirmation-{{ $row['id'] }}"
                                                                        name="password_confirmation" type="password"
                                                                        class="form-control mt-1 block w-full" required>
                                                                    @if ($errors->has('password_confirmation'))
                                                                        <span
                                                                            class="text-danger mt-2">{{ $errors->first('password_confirmation') }}</span>
                                                                    @endif
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
                                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 mb-6">
                                                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                                            </p>
                                                            <form id="deleteForm-{{ $row['id'] }}"
                                                                action="{{ route('profile.destroy', $row['id']) }}"
                                                                method="POST" class="mt-6 space-y-6">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="form-group">
                                                                    <label for="password-{{ $row['id'] }}"
                                                                        class="form-label mb-2">{{ __('Password') }}</label>
                                                                    <input id="password-{{ $row['id'] }}"
                                                                        name="password" type="password"
                                                                        class="form-control mt-1 block w-full"
                                                                        placeholder="{{ __('Password') }}" required>
                                                                    @if ($errors->userDeletion->has('password'))
                                                                        <span
                                                                            class="text-danger mt-2">{{ $errors->userDeletion->first('password') }}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group flex items-center gap-4">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">{{ __('Delete Account') }}</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <form method="POST"
                                        action="{{ route('admin.user_management.update', $row['id']) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal fade" id="typeModal-{{ $row['id'] }}" tabindex="-1"
                                            role="dialog" aria-labelledby="typeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="typeModalLabel">Update User Type and
                                                            Role</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="userType">PIC:</label>
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




    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
