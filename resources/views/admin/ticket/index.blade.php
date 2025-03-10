@extends('layouts.admin')
@section('header')
    <x-agent.header title="Ticket" />
@endsection

@section('content')
    @php
        $columns = [
            'Customer',
            'Summary',
            '',
            'Number',
            'Last Updated',
            'Assigned To',
            'References',
            'latitude',
            'longitude',
        ];
        $data = $tickets
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'url' => '/path/to/resource1',
                    'values' => [
                        $ticket->user->name,
                        [$ticket->title, $ticket->category, $ticket->message ?? ''],
                        '',
                        $ticket->id,
                        $ticket->last_updated,
                        $ticket->assignedTo->name ?? 'Unassigned', // Perubahan di sini
                        $ticket->references ?? 'No references', // Added references
                        $ticket->latitude,
                        $ticket->longitude,
                    ],
                ];
            })
            ->toArray();
        $columnSizes = array_map(function ($column) {
            return $column === 'Summary' ? '35%' : 'auto';
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
                        <form action="{{ route('admin.ticket.index') }}" method="GET" class="form-inline">
                            <div class="form-group">
                                <input type="search" class="form-control" id="search" name="search"
                                    style="width: 500px;" placeholder="Search by title, message, and category">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
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
                                    <tr style="cursor: pointer" data-id="{{ $row['id'] }}"
                                        data-coordinates="{{ $row['values'][7] }},{{ $row['values'][8] }}"
                                        onclick="handleRowClick(event)">
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

                                            @if (request()->input('inbox') == 'unassigned' || request()->input('inbox') == '')
                                                <form action="{{ route('admin.ticket.update', $row['id']) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#assignToModal-{{ $row['id'] }}">Assign</button>
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#editModal{{ $row['id'] }}">Edit</button>
                                                    <div class="modal fade" id="assignToModal-{{ $row['id'] }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="assignToModalLabel-{{ $row['id'] }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="assignToModalLabel-{{ $row['id'] }}">Assign
                                                                        To</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <label for="agentSelect-{{ $row['id'] }}">Choose
                                                                        Agent:</label>
                                                                    <select id="agentSelect-{{ $row['id'] }}"
                                                                        name="agent_id" class="form-control">
                                                                        <option value="" selected disabled>Pick Agent
                                                                        </option>
                                                                        @foreach ($agents as $agent)
                                                                            <option value="{{ $agent->id }}">
                                                                                {{ $agent->name }} ({{ $agent->email }})
                                                                            </option>
                                                                        @endforeach
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

                                                <form action="{{ route('admin.ticket.update', $row['id']) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal fade" id="editModal{{ $row['id'] }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="editModalLabel{{ $row['id'] }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editModalLabel{{ $row['id'] }}">Update
                                                                        Latitude and Longitude</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="latitude">Latitude</label>
                                                                        <input type="text" class="form-control"
                                                                            id="latitude" name="latitude"
                                                                            value="{{ $row['values'][7] }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="longitude">Longitude</label>
                                                                        <input type="text" class="form-control"
                                                                            id="longitude" name="longitude"
                                                                            value="{{ $row['values'][8] }}">
                                                                    </div>
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
                                            @elseif(request()->input('inbox') == 'assigned')
                                                <form action="{{ route('admin.ticket.close', $row['id']) }}"
                                                    method="POST" style="display:inline;"
                                                    onclick="event.stopPropagation();">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="btn btn-success btn-sm">Close</button>
                                                </form>
                                                <form action="{{ route('admin.ticket.unassign', $row['id']) }}"
                                                    method="POST" style="display:inline;"
                                                    onclick="event.stopPropagation();">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger btn-sm">Unassign</button>
                                                </form>
                                            @elseif(request()->input('inbox') == 'closed')
                                                <form action="{{ route('admin.ticket.reopen_ticket', $row['id']) }}"
                                                    method="POST" style="display:inline;"
                                                    onclick="event.stopPropagation();">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-info btn-sm">Reopen</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>


                                    <!-- Modal for updating latitude and longitude -->




                                @empty
                                    <tr>
                                        <td colspan="10">No articles available</td>
                                        <!-- Updated colspan to 10 to include Actions column -->
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

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print'
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns"></i> Column visibility'
                    }
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": [{
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print'
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns"></i> Column visibility'
                    }
                ]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

            $('#example2').on('click', 'tr', function() {
                var coordinates = $(this).data('coordinates');

                if (coordinates) {
                    var [lng, lat] = coordinates.split(',').map(parseFloat);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        window.map.flyTo({
                            center: [lng, lat],
                            zoom: 13
                        });
                    } else {
                        console.error('Invalid coordinates: ', coordinates);
                    }
                } else {
                    console.error('No coordinates data attribute found.');
                }
            });

            $('#example2 tbody').on('mouseover', 'tr', function() {
                $(this).css('cursor', 'pointer');
            });
        });
    </script>
@endsection
