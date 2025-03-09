@extends('layouts.admin')
@section('header')
    <x-admin.header title="Ticket Report" />
@endsection

@section('content')
    @php
        $columns = [
            'Reference',
            'Date',
            'Category',
            'Topic',
            'Case',
            'Time Received',
            'Time Delivered',
            'Status',
            'Link',
        ];
        $data = $tickets
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'url' => '/path/to/resource1',
                    'values' => [
                        $ticket->references,
                        $ticket->created_at,
                        $ticket->category,
                        $ticket->title,
                        strip_tags($ticket->message),
                        $ticket->created_at,
                        $ticket->updated_at,
                        $ticket->status,
                        env('APP_URL'). '/admin/data-repository?ticket=' . $ticket->references,
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

    <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-inline">
                            <form action="{{ route('admin.report.index') }}" method="GET" class="form-inline mr-2">
                                <div class="form-group">
                                    <input type="search" class="form-control" id="search" name="search"
                                        style="width: 200px;" placeholder="Search by category"
                                        value="{{ request('search') }}">
                                </div>
                                <div class="form-group mx-sm-2">
                                    <label for="since">Since: </label>
                                    <input type="date" class="form-control" id="since" name="since"
                                        placeholder="Since" value="{{ request('since') }}">
                                </div>
                                <div class="form-group mx-sm-2">
                                    <label for="until">Until: </label>
                                    <input type="date" class="form-control" id="until" name="until"
                                        placeholder="Until" value="{{ request('until') }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                            <div class="ml-auto">
                                <a href="{{ route('admin.report.export', ['since' => request('since'), 'until' => request('until'), 'search' => request('search'), 'sort' => request('sort'), 'direction' => request('direction')]) }}"
                                    class="btn btn-success">Export to Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example2" class="table table-hover">
                            <thead>
                                <tr>
                                    @foreach ($columns as $index => $column)
                                        <th style="width: {{ $columnSizes[$index] ?? 'auto' }}">
                                            @if ($column === 'Date')
                                                <a
                                                    href="{{ route('admin.report.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                                    {{ $column }}
                                                    @if (request('sort') === 'created_at')
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
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr style="cursor: pointer" data-id="{{ $row['id'] }}">
                                        <form action="{{ route('admin.report.update', $row['id']) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            @foreach ($row['values'] as $index => $value)
                                                <td>
                                                    @if (in_array($index, [0, 12]))
                                                        <!-- Assuming 13 is the index for 'references' -->
                                                        <input type="text" name="values[]" value="{{ $value }}"
                                                            class="form-control" readonly style="width: 75px">
                                                    @elseif ($index === 13)
                                                        <!-- Assuming 14 is the index for 'link' -->
                                                        <input type="text" name="values[]" value="{{ $value }}"
                                                            class="form-control" readonly style="width: 200px;">
                                                    @elseif (in_array($index, [1, 9, 10]))
                                                        <!-- Date, Time Received, Time Delivered -->
                                                        <input type="datetime-local" name="values[]"
                                                            value="{{ $value }}" class="form-control">
                                                    @elseif ($index === 2)
                                                        <!-- General Category as Dropdown -->
                                                        <select name="values[]" class="form-control" style="width: 200px;">
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->name }}"
                                                                    {{ $category->name == $value ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <input type="text" name="values[]" value="{{ $value }}"
                                                            class="form-control" style="width: 200px;">
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                <button type="submit" class="btn btn-primary" title="Save">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </td>
                                        </form>
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
