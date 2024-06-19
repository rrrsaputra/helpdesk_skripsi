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
            'Assigned To',
            'Assigned From',
            'Link',
        ];
        $data = $scheduledCalls
            ->map(function ($scheduledCall) {
                return [
                    'id' => $scheduledCall->id,
                    'url' => '/path/to/resource1',
                    'values' => [
                        $scheduledCall->user->name,
                        [$scheduledCall->title, $scheduledCall->message ?? ''],
                        $scheduledCall->id,
                        $scheduledCall->duration . ' minutes',
                        $scheduledCall->start_time,
                        $scheduledCall->finish_time,
                        $scheduledCall->assigned_to,
                        $scheduledCall->assigned_from,
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
                    <div class="card-header">
                        <h3 class="card-title">Scheduled Calls</h3>
                    </div>
                    <div class="card-body">
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
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                                <button class="btn btn-info btn-sm">View</button>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <form method="POST"
                                            action="{{ route('agent.scheduled_call.update', $row['id']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal fade" id="assignToModal{{ $row['id'] }}" tabindex="-1" role="dialog"
                                                aria-labelledby="assignToModalLabel{{ $row['id'] }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="assignToModalLabel{{ $row['id'] }}">Add Meet</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="link">Link</label>
                                                                <input type="text" class="form-control" id="link{{ $row['id'] }}"
                                                                    name="link" placeholder="Enter link">
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
                                            <td colspan="9">No articles available</td>
                                            <!-- Updated colspan to 9 to include Actions column -->
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
