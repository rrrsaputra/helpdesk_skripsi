@extends('layouts.agent')
@section('header')
    <x-agent.header title="Map" />
@endsection

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <style>
        #map {
            height: 350px
        }
    </style>

    <body>

        <div id="map"></div>

    </body>


<script>
    const map = L.map('map'); 
    // Initializes map
    
    map.setView([51.505, -0.09], 13); 
    // Sets initial coordinates and zoom level
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map); 
    // Sets map data source and associates with map
    
    let marker, circle, zoomed;
    
    navigator.geolocation.watchPosition(success, error);
    
    function success(pos) {
    
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;
        const accuracy = pos.coords.accuracy;
    
        if (marker) {
            map.removeLayer(marker);
            map.removeLayer(circle);
        }
        // Removes any existing marker and circule (new ones about to be set)
    
        marker = L.marker([lat, lng]).addTo(map);
        circle = L.circle([lat, lng], { radius: accuracy }).addTo(map);
        // Adds marker to the map and a circle for accuracy
    
        if (!zoomed) {
            zoomed = map.fitBounds(circle.getBounds()); 
        }
        // Set zoom to boundaries of accuracy circle
    
        map.setView([lat, lng]);
        // Set map focus to current user position
    
    }
    
    function error(err) {
    
        if (err.code === 1) {
            alert("Please allow geolocation access");
        } else {
            alert("Cannot get current location");
        }
    
    }
</script>
@endsection
