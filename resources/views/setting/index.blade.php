@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">Pengaturan Web / Apps</div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="maps-tab" data-toggle="tab" href="#maps" role="tab"
                    aria-controls="maps" aria-selected="true">Maps</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="maps" role="tabpanel" aria-labelledby="maps-tab">
                <form action="{{ route('setting.update','maps')}}" method="post">
                    @csrf
                    @method('put')
                    <div id="leafletMap-registration"></div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Latitude :</label>
                                <input type="text" class="form-control" name="latitude" id="latitude">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let latitude  = "{{ $maps->latitude}}";
        let longitude = "{{ $maps->longitude}}";
        document.getElementById("latitude").value = latitude;
        document.getElementById("longitude").value = longitude;
        let popup = L.popup()
            .setLatLng([latitude,longitude])
            .setContent("Kordinat : " + latitude +" - "+  longitude )
            .openOn(leafletMap);

        if (theMarker != undefined) {
            leafletMap.removeLayer(theMarker);
        };
        theMarker = L.marker([latitude,longitude]).addTo(leafletMap);
    });
    // you want to get it of the window global
    const providerOSM = new GeoSearch.OpenStreetMapProvider();

    //leaflet map
    var leafletMap = L.map('leafletMap-registration', {
    fullscreenControl: true,
    // OR
    fullscreenControl: {
        pseudoFullscreen: false // if true, fullscreen to page width and height
    },
    minZoom: 2
    }).setView([0,0], 2);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(leafletMap);

    let theMarker = {};

    leafletMap.on('click',function(e) {
        let latitude  = e.latlng.lat.toString().substring(0,15);
        let longitude = e.latlng.lng.toString().substring(0,15);
        document.getElementById("latitude").value = latitude;
        document.getElementById("longitude").value = longitude;
        let popup = L.popup()
            .setLatLng([latitude,longitude])
            .setContent("Kordinat : " + latitude +" - "+  longitude )
            .openOn(leafletMap);

        if (theMarker != undefined) {
            leafletMap.removeLayer(theMarker);
        };
        theMarker = L.marker([latitude,longitude]).addTo(leafletMap);
    });

    const search = new GeoSearch.GeoSearchControl({
        provider: providerOSM,
        style: 'bar',
        searchLabel: 'Sinjai',
    });

    leafletMap.addControl(search);
</script>
@endsection
