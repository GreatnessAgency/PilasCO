 // The following example creates complex markers to indicate beaches near
// Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
// to the base of the flagpole.
var map;
var miMarker;
var directionsService;
var directionsDisplay;
var enableLocator = false;
var indice;
var markerS;

function initMap() {

    console.log("Mapa Iniciado...");

    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer({
        polylineOptions: {
          strokeColor: "#277451",
          strokeWeight: 8
        },
        suppressMarkers: true
    });

    map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16
            , scrollwheel: true
            ,streetViewControl: false
            ,zoomControl: false
        , navigationControl: true
        , mapTypeControl: false,
        styles: [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "-100"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 65
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": "50"
                    },
                    {
                        "visibility": "simplified"
                    },
                    {
                        "hue": "#ff0000"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "-100"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": "30"
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": "40"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#ffff00"
                    },
                    {
                        "lightness": -25
                    },
                    {
                        "saturation": -97
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels",
                "stylers": [
                    {
                        "lightness": -25
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            }
        ],
        center: {lat:4.657244700 , lng:-74.057733000 }

    });

    setMarkers(map);

    toogleLocator();

    map.addListener('projection_changed', function() {
        if(markerS){
            var point = fromLatLngToPoint(markerS.getPosition(), map);
            // console.log(point);
            $('#marker-tooltip').css({
                'left': point.x,
                'top': point.y
            }).show();
        }
        
    });

    map.addListener('drag', function() {
        if(markerS){
            var point = fromLatLngToPoint(markerS.getPosition(), map);
            // console.log(point);
            $('#marker-tooltip').css({
                'left': point.x,
                'top': point.y
            }).show();
        }
    });

    map.addListener('zoom_changed', function() {
        if(markerS){
            var point = fromLatLngToPoint(markerS.getPosition(), map);
            // console.log(point);
            $('#marker-tooltip').css({
                'left': point.x,
                'top': point.y
            }).show();
        }
    });
}

    // Data for the markers consisting of a name, a LatLng and a zIndex for the
    // order in which these markers should display on top of each other.
    

function setMarkers(map) {

    // Adds markers to the map.

    // Marker sizes are expressed as a Size of X,Y where the origin of the image
    // (0,0) is located in the top left of the image.

    // Origins, anchor positions and coordinates of the marker increase in the X
    // direction to the right and in the Y direction down.
    var image = {
        url:'assets/images/Poinst-maps.png',
        size: new google.maps.Size(50, 58),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(0, 50)
    };

    for (var i = 0; i < beaches.length; i++) {
        var beach = beaches[i];
        var marker = new google.maps.Marker({
            position: {lat: beach.latitud*1, lng: beach.longitud*1},
            map: map,
            icon: image,
            title: beach.nombre ,
            address: beach.direccion,
            zIndex: 1,
            numero: i
        });

        google.maps.event.addListener(marker, 'mouseover', function () {
            $('#marker-tooltip').hide();
            var point = fromLatLngToPoint(this.getPosition(), map);
            var pos = this.getPosition();
            var htmlString =  "<b>"+this.title+"</b><br>"+"<p>"+this.address+"</p>";
            ($('#marker-tooltip').find("#informa")).html(htmlString);
            $(".como-llegar").unbind( "click" );
            $(".como-llegar").click(function(){
                generateRoute(miMarker.getPosition(), pos);
            });
            $(".como-ver").unbind( "click" );
            $(".como-ver").click(function(){
                $('#marker-tooltip').hide();
                var panorama = new google.maps.StreetViewPanorama(
                    document.getElementById('map'), {
                        position: pos,
                        pov: {
                            heading: 34,
                            pitch: 10
                        },
                        enableCloseButton: true
                    }
                );
            });
            $('#marker-tooltip').css({
                'left': point.x,
                'top': point.y
            }).show();

            markerS = this;
        });
    }


}

function fromLatLngToPoint(latLng, map) {
    var topRight = map.getProjection().fromLatLngToPoint(map.getBounds().getNorthEast());
    var bottomLeft = map.getProjection().fromLatLngToPoint(map.getBounds().getSouthWest());
    var scale = Math.pow(2, map.getZoom());
    var worldPoint = map.getProjection().fromLatLngToPoint(latLng);
    return new google.maps.Point((worldPoint.x - bottomLeft.x) * scale, (worldPoint.y - topRight.y) * scale);
}

function defer() {
    if (window.jQuery) {
        console.log('Cargado');
        $('#select_ciudades').change(function(event) {
            var pos = JSON.parse($(event.target).val());
            map.panTo(new google.maps.LatLng(pos.lat, pos.lng));
        });
    } else {
        setTimeout(function() { defer() }, 50);
    }
}

defer();

function toogleLocator(){
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
  
            //infoWindow.setPosition(pos);
            //infoWindow.setContent('Location found.');
            map.setCenter(pos);
            placeMarker(pos);
        }, function() {
            //handleLocationError(true, infoWindow, map.getCenter());
            map.setCenter({lat: 4.670905, lng: -74.062244});
            placeMarker({lat: 4.670905, lng: -74.062244});
        });
    } else {
        // Browser doesn't support Geolocation
        //handleLocationError(false, infoWindow, map.getCenter());
        map.setCenter({lat: 4.670905, lng: -74.062244});
        placeMarker({lat: 4.670905, lng: -74.062244});
    }
}

function placeMarker(location) {
    if (miMarker != undefined)
    miMarker.setMap (null);
    miMarker = new google.maps.Marker({
        position: location,
        map: map,
    });
}

function traceNearestRoute(location) {
    n = find_closest_marker( location );
    //beaches[n]
    if(n != -1){
        var end = new google.maps.LatLng(beaches[n][1],  beaches[n][2]);
        generateRoute(location, end);
    }else{
        console.log('No hay puntos');
    }
}

function rad(x) {return x*Math.PI/180;}
function find_closest_marker( location ) {
    var lat = location.lat();
    var lng = location.lng();
    var R = 6371; // radius of earth in km
    var distances = [];
    var closest = -1;
    for( i=0;i<beaches.length; i++ ) {
        var mlat = beaches[i][1];
        var mlng = beaches[i][2];
        var dLat  = rad(mlat - lat);
        var dLong = rad(mlng - lng);
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        distances[i] = d;
        if ( closest == -1 || d < distances[closest] ) {
            closest = i;
        }
    }

    return closest;
}

var generateRoute=function(origin,destination) {
    var request = {
       origin:origin,
       destination: destination,
       travelMode: google.maps.DirectionsTravelMode.DRIVING
    };

    directionsDisplay.setMap(map);
    directionsService.route(request, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}
// select del las ciudades en el mapa con sus cordenadas 
fetch('assets/js/Puntos-ciudades.json')
  .then(response => response.json())
  .then(data => {
    const select = document.getElementById("select_ciudades");

    data.sort((a, b) => a.city.localeCompare(b.city)); // Ordenar el array por nombre de ciudad

    for (let i = 0; i < data.length; i++) {
      const option = document.createElement("option");
      option.value = '{"lat":'+data[i].lat +',' + '"lng":'+data[i].lng+'}';
      option.text = data[i].city+ '-('+data[i].admin_name+')';
      select.appendChild(option);
    }
  });