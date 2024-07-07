@extends('layouts.user')

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
                            enctype="multipart/form-data">
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
                                        <input type="file" class="filepond" name="filepond[]" multiple
                                            data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">

                                        <script>
                                            import * as FilePond from 'filepond';
                                            import 'filepond/dist/filepond.min.css';
                                            import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
                                            import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
                                            import FilePondPluginFileRemove from 'filepond-plugin-file-remove';

                                            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType, FilePondPluginFileRemove);
                                            const inputElement = document.querySelector('input[type="file"].filepond');

                                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                            FilePond.create(inputElement).setOptions({
                                                server: {
                                                    process: './uploads/process',
                                                    revert: './uploads/revert',
                                                    headers: {
                                                        'X-CSRF-TOKEN': csrfToken,
                                                    }
                                                },
                                                allowImagePreview: true,
                                                imagePreviewMaxHeight: 100,
                                                allowRemove: true
                                            });
                                        </script>
                                        <input type="hidden" name="message" id="message">
                                        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
                                        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
                                        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
                                        <script src="https://unpkg.com/filepond-plugin-file-remove/dist/filepond-plugin-file-remove.min.js"></script>
                                    </div>
                                    <div class="dx-form-group">
                                        <label class="mnt-7">Message</label>
                                        <div class="dx-editors" data-editor-height="150" data-editor-maxheight="250"
                                            style="min-height: 150px; max-height: 250px;"></div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var quill = new Quill('.dx-editors', {
                                                    theme: 'snow'
                                                });

                                                quill.on('text-change', function() {
                                                    var message = document.querySelector('input[name=message]');
                                                    message.value = quill.root.innerHTML;
                                                });
                                            });
                                        </script>
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
                                                <button type="button" class="btn btn-primary w-100" id="get_location">Get
                                                    Current Location</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dx-separator"></div>



                                {{-- GET LOCATION --}}
                                <div class="dx-box-content">
                                    <link href="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.js"></script>
                                    <div id='search-box-container'></div>
                                    <div id="map" style="height: 400px;"></div>
                                    <script>
                                        const script = document.getElementById('search-js');
                                        // wait for the Mapbox Search JS script to load before using it
                                        script.onload = function () {
                                          const mapboxAccessToken = 'YOUR_MAPBOX_ACCESS_TOKEN';
                                      
                                          // instantiate a map
                                          const map = new mapboxgl.Map({
                                              accessToken: mapboxAccessToken,
                                              container: 'map',
                                              center: [-74.5, 40],
                                              zoom: 9
                                          });
                                      
                                          // instantiate a search box instance
                                          const searchBox = new mapboxsearch.MapboxSearchBox()
                                      
                                          // set the mapbox access token, search box API options
                                          searchBox.accessToken = mapboxAccessToken
                                          searchBox.options = {
                                            language: 'es'
                                          }
                                      
                                          // set the mapboxgl library to use for markers and enable the marker functionality
                                          searchBox.mapboxgl = mapboxgl
                                          searchBox.marker = true
                                      
                                          // bind the search box instance to the map instance
                                          searchBox.bindMap(map)
                                      
                                          // add the search box instance to the DOM
                                          document.getElementById('search-box-container').appendChild(searchBox)
                                        }
                                      </script>
                                    <input type="hidden" name="latitude" id="hidden_latitude">
                                    <input type="hidden" name="longitude" id="hidden_longitude">
                                </div>
                               

                                <link href='https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css' rel='stylesheet' />
                                <script id="search-js" defer src="https://api.mapbox.com/search-js/v1.0.0-beta.21/web.js"></script>

                                <script src='https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js'></script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        mapboxgl.accessToken =
                                            "pk.eyJ1IjoiYmFtYmFuZzI4MDIiLCJhIjoiY2x4a2ViM3R0MDB0bDJqcXU0OWxwN3I3biJ9.Ihq2fCxZXYpw-sveeATkvw";
                                        var map = new mapboxgl.Map({
                                            container: 'map',
                                            style: 'mapbox://styles/mapbox/streets-v11',
                                            center: [0, 0],
                                            zoom: 2
                                        });

                                        var marker;

                                        document.getElementById('get_location').addEventListener('click', function() {
                                            if (navigator.geolocation) {
                                                navigator.geolocation.getCurrentPosition(function(position) {
                                                    var lat = position.coords.latitude;
                                                    var lng = position.coords.longitude;
                                                    var coordinates = [lng, lat];

                                                    if (!marker) {
                                                        marker = new mapboxgl.Marker()
                                                            .setLngLat(coordinates)
                                                            .addTo(map);
                                                    } else {
                                                        marker.setLngLat(coordinates);
                                                    }

                                                    map.setCenter(coordinates);
                                                    map.setZoom(13);

                                                    // Set the latitude and longitude values in the hidden inputs
                                                    document.getElementById('latitude').value = lat;
                                                    document.getElementById('longitude').value = lng;
                                                    document.getElementById('hidden_latitude').value = lat;
                                                    document.getElementById('hidden_longitude').value = lng;
                                                }, function(error) {
                                                    alert("Error getting location: " + error.message);
                                                }, {
                                                    enableHighAccuracy: true,
                                                    timeout: 5000,
                                                    maximumAge: 0
                                                });
                                            } else {
                                                alert("Geolocation is not supported by this browser.");
                                            }
                                        });

                                        document.getElementById('check_location').addEventListener('click', function() {
                                            var lat = document.getElementById('latitude').value;
                                            var lng = document.getElementById('longitude').value;
                                            var coordinates = [lng, lat];

                                            if (!marker) {
                                                marker = new mapboxgl.Marker()
                                                    .setLngLat(coordinates)
                                                    .addTo(map);
                                            } else {
                                                marker.setLngLat(coordinates);
                                            }

                                            map.setCenter(coordinates);
                                            map.setZoom(13);

                                            // Set the latitude and longitude values in the hidden inputs
                                            document.getElementById('hidden_latitude').value = lat;
                                            document.getElementById('hidden_longitude').value = lng;
                                        });
                                    });
                                </script>
                            </div>

                            <div class="pt-0">


                                <div class="dz-message">

                                </div>

                                <div class="row justify-content-between vertical-gap dx-dropzone-attachment">
                                    <div class="col-auto dx-dropzone-attachment-add">

                                    </div>
                                    <div class="col-auto dx-dropzone-attachment-btn ">
                                        <button class="dx-btn dx-btn-lg" type="submit" name="submit">Submit</button>
                                    </div>
                                </div>
                                <!-- END: Dropzone -->

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
