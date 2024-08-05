<div class="popup-map"> 
	<div class="finder">
	<b>Buscar:</b>
	<input id="iptDir" type="text" class="input" placeholder="Ej: Calle 26 A No 13 - 97 Bogotá Colombia" style="width: 79%;" />
	<a href="javascript:void(0);" onClick="codeAddress($('#iptDir').val());">
		<img src="<?=$template?>images/search.png" alt="Buscar" title="Buscar" />
	</a>
	</div>
	<div id="mapCanvas"></div>
	<p class="c_gray finder" style="font-size:10px;"><b>Instrucciones:</b></p>
	<p class="c_gray finder" style="font-size:10px;">1. Utilice el campo de formulario para escribir la direccion o referencia a el punto de ubicación deseado y posteriormente haga click en el icono (lupa). </p>
	<p class="c_gray finder" style="font-size:10px;">2. Haga click sobre el mapa en la zona deseada, también puede arrastrar y soltar el icono (rojo) para ubicar exactamente el punto.</p>
	<p class="c_gray finder" style="font-size:10px;">3. Una vez encuentre la ubicación deseada, haga click en <b>"Establecer punto"</b>.</p>
	<div class="finder" style="font-size:10px; display:none;">
		<div id="markerStatus"></div>
		<div id="info"></div>
		<div id="address"></div>
	</div>
</div>
<script type="text/javascript">

var geocoder = (typeof google != 'undefined')? new google.maps.Geocoder() : false;
var map = '';
var latLang = '';
var marker = '';

$(window).load(function(){
    if(geocoder){
	   initialize(); 
    }
	
	$("#iptDir").keypress(function(event) {
	  if ( event.which == 13 ) {
		 codeAddress($('#iptDir').val());
	   }
   });
});

function openBox(ipt){
	$('.popup-map').dialog({
		modal: true
		,width: 'auto'
		,height: 'auto'
		,resizable: false
		,open: function(){
			$(this).attr('style', "");
			if(ipt.val() != ""){
				place = ipt.val().split(',');
				place = new google.maps.LatLng(place[0], place[1]);
				placeMarker(place);
				placeMap(place)
			}
		}
		,close: function(event, ui) {
			$(this).find('input, select').val('');
			$(this).dialog('destroy');			
		}
		,buttons:{
			'Establecer punto': function(){
				ipt.val($(this).find('#info').text());
				$(this).dialog('close');
			}
			,'Cancelar': function(){
				$(this).dialog('close');
			}
		}
	});
}

// Onload handler to fire off the app.
//google.maps.event.addDomListener(window, 'load', initialize);


function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function codeAddress(address){
	geocoder.geocode({ 'address': address}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		latLang = results[0].geometry.location;
		map.setCenter(latLang);
		placeMarker(latLang);
		updateMarkerPosition(latLang);
		geocodePosition(latLang);
	  } else {
		updateMarkerAddress('Cannot determine location at this address: ' + status);
	  }
	});
}
	  
function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
}

function placeMarker(location){
	marker.setPosition(location);
}

function placeMap(location){
	map.setCenter(location);
}

function initialize() {
  latLng = new google.maps.LatLng(4.5980, -74.0758);
  map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 8,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
  marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map,
    draggable: true
  });
  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Moviendo Marker...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Final Moviemiento del Marker');
    geocodePosition(marker.getPosition());
  });
  
  google.maps.event.addListener(map, 'click', function(e) {
    updateMarkerStatus('Click sobre Mapa');
	placeMarker(e.latLng);
	updateMarkerPosition(e.latLng);
	geocodePosition(e.latLng);
  });
}
</script>