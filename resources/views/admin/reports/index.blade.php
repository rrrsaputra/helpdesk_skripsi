@extends('layouts.admin')
@section('header')
    <x-admin.header title="Ticket Report" />
@endsection

@section('content')
    @php
        $columns = [
            'Reference',
            'Date',
            'Time',
            'Date Closed',
            'Status',
            'Name',
            'NIM',
            'Study Program',
            'Lecture Program',
            'Agent Name',
            'Category',
            'Subject',
            'Message',
            'Feedback',
        ];
        $data = $tickets
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'url' => '/path/to/resource1',
                    'values' => [
                        $ticket->references,
                        $ticket->created_at->format('d/m/Y'),
                        $ticket->created_at->format('H:i:s'),
                        $ticket->updated_at->format('d/m/Y'),
                        $ticket->status,
                        $ticket->user->name,
                        $ticket->user->username,
                        $ticket->user->studyProgram->name ?? 'N/A',
                        $ticket->lecture_program ?? 'N/A',
                        $ticket->assignedToUser->name ?? 'Unassigned',
                        $ticket->category,
                        $ticket->title,
                        strip_tags($ticket->message),
                        '',
                    ],
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

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-ticket-alt"></i> Total Tiket</h5>
                    <p class="card-text h4"><strong>{{ $totalTickets }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-folder-open"></i> Tiket Open</h5>
                    <p class="card-text h4"><strong>{{ $totalOpen }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-pause-circle"></i> Tiket On Hold</h5>
                    <p class="card-text h4"><strong>{{ $totalOnHold }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-times-circle"></i> Tiket Closed</h5>
                    <p class="card-text h4"><strong>{{ $totalClosed }}</strong></p>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form action="{{ route('admin.report.index') }}" method="GET">
                                <div class="row align-items-end">
                                    <!-- Search -->
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <label for="search">Search</label>
                                        <input type="search" class="form-control" id="search" name="search"
                                            placeholder="Search report" value="{{ request('search') }}">
                                    </div>
                    
                                    <!-- Since -->
                                    <div class="col-md-2 col-sm-6 mb-3">
                                        <label for="since">Since</label>
                                        <input type="date" class="form-control" id="since" name="since"
                                            value="{{ request('since') }}">
                                    </div>
                    
                                    <!-- Until -->
                                    <div class="col-md-2 col-sm-6 mb-3">
                                        <label for="until">Until</label>
                                        <input type="date" class="form-control" id="until" name="until"
                                            value="{{ request('until') }}">
                                    </div>
                    
                                    <!-- Search Button -->
                                    <div class="col-md-2 col-sm-6 mb-3">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                    
                                    <!-- Export Buttons -->
                                    <div class="col-md-3 col-sm-12 text-md-right text-left mb-3">
                                        <a href="{{ route('admin.report.export', [
                                            'since' => request('since'),
                                            'until' => request('until'),
                                            'search' => request('search'),
                                            'sort' => request('sort'),
                                            'direction' => request('direction'),
                                            'format' => 'xlsx',
                                        ]) }}"
                                            class="btn btn-outline-success mb-1">
                                            <i class="fas fa-file-excel"></i> Excel
                                        </a>
                    
                                        <a href="{{ route('admin.report.export', [
                                            'since' => request('since'),
                                            'until' => request('until'),
                                            'search' => request('search'),
                                            'sort' => request('sort'),
                                            'direction' => request('direction'),
                                            'format' => 'csv',
                                        ]) }}"
                                            class="btn btn-outline-info mb-1">
                                            <i class="fas fa-file-csv"></i> CSV
                                        </a>
                                    </div>
                                </div>
                            </form>
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
                                                    'Reference' => 'references',
                                                    'Date' => 'created_at',
                                                    'Time' => 'created_at',
                                                    'Date Closed' => 'updated_at',
                                                    'Status' => 'status',
                                                    'Name' => 'user_name', // ganti nama mapping untuk user
                                                    'NIM' => 'username',
                                                    'Study Program' => 'study_program_name',
                                                    'Lecture Program' => 'lecture_program',
                                                    'Agent Name' => 'agent_name', // ganti nama mapping untuk assignedToUser
                                                    'Category' => 'category',
                                                    'Subject' => 'title',
                                                    'Message' => 'message',
                                                    'Feedback' => 'feedback',
                                                ];
                                                $sortColumn = $columnMap[$column] ?? null;
                                            @endphp

                                            @if ($sortColumn)
                                                <a
                                                    href="{{ route('admin.report.index', array_merge(request()->all(), ['sort' => $sortColumn, 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                </tr>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr style="cursor: pointer" data-id="{{ $row['id'] }}">
                                        @foreach ($row['values'] as $index => $value)
                                            <td>
                                                <input type="text" name="values[]" value="{{ $value }}"
                                                    class="form-control" readonly
                                                    style="width: 200px; pointer-events: none;">
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $tickets->links() }}
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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
