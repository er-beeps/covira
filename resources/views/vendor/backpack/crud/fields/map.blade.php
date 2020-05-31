<!-- html5 url input -->

      
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin="" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
      <style>
      #map {
            position: relative;
            border: 1px solid gray;
            border-radius: 25px;
            left: 22%;
            height: 450px;
            width: 700px;
            margin-bottom:30px;
      }
</style>

<div @include('crud::inc.field_wrapper_attributes')>
      <div id='map'></div>
      <script>
            var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                  '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                  'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
             mbUrl = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';


            var satellite = L.tileLayer(mbUrl, {
                        id: 'mapbox.streets-satellite',
                        attribution: mbAttr
                  }),
                  streets = L.tileLayer(mbUrl, {
                        id: 'mapbox.streets',
                        attribution: mbAttr
                  });
                                      
            
            var map = L.map('map', {
                  center: [28.34, 84.25],
                  zoom: 7,
                  layers: [satellite],
            });

            var baseLayers = {
                  "Satellite": satellite,
                  "Streets": streets,
            };

            L.control.layers(baseLayers).addTo(map);

            var marker = L.marker( [0, 0]).addTo(map);

                  //  function updateMarker(lat, lng) {
                  //       marker
                  //       .setLatLng([lat, lng])
                  //       .bindPopup("Latitude:  " + marker.getLatLng().lat.toString().substring(0, 8)
                  //       + " " + "Latitude:  "+ marker.getLatLng().lng.toString().substring(0, 8) )
                  //       .openPopup()
                  //       .setView([lat,lng],7);
                  //       return false;
                  // };

            
                  map.on('click', function(e) {
                  let latitude = e.latlng.lat.toString().substring(0, 10);
                  let longitude = e.latlng.lng.toString().substring(0, 10);
                  $('#gps_lat').val(latitude);
                  $('#gps_long').val(longitude);

                  updateMarker(latitude, longitude);
                  changeLatDecimalToDegree();
                  changeLongDecimalToDegree();
                //   codeLatLng(latitude, longitude);
                  });

                  function updateMarker(lat, lng) {
                  marker
                  .setLatLng([lat, lng])
                  .bindPopup("Your location :  " + marker.getLatLng().toString())
                  .openPopup();
                  map.setView([lat,lng],9);
                  $('#gps_lat').val(lat);
                  $('#gps_long').val(lng);
                  changeLatDecimalToDegree();
                  changeLongDecimalToDegree();
                  return false;
                  };


                  function updateMarkerByInputs() {
                  var latitude = $('#gps_lat').val();
                  var longitude = $('#gps_long').val();
                  return updateMarker(latitude,longitude);

                        // var latitude = $('#gps_lat').val();
                        // var longitude = $('#gps_long').val();
                        // if (latitude == 0 && longitude ==0){
                        //       return updateMarker(28.34,84.25);
                        // }
                        // else{
                        //       return updateMarker(latitude,longitude);      
                              
                        // }
                        
                  }

                  
            // 
            // get your current location 

            function getLocation() {
                  if (navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(showPosition);
                  } else { 
                        alert("Your Browser does not support Geo-location.");
                  }
            }

            function showPosition(position) {
                  var latitude = position.coords.latitude;
                  var longitude = position.coords.longitude;
                  updateMarker(latitude, longitude);
            }
         
      </script>

<script type="text/javascript" src="{{asset('js/lattitude.longitude.converter.js')}}"></script>  

     
</div>