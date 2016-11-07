<div class="form-group">
    {!! Form::label('nombre',session('parametros')[118]['VALOR']) !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'ingresa un nombre']) !!}
</div>
<div class="form-group">
    {!! Form::label('razon_social', session('parametros')[119]['VALOR']) !!}
    {!! Form::text('razon_social', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('latitud', session('parametros')[120]['VALOR']) !!}
    {!! Form::text('latitud', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('longitud', session('parametros')[121]['VALOR']) !!}
    {!! Form::text('longitud', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <button id="boton-mapa" class="btn btn-default">ver mapa</button>
</div>
<style>
    #map-canvas{
        width: 350px;
        height: 250px;
    }
</style>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyB6K1CFUQ1RwVJ-nyXxd6W0rfiIBe12Q&libraries=places"
        type="text/javascript"></script>
<div class="form-group" id="mapa">
    <label for="">Map</label>
    <input type="text" id="searchmap">
    <div id="map-canvas"></div>
</div>


<script>
    $(document).ready(function () {
        $('#mapa').fadeOut();
        $('#boton-mapa').click(function (e) {
            e.preventDefault();
            $(this).text(function(i, text){
                return text === "ocultar mapa" ? "ver mapa" : "ocultar mapa";
            })
            var mapa=$('#mapa');
            mapa.fadeToggle();
        });

    var map = new google.maps.Map(document.getElementById('map-canvas'),{
        center:{
            @if(!isset($client))
                lat: -17.76570949499028,
                lng: -63.15814523652341
            @else
                lat: {{ $client->latitud }}0,
                lng: {{ $client->longitud }}0
            @endif
        },
        zoom:15
    });
    var marker = new google.maps.Marker({
        position: {
            @if(!isset($client))
            lat: -17.76570949499028,
            lng: -63.15814523652341
            @else
            lat: {{ $client->latitud }}0,
            lng: {{ $client->longitud }}0
            @endif
        },
        map: map,
        draggable: true
    });
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
    });
    var marker;
    function placeMarker(location) {
        if(marker){ //on vérifie si le marqueur existe
            marker.setPosition(location); //on change sa position
        }else{
            marker = new google.maps.Marker({ //on créé le marqueur
                position: location,
                map: map
            });
        }
        document.getElementById('lat').value=location.lat();
        document.getElementById('lng').value=location.lng();
        getAddress(location);
    }
    function getAddress(latLng) {
        geocoder.geocode( {'latLng': latLng},
                function(results, status) {
                    if(status == google.maps.GeocoderStatus.OK) {
                        if(results[0]) {
                            document.getElementById("address").value = results[0].formatted_address;
                        }
                        else {
                            document.getElementById("address").value = "No results";
                        }
                    }
                    else {
                        document.getElementById("address").value = status;
                    }
                });
    }
    var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
    google.maps.event.addListener(searchBox,'places_changed',function(){
        var places = searchBox.getPlaces();
        var bounds = new google.maps.LatLngBounds();
        var i, place;
        for(i=0; place=places[i];i++){
            bounds.extend(place.geometry.location);
            marker.setPosition(place.geometry.location); //set marker position new...
        }
        map.fitBounds(bounds);
        map.setZoom(15);
    });
    google.maps.event.addListener(marker,'position_changed',function(){
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();
        $('#latitud').val(lat);
        $('#longitud').val(lng);
    });
    });
</script>

