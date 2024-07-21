@extends('layouts.user')

@section('css')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.js"></script>
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="dx-main">
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

        <div class="dx-separator"></div>
        <div class="dx-box-5 pb-100 bg-grey-6">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <form action="{{ route('user.ticket.store') }}" method="POST" class="dx-form"
                            enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                            @csrf
                            <div class="dx-box dx-box-decorated">
                                <div class="dx-box-content">
                                    <h2 class="h6 mb-6">Submit a Ticket</h2>
                                    <!-- START: Breadcrumbs -->
                                    <nav aria-label="breadcrumb">
                                        <uo class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Ticket
                                                    System</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Submit a Ticket</li>
                                            </ol>
                                    </nav>
                                    <!-- END: Breadcrumbs -->
                                </div>
                                <div class="dx-separator"></div>

                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="category" class="mnt-7">Ticket Category</label>
                                        <select class="form-control form-control-style-2" id="category" name="category">
                                            @foreach ($ticketCategories as $ticketCategory)
                                                <option value="{{ $ticketCategory->name }}">{{ $ticketCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="dx-separator"></div>

                                <div class="dx-box-content">
                                    <link
                                        href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
                                        rel="stylesheet" />
                                    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />

                                    <div class="dx-form-group">
                                        <label for="subject" class="mnt-7">Subject</label>
                                        <input type="text" class="form-control form-control-style-2" id="subject"
                                            placeholder="Enter Subject" name="title">
                                    </div>
                                    <div class="dx-form-group">
                                        <label class="mnt-7">Attachments</label>
                                        <input type="file" class="filepond" id="fileInput" multiple>
                                        <input type="hidden" name="filepond" id="hidden_filePaths">
                                    </div>
                                    <div class="dx-form-group">
                                        <label class="mnt-7">Message</label>
                                        <div class="dx-editors" data-editor-height="150" data-editor-maxheight="250"
                                            style="min-height: 150px; max-height: 250px;">
                                        </div>
                                        <input type="hidden" name="message" id="message">
                                    </div>
                                </div>

                                <div class="dx-separator"></div>



                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-6 mb-20">
                                                <label for="latitude" class="mnt-7">Lat:</label>
                                                <input type="text" class="form-control form-control-style-2"
                                                    id="latitude" placeholder="Enter Latitude" name='latitude'>
                                            </div>
                                            <div class="col-12 col-md-6 mb-20">
                                                <label for="longitude" class="mnt-7">Long:</label>
                                                <input type="text" class="form-control form-control-style-2"
                                                    id="longitude" placeholder="Enter Longitude" name='longitude'>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mt-3">
                                            <div class="col-12 col-md-6 mb-20">
                                                <button type="button" class="btn btn-primary w-100"
                                                    id="check_location">Check Location</button>
                                            </div>
                                            <div class="col-12 col-md-6 mb-20">
                                                <button type="button" class="btn btn-primary w-100"
                                                    id="get_location">Get
                                                    Current Location</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dx-separator"></div>



                                {{-- GET LOCATION --}}
                                <div class="dx-box-content">

                                    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
                                    <link rel="stylesheet"
                                        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css"
                                        type="text/css">

                                    <div id="map" style="height: 400px;"></div>


                                    <input type="hidden" name="latitude" id="hidden_latitude">
                                    <input type="hidden" name="longitude" id="hidden_longitude">

                                </div>

                                <div class="dx-separator"></div>
                                <div class="dx-box-content">
                                    <div class="row justify-content-end mt-3">
                                        <div class="col-auto mb-20">
                                            <button type="submit" class="btn btn-primary" id="send_ticket">Send
                                                Ticket</button>

                                    
                                        </div>
                                    </div>
                                </div>





                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('js')
    <script>
        document.getElementById('send_ticket').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah form dikirim langsung
            const addedFiles = pond.getFiles();
            if (addedFiles.length > 0) {
                const filePaths = addedFiles.map(file => ({
                    serverId: file.serverId,
                    name: file.file.name
                }));
                console.log('File paths:', filePaths);
                // Append filePaths to a hidden input field
                const filePathsInput = document.createElement('input');
                filePathsInput.type = 'hidden';
                filePathsInput.name = 'filepond';
                filePathsInput.value = JSON.stringify(filePaths);
                event.target.closest('form').appendChild(filePathsInput);
            } else {
                console.log('No files added.');
            }
            // Kirim form setelah mengambil file
            event.target.closest('form').submit();
        });
    </script>
    <script>
        document.getElementById('send_ticket').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah form dikirim langsung
            const addedFiles = pond.getFiles();
            if (addedFiles.length > 0) {
                const filePaths = addedFiles.map(file => ({
                    serverId: file.serverId,
                    name: file.file.name
                }));
                console.log('File paths:', filePaths);
                // Append filePaths to a hidden input field
                const filePathsInput = document.createElement('input');
                filePathsInput.type = 'hidden';
                filePathsInput.name = 'filepond';
                filePathsInput.value = JSON.stringify(filePaths);
                event.target.closest('form').appendChild(filePathsInput);
            } else {
                console.log('No files added.');
            }
            // Kirim form setelah mengambil file
            event.target.closest('form').submit();
        });
    </script>
    <script id="search-js" defer src="https://api.mapbox.com/search-js/v1.0.0-beta.21/web.js"></script>

    <script>
        ACCESS_TOKEN = "pk.eyJ1IjoiYmFtYmFuZzI4MDIiLCJhIjoiY2x4a2ViM3R0MDB0bDJqcXU0OWxwN3I3biJ9.Ihq2fCxZXYpw-sveeATkvw";
        mapboxgl.accessToken = ACCESS_TOKEN;
        const map = new mapboxgl.Map({
            container: 'map',
            // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [106.8456, -6.2088],
            zoom: 8
        });

        // Add the control to the map.
        const geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
        });

        map.addControl(geocoder);


        geocoder.on('result', function(e) {

            if (marker) {
                marker.remove();
            }
            const coords = e.result.geometry.coordinates;
            document.getElementById('latitude').value = coords[1];
            document.getElementById('longitude').value = coords[0];
            document.getElementById('hidden_latitude').value = coords[1];
            document.getElementById('hidden_longitude').value = coords[0];
        });

        var marker;

        document.getElementById('get_location').addEventListener('click', function() {
            const clearButton = document.querySelector('.mapboxgl-ctrl-geocoder--button[aria-label="Clear"]');
            if (clearButton) {
                clearButton.click();
            }


            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;
                    document.getElementById('hidden_latitude').value = latitude;
                    document.getElementById('hidden_longitude').value = longitude;
                    map.flyTo({
                        center: [longitude, latitude],
                        zoom: 14,
                        essential: true // this animation is considered essential with respect to prefers-reduced-motion
                    });

                    // Add a marker to the map at the user's current location, but remove any existing marker first
                    if (marker) {
                        marker.remove();
                    }
                    marker = new mapboxgl.Marker()
                        .setLngLat([longitude, latitude])
                        .addTo(map);


                }, function(error) {
                    console.error('Error occurred while fetching location: ', error);
                });
            } else {
                console.error('Geolocation is not supported by this browser.');
            }
        });

        document.getElementById('check_location').addEventListener('click', function() {
            const latitude = parseFloat(document.getElementById('latitude').value);
            const longitude = parseFloat(document.getElementById('longitude').value);

            if (!isNaN(latitude) && !isNaN(longitude)) {
                document.getElementById('hidden_latitude').value = latitude;
                document.getElementById('hidden_longitude').value = longitude;
                map.flyTo({
                    center: [longitude, latitude],
                    zoom: 14,
                    essential: true // this animation is considered essential with respect to prefers-reduced-motion
                });

                // Add a marker to the map at the specified location, but remove any existing marker first
                if (marker) {
                    marker.remove();
                }
                marker = new mapboxgl.Marker()
                    .setLngLat([longitude, latitude])
                    .addTo(map);
            } else {
                console.error('Invalid latitude or longitude values.');
            }
        });
    </script>


    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        // Get a reference to the file input element
        const inputElement = document.getElementById('fileInput');
        const pond = FilePond.create(inputElement);
        // Add file button click event
        // Ensure FilePond is properly initialized and configured
        pond.setOptions({
            server: {
                process: {
                    url: "{{ route('uploads.process') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },




            }
        });
        pond.on('addfile', function(file) {
            // Upload the file to your server
            const addedFiles = pond.getFiles();
            addedFiles.forEach(file => {
                console.log('File path: ', file.serverId);
            });


        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        const quill = new Quill('.dx-editors', {
            theme: 'snow',
            modules: {
                toolbar: true
            },
            placeholder: 'Write a message...',
            bounds: '.dx-editors',
            scrollingContainer: '.dx-editors',
        });
        quill.on('text-change', function() {
            const editorHeight = quill.root.scrollHeight;
            const maxHeight = 250;
            const minHeight = 150;
            if (editorHeight > maxHeight) {
                quill.root.style.height = `${maxHeight}px`;
            } else if (editorHeight < minHeight) {
                quill.root.style.height = `${minHeight}px`;
            } else {
                quill.root.style.height = `${editorHeight}px`;
            }
            document.getElementById('message').value = quill.root.innerHTML;
        });
    </script>
@endpush
