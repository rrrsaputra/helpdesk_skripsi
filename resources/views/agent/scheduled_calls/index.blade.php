@extends('layouts.agent')
@section('header')
    <x-admin.header title="List of Schedule Calls" />
@endsection

@section('content')

    @php
        $columns = [
            'Customer',
            'Summary',
            'Number',
            'Duration',
            'Start Time',
            'Finish Time',
            'Status',
            // 'Assigned To',
            // 'Assigned From',
            'Link',
        ];
        $data = $scheduledCalls
            ->map(function ($scheduledCall) {
                return [
                    'id' => $scheduledCall->id,
                    'url' => '/path/to/resource1',
                    'values' => [
                        $scheduledCall->user->name,
                        [$scheduledCall->title, $scheduledCall->category, $scheduledCall->message ?? ''],
                        $scheduledCall->id,
                        $scheduledCall->duration . ' minutes',
                        $scheduledCall->start_time,
                        $scheduledCall->finish_time,
                        $scheduledCall->status,
                        // $scheduledCall->assigned_to,
                        // $scheduledCall->assigned_from,
                        $scheduledCall->link,
                    ],
                ];
            })
            ->toArray();
        $columnSizes = array_map(function ($column) {
            return $column === 'Summary' ? '25%' : 'auto';
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
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <form action="{{ route('agent.scheduled_call.index') }}" method="GET" class="form-inline">
                                <div class="form-group">
                                    <input type="search" class="form-control" id="search" name="search"
                                        style="width: 500px;" placeholder="Search by title, message, and status">
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
                                                    data-target="#assignToModal{{ $row['id'] }}">Add Meet</button>
                                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#rescheduleModal{{ $row['id'] }}">Reschedule</button>
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                                <button class="btn btn-info btn-sm">View</button>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <form method="POST"
                                            action="{{ route('agent.scheduled_call.update', $row['id']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal fade" id="assignToModal{{ $row['id'] }}" tabindex="-1"
                                                role="dialog" aria-labelledby="assignToModalLabel{{ $row['id'] }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="assignToModalLabel{{ $row['id'] }}">Add Meet</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="link">Link</label>
                                                                <input type="text" class="form-control"
                                                                    id="link{{ $row['id'] }}" name="link"
                                                                    placeholder="Enter link">
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

                                        <!-- Modal for Reschedule -->
                                        <form method="POST"
                                            action="{{ route('agent.scheduled_call.update', $row['id']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal fade" id="rescheduleModal{{ $row['id'] }}" tabindex="-1"
                                                role="dialog" aria-labelledby="rescheduleModalLabel{{ $row['id'] }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="rescheduleModalLabel{{ $row['id'] }}">Reschedule
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="date">Date</label>
                                                                <input type="date" class="form-control"
                                                                    id="date{{ $row['id'] }}" name="date" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="duration">Choose Duration</label>
                                                                <select class="form-control"
                                                                    id="duration{{ $row['id'] }}" name="duration">
                                                                    <option value="30">30 minutes</option>
                                                                    <option value="45">45 minutes</option>
                                                                    <option value="60">60 minutes</option>
                                                                    <option value="90">90 minutes</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="time">Choose Time</label>
                                                                <select class="form-control" id="time{{ $row['id'] }}"
                                                                    name="time" required>
                                                                    <option value="09:00">09:00 AM</option>
                                                                    <option value="09:30">09:30 AM</option>
                                                                    <option value="10:00">10:00 AM</option>
                                                                    <option value="10:30">10:30 AM</option>
                                                                    <option value="11:00">11:00 AM</option>
                                                                    <option value="11:30">11:30 AM</option>
                                                                    <option value="12:00">12:00 PM</option>
                                                                    <option value="12:30">12:30 PM</option>
                                                                    <option value="13:00">01:00 PM</option>
                                                                    <option value="13:30">01:30 PM</option>
                                                                    <option value="14:00">02:00 PM</option>
                                                                    <option value="14:30">02:30 PM</option>
                                                                    <option value="15:00">03:00 PM</option>
                                                                    <option value="15:30">03:30 PM</option>
                                                                    <option value="16:00">04:00 PM</option>
                                                                    <option value="16:30">04:30 PM</option>
                                                                </select>
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
                                    @empty
                                        <tr>
                                            <td colspan="9">No scheduled calls available</td>
                                            <!-- Updated colspan to 9 to include Actions column -->
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $scheduledCalls->links() }}
                        </div>
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

@endsection
