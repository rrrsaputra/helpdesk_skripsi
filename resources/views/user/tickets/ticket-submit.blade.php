@extends('layouts.user')

@section('content')
    <div class="dx-main">
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

        <div class="dx-separator"></div>
        <div class="dx-box-5 pb-100 bg-grey-6">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <form action="{{ route('user.ticket.store') }}" method="POST" class="dx-form">
                            @csrf
                            <div class="dx-box dx-box-decorated">
                                <div class="dx-box-content">
                                    <h2 class="h6 mb-6">Submit a Ticket</h2>
                                    <!-- START: Breadcrumbs -->
                                    <ul class="dx-breadcrumbs text-left dx-breadcrumbs-dark mnb-6 fs-14">
                                        <li><a href="help-center.html">Support Home</a></li>
                                        <li><a href="ticket.html">Ticket System</a></li>
                                        <li>Submit Ticket</li>
                                    </ul>
                                    <!-- END: Breadcrumbs -->
                                </div>
                                <div class="dx-separator"></div>


                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="category" class="mnt-7">Category</label>
                                        <input type="text" class="form-control form-control-style-2" id="category"
                                            placeholder="Enter Category" name='category'>
                                    </div>

                                </div>
                                <div class="dx-separator"></div>

                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="subject" class="mnt-7">Subject</label>
                                        <input type="text" class="form-control form-control-style-2" id="subject"
                                            placeholder="Enter Subject" name='title'>
                                    </div>
                                    <div class="dx-form-group">
                                        <label class="mnt-7">Description</label>
                                        <div class="dx-editors" data-editor-height="150" data-editor-maxheight="250"
                                            style="min-height: 150px; max-height: 250px;">
                                        </div>
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
                                        <input type="hidden" name="message" id="message">
                                    </div>
                                </div>

                                <div class="dx-separator"></div>

                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <label for="latitude" class="mnt-7">Lat:</label>
                                                <input type="text" class="form-control form-control-style-2"
                                                    id="latitude" placeholder="Enter Latitude" name='latitude'>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="longitude" class="mnt-7">Long:</label>
                                                <input type="text" class="form-control form-control-style-2"
                                                    id="longitude" placeholder="Enter Longitude" name='longitude'>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mt-3">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary w-100"
                                                    id="check_location">Check Location</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary w-100" id="get_location">Get
                                                    Current Location</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dx-separator"></div>



                                {{-- GET LOCATION --}}
                                <div class="dx-box-content">
                                    <div id="map" style="height: 400px;"></div>
                                    <input type="hidden" name="latitude" id="hidden_latitude">
                                    <input type="hidden" name="longitude" id="hidden_longitude">
                                </div>
                                <link href='https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css' rel='stylesheet' />
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
