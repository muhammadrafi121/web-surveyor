@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="map" class="col-md-12" style="height: 550px;"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    <script>
        // var map = L.map('map').setView([-3.24487, 104.67105], 15);
        var map = L.map('map', {
            doubleClickZoom: false
        }).locate({
            setView: true,
            maxZoom: 15
        });
        var points = [];
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 25,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        function onMapClick(e) {
            points.push(e.latlng);
            L.marker(e.latlng).addTo(map);
            if (points.length > 1) {
                L.polygon([
                    points[points.length - 2],
                    points[points.length - 1],
                ]).addTo(map);
            }
        }

        map.on('click', onMapClick);
    </script>
@endsection
