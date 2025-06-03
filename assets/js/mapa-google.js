// ======================================================================================================================
// === INICIO DEL CÓDIGO FINAL Y COMPLETO PARA assets/js/mapa-google.js ===
// ======================================================================================================================

// Declaración de variables globales utilizadas a lo largo del script para el mapa y marcadores.
var map;
var miMarker; // Marcador específico para la ubicación del usuario.
var directionsService; // Servicio para calcular rutas.
var directionsDisplay; // Capa para mostrar rutas en el mapa.
var enableLocator = false; // Bandera para la funcionalidad de localización.
var indice;
var markerS; // Referencia al marcador actualmente con el tooltip visible.

// Definición de los objetos de icono para marcadores públicos y privados.
// Estas variables acceden a las rutas de los SVG de los iconos.
var publicIcon = {
    url: '<?php echo base_url("assets/images/puntos/puntos-puntospublicos.svg"); ?>',
    size: new google.maps.Size(32, 32), // Tamaño del icono en píxeles.
    origin: new google.maps.Point(0, 0), // Punto de origen para el recorte de sprites (si aplica).
    anchor: new google.maps.Point(16, 32) // Punto de anclaje del icono relativo a su posición.
};
var privateIcon = {
    url: '<?php echo base_url("assets/images/puntos/puntos-puntosprivados.svg"); ?>',
    size: new google.maps.Size(32, 32),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(16, 32)
};

// La variable 'beaches' que contiene los datos de los puntos de recolección
// es inyectada en el HTML de la vista por PHP. Por ejemplo:
// <script> var beaches = <?php echo $puntos; ?>; </script>


// Función principal para inicializar el mapa de Google al cargarse la API.
function initMap() {
    console.log("Mapa Iniciado..."); // Mensaje de consola al inicio.

    // Inicialización de los servicios de direcciones.
    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer({
        polylineOptions: { // Estilos para la línea de la ruta.
            strokeColor: "#277451",
            strokeWeight: 8
        },
        suppressMarkers: true // Evita que el servicio de direcciones añada sus propios marcadores.
    });

    // Creación y configuración del objeto mapa.
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16, // Nivel de zoom inicial.
        scrollwheel: true, // Habilita el zoom con la rueda del ratón.
        streetViewControl: false, // Deshabilita el control de StreetView.
        zoomControl: false, // Deshabilita los controles de zoom.
        navigationControl: true, // Habilita los controles de navegación.
        mapTypeControl: false, // Deshabilita el control de tipo de mapa (mapa/satélite).
        styles: [ // Estilos personalizados para la apariencia del mapa.
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    { "saturation": "-100" },
                    { "visibility": "on" }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "all",
                "stylers": [
                    { "visibility": "off" }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    { "saturation": -100 },
                    { "lightness": 65 },
                    { "visibility": "off" }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    { "saturation": -100 },
                    { "lightness": "50" },
                    { "visibility": "simplified" },
                    { "hue": "#ff0000" }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    { "saturation": "-100" },
                    { "visibility": "on" }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    { "visibility": "on" }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "all",
                "stylers": [
                    { "lightness": "30" },
                    { "visibility": "simplified" }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "all",
                "stylers": [
                    { "lightness": "40" },
                    { "visibility": "on" }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    { "saturation": -100 },
                    { "visibility": "on" }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    { "hue": "#ffff00" },
                    { "lightness": -25 },
                    { "saturation": -97 },
                    { "visibility": "on" }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels",
                "stylers": [
                    { "lightness": -25 },
                    { "saturation": -100 },
                    { "visibility": "simplified" }
                ]
            }
        ],
        center: {lat:4.657244700 , lng:-74.057733000 } // Coordenadas del centro inicial del mapa.
    });

    setMarkers(map); // Llama a la función para colocar los marcadores de puntos de recolección.
    toogleLocator(); // Llama a la función para intentar geolocalizar al usuario.

    // Listeners para actualizar la posición del tooltip del marcador activo con los eventos del mapa.
    map.addListener('projection_changed', function() {
        if(markerS){
            var point = fromLatLngToPoint(markerS.getPosition(), map);
            $('#marker-tooltip').css({
                'left': point.x,
                'top': point.y
            }).show();
        }
    });

    map.addListener('drag', function() {
        if(markerS){
            var point = fromLatLngToPoint(markerS.getPosition(), map);
            $('#marker-tooltip').css({
                'left': point.x,
                'top': point.y
            }).show();
        }
    });

    map.addListener('zoom_changed', function() {
        if(markerS){
            var point = fromLatLngToPoint(markerS.getPosition(), map);
            $('#marker-tooltip').css({
                'left': point.x,
                'top': point.y
            }).show();
        }
    });
}


// Función principal para colocar los marcadores de puntos de recolección en el mapa.
function setMarkers(map) {
    // 1. Verificación de datos: Asegura que la variable 'beaches' contiene datos válidos.
    if (!beaches || !Array.isArray(beaches) || beaches.length === 0) {
        console.warn("La variable 'beaches' está vacía o no es un array. No se mostrarán marcadores.");
        return; // Sale de la función si no hay datos.
    }

    // 2. Llenado del menú desplegable de ciudades ('select_ciudades').
    const selectCiudades = document.getElementById("select_ciudades");
    if (selectCiudades && selectCiudades.options.length <= 1) { // Evita llenar si ya tiene opciones.
        beaches.sort((a, b) => a.city.localeCompare(b.city)); // Ordena las ciudades alfabéticamente.

        for (let j = 0; j < beaches.length; j++) {
            const option = document.createElement("option");
            // El valor de la opción contiene las coordenadas en formato JSON.
            option.value = '{"lat":' + beaches[j].lat + ',"lng":' + beaches[j].lng + '}';
            // El texto de la opción muestra el nombre de la ciudad y la región administrativa.
            option.text = beaches[j].city + '-(' + beaches[j].admin_name + ')';
            selectCiudades.appendChild(option); // Añade la opción al select.
        }
    }

    // 3. Bucle para iterar sobre cada punto de recolección y crear su marcador.
    for (var i = 0; i < beaches.length; i++) {
        var puntoRecoleccion = beaches[i]; // Alias para mayor claridad en el bucle.

        // 3.1 Lógica para la selección del icono (público o privado).
        let currentMarkerIcon;
        // Convierte el valor de 'tipo_ent' a minúsculas para una comparación robusta.
        const tipoEntMinusculas = puntoRecoleccion.tipo_ent ? puntoRecoleccion.tipo_ent.toLowerCase() : '';

        if (tipoEntMinusculas === 'publica') {
            currentMarkerIcon = publicIcon; // Asigna el icono público.
        } else if (tipoEntMinusculas === 'privada') {
            currentMarkerIcon = privateIcon; // Asigna el icono privado.
        } else {
            // Manejo de valores no reconocidos para 'tipo_ent'.
            console.warn("Tipo de entidad no reconocido para el punto:", puntoRecoleccion.city, "-", puntoRecoleccion.tipo_ent);
            currentMarkerIcon = publicIcon; // Asigna un icono por defecto.
        }

        // 3.2 Creación del objeto 'Marker' de Google Maps.
        var marker = new google.maps.Marker({
            position: { // Coordenadas de latitud y longitud del marcador.
                lat: parseFloat(puntoRecoleccion.lat), // Asegura que la latitud sea un número.
                lng: parseFloat(puntoRecoleccion.lng)  // Asegura que la longitud sea un número.
            },
            map: map, // El mapa donde se mostrará el marcador.
            icon: currentMarkerIcon, // El icono seleccionado dinámicamente.
            title: puntoRecoleccion.city + ' - ' + puntoRecoleccion.admin_name, // Título principal del marcador (visible al pasar el ratón).
            // Propiedades personalizadas adjuntas al marcador para fácil acceso en el evento 'mouseover'.
            address: puntoRecoleccion.direccion || '', // Dirección del punto.
            barrio: puntoRecoleccion.barrio || '',     // Barrio del punto.
            sede: puntoRecoleccion.sede || '',         // Sede del punto.
            zIndex: 1, // Controla el orden de superposición de los marcadores.
            numero: i  // Índice del punto en el array original.
        });

        // 3.3 Event listener para el evento 'mouseover' (muestra el tooltip de información).
        google.maps.event.addListener(marker, 'mouseover', function () {
            $('#marker-tooltip').hide(); // Oculta cualquier tooltip previamente visible.
            var point = fromLatLngToPoint(this.getPosition(), map); // Convierte LatLng a coordenadas de píxeles.
            var pos = this.getPosition(); // Obtiene la posición LatLng del marcador actual.

            // Construcción del contenido HTML para la ventana de información (tooltip).
            var htmlString =  "<b>" + this.title + "</b><br>"; // 'this.title' ya contiene ciudad y admin_name.
            if (this.sede) {
                htmlString += "<p>Sede: " + this.sede + "</p>";
            }
            if (this.address) {
                htmlString += "<p>Dirección: " + this.address + "</p>";
            }
            if (this.barrio) {
                htmlString += "<p>Barrio: " + this.barrio + "</p>";
            }

            ($('#marker-tooltip').find("#informa")).html(htmlString); // Inyecta el HTML en el elemento de información del tooltip.

            // Configuración de los botones de acción del tooltip.
            $(".como-llegar").unbind( "click" ); // Desvincula eventos click anteriores para evitar duplicados.
            $(".como-llegar").click(function(){
                generateRoute(miMarker.getPosition(), pos); // Genera una ruta desde la ubicación del usuario al punto.
            });
            $(".como-ver").unbind( "click" ); // Desvincula eventos click anteriores.
            $(".como-ver").click(function(){
                $('#marker-tooltip').hide(); // Oculta el tooltip al activar StreetView.
                var panorama = new google.maps.StreetViewPanorama(
                    document.getElementById('map'), {
                        position: pos, // Posición para StreetView.
                        pov: { // Punto de vista inicial para StreetView.
                            heading: 34,
                            pitch: 10
                        },
                        enableCloseButton: true // Permite cerrar la vista de StreetView.
                    }
                );
            });

            // Posicionamiento y visualización del tooltip.
            $('#marker-tooltip').css({
                'left': point.x,
                'top': point.y
            }).show();

            markerS = this; // Guarda una referencia al marcador actual en el tooltip.
        });
    } // Fin del bucle 'for' para marcadores.
} // Fin de la función 'setMarkers'.


// --- Otras Funciones Auxiliares ---

// Convierte coordenadas LatLng del mapa a coordenadas de píxeles en la pantalla.
function fromLatLngToPoint(latLng, map) {
    var topRight = map.getProjection().fromLatLngToPoint(map.getBounds().getNorthEast());
    var bottomLeft = map.getProjection().fromLatLngToPoint(map.getBounds().getSouthWest());
    var scale = Math.pow(2, map.getZoom());
    var worldPoint = map.getProjection().fromLatLngToPoint(latLng);
    return new google.maps.Point((worldPoint.x - bottomLeft.x) * scale, (worldPoint.y - topRight.y) * scale);
}

// Función para inicializar el evento 'change' del selector de ciudades cuando jQuery esté listo.
function defer() {
    if (window.jQuery) { // Comprueba si jQuery está cargado.
        console.log('Cargado'); // Mensaje de consola si jQuery está listo.
        $('#select_ciudades').change(function(event) {
            var pos = JSON.parse($(event.target).val()); // Parsea las coordenadas del valor de la opción seleccionada.
            map.panTo(new google.maps.LatLng(pos.lat, pos.lng)); // Centra el mapa en las coordenadas seleccionadas.
        });
    } else {
        // Reintenta la ejecución de 'defer' después de 50ms si jQuery aún no está cargado.
        setTimeout(function() { defer() }, 50);
    }
}
defer(); // Llama a 'defer' para inicializar el evento 'change' del selector.


// Función para activar la geolocalización del usuario y centrar el mapa.
function toogleLocator(){
    if (navigator.geolocation) { // Comprueba si el navegador soporta geolocalización.
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = { // Objeto de posición del usuario.
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            map.setCenter(pos); // Centra el mapa en la ubicación del usuario.
            placeMarker(pos); // Coloca un marcador en la ubicación del usuario.
        }, function() {
            // Manejo de error si la geolocalización falla o es denegada.
            map.setCenter({lat: 4.670905, lng: -74.062244}); // Centra en una ubicación por defecto.
            placeMarker({lat: 4.670905, lng: -74.062244}); // Coloca marcador en la ubicación por defecto.
        });
    } else {
        // El navegador no soporta geolocalización.
        map.setCenter({lat: 4.670905, lng: -74.062244}); // Centra en ubicación por defecto.
        placeMarker({lat: 4.670905, lng: -74.062244}); // Coloca marcador en ubicación por defecto.
    }
}

// Coloca un marcador en una ubicación específica (usado para la geolocalización).
function placeMarker(location) {
    if (miMarker != undefined) // Si ya existe un marcador, lo quita.
        miMarker.setMap (null);
    miMarker = new google.maps.Marker({ // Crea un nuevo marcador.
        position: location,
        map: map,
    });
}

// Traza la ruta más cercana a un punto de recolección desde la ubicación del usuario.
function traceNearestRoute(location) {
    n = find_closest_marker( location ); // Encuentra el marcador más cercano.
    if(n != -1){
        // Asegura que beaches[n].lat y beaches[n].lng sean las propiedades correctas y numéricas.
        var end = new google.maps.LatLng(parseFloat(beaches[n].lat),  parseFloat(beaches[n].lng));
        generateRoute(location, end); // Genera la ruta.
    }else{
        console.log('No hay puntos cercanos para trazar ruta.');
    }
}

// Convierte grados a radianes (para cálculos geográficos).
function rad(x) {return x*Math.PI/180;}

// Encuentra el marcador más cercano a una ubicación dada (algoritmo de distancia haversine).
function find_closest_marker( location ) {
    var lat = location.lat();
    var lng = location.lng();
    var R = 6371; // Radio de la Tierra en kilómetros.
    var distances = [];
    var closest = -1;
    for( i=0;i<beaches.length; i++ ) {
        // Asegura que beaches[i].lat y beaches[i].lng son las propiedades correctas y numéricas.
        var mlat = parseFloat(beaches[i].lat);
        var mlng = parseFloat(beaches[i].lng);
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

// Genera y muestra una ruta entre dos puntos en el mapa usando Directions API.
var generateRoute=function(origin,destination) {
    var request = {
       origin:origin, // Punto de origen.
       destination: destination, // Punto de destino.
       travelMode: google.maps.DirectionsTravelMode.DRIVING // Modo de viaje: coche.
    };

    directionsDisplay.setMap(map); // Muestra la ruta en el mapa.
    directionsService.route(request, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response); // Renderiza la ruta si es exitosa.
        } else {
            console.error('Error al generar la ruta:', status); // Mensaje de error si falla.
        }
    });
}
// ======================================================================================================================
// === FIN DEL CÓDIGO FINAL Y COMPLETO PARA assets/js/mapa-google.js ===
// ======================================================================================================================