@extends('layouts.agent')
@section('header')
    <x-agent.header title="agent"/>
@endsection

@section('content')
@php
    $columns = ['','Customer', 'Summary', '', 'Number', 'Last Updated', 'latitude', 'longitude'];
    $data = $tickets->map(function($ticket) {
        return [
            'id' => $ticket->id,
            'url' => '/path/to/resource1',
            'values' => [
                '', 
                $ticket->user->name, 
                [$ticket->title, $ticket->message ?? ''], 
                '', 
                $ticket->id, 
                $ticket->last_updated, 
                $ticket->latitude, 
                $ticket->longitude
            ]
        ];
    })->toArray();
    $columnSizes = array_map(function($column) {
        return $column === 'Summary' ? '40%' : 'auto';
    }, $columns);
@endphp

<link href='https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js'></script>
<style>
    #map {
        height: 400px;
    }
</style>

<div id="map"></div>
<!-- Start of Selection -->
<button id="resetMapButton" class="btn btn-primary my-3 mx-1">Reset Map Position</button>
<!-- End of Selection -->


<script>
    document.getElementById('resetMapButton').addEventListener('click', function() {
        map.flyTo({
            center: [113.9213, -0.7893], // Default center coordinates
            zoom: 4 // Default zoom level
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        mapboxgl.accessToken = '{{ env('MAPBOX_ACCESS_TOKEN') }}';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v10',
            center: [113.9213, -0.7893],
            zoom: 4,
            scrollZoom: false // Disable map scrolling
        });
        map.addControl(new mapboxgl.NavigationControl());
        var points = {!! json_encode($tickets->map(function($ticket) {
            return [
                'id' => $ticket->id,
                'coordinates' => [$ticket->longitude, $ticket->latitude],
                'title' => $ticket->title,
                'description' => $ticket->message ?? 'No description available.'
            ];
        })->toArray()) !!};

        var markers = {};

        points.forEach(function(point) {
            var el = document.createElement('div');
            el.className = 'marker';
            el.style.backgroundImage = 'url(https://upload.wikimedia.org/wikipedia/commons/0/0e/Basic_red_dot.png)';
            el.style.width = '8px';
            el.style.height = '8px';
            el.style.backgroundSize = '100%';

            var marker = new mapboxgl.Marker(el)
                .setLngLat(point.coordinates)
                .addTo(map);

            var popup = new mapboxgl.Popup({ offset: 25 })
                .setText(point.title + ': ' + point.description);

            marker.getElement().addEventListener('click', function() {
                console.log('Marker clicked:', point);
                popup.addTo(map);
                map.flyTo({
                    center: point.coordinates,
                    zoom: 10
                });
            });

            marker.getElement().addEventListener('mouseleave', function() {
                popup.remove();
            });

            markers[point.id] = marker;
        });

  

        window.map = map;
        window.markers = markers;
    });

    function handleRowClick(event) {
        var row = event.currentTarget;
        var coordinates = row.getAttribute('data-coordinates');
        if (coordinates) {
            var coords = coordinates.split(',').map(parseFloat);
            var lng = coords[1];
            var lat = coords[0];
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
    }
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">

<div class="card">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable with minimal features & hover style</h3>
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
                                    <tr style="cursor: pointer" data-id="{{ $row['id'] }}" data-coordinates="{{ $row['values'][6] }},{{ $row['values'][7] }}" onclick="handleRowClick(event)">
                                        @foreach ($row['values'] as $value)
                                            <td>
                                                @if (is_array($value))
                                                    @foreach ($value as $index => $subValue)
                                                        <div>
                                                            @php
                                                                $charLimit = isset($columnSizes[$index]) && is_numeric($columnSizes[$index]) ? intval($columnSizes[$index] * 0.5) : 70;
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
                                            <button class="btn btn-primary btn-sm" onclick="event.stopPropagation();">View</button>
                                            @if(request()->input('inbox') == 'unassigned' || request()->input('inbox') == '')
                                            <form action="{{ route('agent.ticket.get', $row['id']) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">Get</button>
                                            </form>
                                            @elseif(request()->input('inbox') == 'mine')
                                            <form action="{{ route('agent.ticket.close', $row['id']) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                                @csrf
                                                @method('PATCH')
                                      
                                                <button type="submit" class="btn btn-success btn-sm">Close</button>
                                            </form>
                                            <button class="btn btn-info btn-sm" onclick="event.stopPropagation();">Assign to</button>
                                            <form action="{{ route('agent.ticket.unassign', $row['id']) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm">Unassign</button>
                                            </form>
                                            @elseif(request()->input('inbox') == 'closed')
                                            <form action="{{ route('agent.ticket.reopen_ticket', $row['id']) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-info btn-sm">Reopen</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No articles available</td> <!-- Updated colspan to 8 to include Actions column -->
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
<script src="{{ asset('AdminLTE-3.2.0/dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": [
                { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy' },
                { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV' },
                { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel' },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                { extend: 'print', text: '<i class="fas fa-print"></i> Print' },
                { extend: 'colvis', text: '<i class="fas fa-columns"></i> Column visibility' }
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
            "buttons": [
                { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy' },
                { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV' },
                { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel' },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                { extend: 'print', text: '<i class="fas fa-print"></i> Print' },
                { extend: 'colvis', text: '<i class="fas fa-columns"></i> Column visibility' }
            ]
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

        $('#example2').on('click', 'tr', function() {
            var coordinates = $(this).data('coordinates');
            console.log('Row clicked with coordinates:', coordinates);
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