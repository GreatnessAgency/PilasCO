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
    var beaches = [
        [4.66412,-74.13200,'ACTIVO','CC. Hayuelos ',' Clle. 20 Nº 82-52 ','Pública','Comercial'],
        [4.71547,-74.02920,'ACTIVO','CC. Palatino ',' Cra. 7 Nº 138-33','Pública','Comercial'],
        [4.66528,-74.05775,'ACTIVO','Centro de Alta Tecnología',' Cra. 15 Nº 77-05/59','Pública','Comercial'],
        [4.70288,-74.04275,'ACTIVO','CC. Unicentro ',' Cra. 15 Nº 124-30','Pública','Comercial'],
        [4.62657,-74.07555,'ACTIVO','RCN Radio ',' Clle. 37 Nº 13A-19','Cerrada','Comercial'],
        [4.65501,-74.10884,'ACTIVO','Maloka ',' Cra. 68D Nº 24A-51','Pública','Comercial'],
        [4.58563,-74.09441,'ACTIVO','Secretaria Distrital de Ambiente',' Av. Caracas Nº 54-38','Pública','Comercial'],
        [4.67465,-74.05479,'ACTIVO','Rayovac-Varta S.A. ',' Cra. 17 Nº 89-40','Cerrada','Comercial'],
        [4.68456,-74.05130,'ACTIVO','Eveready de Colombia S.A.',' Tv. 18 Nº 96-41 Piso 8','Cerrada','Comercial'],
        [4.76921,-74.02731,'ACTIVO','Teleport Business Park ',' Clle. 113 Nº 7-45 Torre B','Pública','Comercial'],
        [4.65047,-74.11645,'ACTIVO','Open Market Ltda',' Cra. 69 Nº 21-63','Cerrada','Comercial'],
        [4.70224,-74.04139,'ACTIVO','Pepe Ganga Unicentro','Av. Cra. 15 Nº 127-30  Local 1-196','Pública','Comercial'],
        [4.62286,-74.07788,'ACTIVO','Pepe Ganga Gran Estación ','Av. Clle. 26 Nº 62-47 Piso 2 Local 225-226','Pública','Comercial'],
        [4.76031,-74.04145,'ACTIVO','Pepe Ganga Santafé','Clle. 183 Nº 45-03 Local 132-133  ','Pública','Comercial'],
        [4.57584,-74.13825,'ACTIVO','Pepe Ganga CC. Tunal ','Cra. 24C Nº 48-94 Sur Local 1-115','Pública','Comercial'],
        [4.71612,-74.09605,'ACTIVO','Jumbo Iserra 100','Cra. 94 A Nº 98 A-51 Local 102','Pública','Comercial'],
        [4.71244,-74.07153,'ACTIVO','Jumbo CC. Bulevar ',' Av. Cra. 58 Nº 127- 59 Local 104','Pública','Comercial'],
        [4.63128,-74.14563,'ACTIVO','Jumbo Banderas ',' Av. de Las Américas con Cra. 76','Pública','Comercial'],
        [4.66287,-74.13194,'ACTIVO','Jumbo Fontibón','Clle. 17 Nº 112-58','Pública','Comercial'],
        [4.86388,-74.04406,'ACTIVO','Jumbo CC. Santafé','Clle. 185 Nº 45-03 Local 167','Pública','Comercial'],
        [4.86423,-74.04338,'ACTIVO','Jumbo Chía','Av. Pradilla Nº 2E-50','Pública','Comercial'],
        [4.74891,-74.04628,'ACTIVO','Panamericana Clle. 170',' Autopista Norte Nº 168-30','Pública','Comercial'],
        [4.59228,-74.12415,'ACTIVO','Panamericana Centro Mayor ',' Cra. 38A Nº 34D-50 Local 1-096','Pública','Comercial'],
        [4.61803,-74.13661,'ACTIVO','Sao Plaza de las Américas ',' Tv. 64 A Nº 26-50 Sur','Pública','Comercial'],
        [4.71157,-74.11150,'ACTIVO','Sao Portal 80 ',' Tv. 100A Nº 79-20 ','Pública','Comercial'],
        [4.77151,-74.04062,'ACTIVO','Makro Cumara ',' Clle. 192 Nº 19-12','Pública','Comercial'],
        [4.59774,-74.15306,'ACTIVO','Makro Villa del Rio ',' Cra. 63 Nº 57G-47 Sur','Pública','Comercial'],
        [4.73417,-74.06436,'ACTIVO','Éxito Colina ',' Av. Boyacá Cra. 72 Nº 146B','Pública','Comercial'],
        [4.75462,-74.04489,'ACTIVO','Éxito Clle. 170',' Clle. 175 Nº 22-13.','Pública','Comercial'],
        [4.68389,-74.08053,'ACTIVO','Éxito Clle. 80',' Cra. 59A Nº 79-30.','Pública','Comercial'],
        [4.67233,-74.15314,'ACTIVO','Éxito Fontibón ',' Av. Centenario Nº 106-104.','Pública','Comercial'],
        [4.63049,-74.12429,'ACTIVO','Éxito Américas ',' Av. Américas Nº 68A-94.','Pública','Comercial'],
        [4.71250,-74.03429,'ACTIVO','Éxito Country ',' Clle. 134  Nº 14-5','Pública','Comercial'],
        [4.59209,-74.12434,'ACTIVO','Éxito CC. Centro Mayor ',' Autopista Sur 38 A-07.','Pública','Comercial'],
        [4.68647,-74.07444,'ACTIVO','Éxito Floresta ','Cra. 68 Nº 90-88.','Pública','Comercial'],
        [4.64002,-74.06588,'ACTIVO','Éxito Chapinero ',' Clle. 52 Nº 13-70.','Pública','Comercial'],
        [4.59831,-74.10994,'ACTIVO','Éxito Ciudad Montes ',' Diag. 17 Sur Nº 32-40.','Pública','Comercial'],
        [4.69772,-74.10882,'ACTIVO','Éxito Zarzamora ',' Clle. 72 Nº 90-55.','Pública','Comercial'],
        [4.56785,-74.08722,'ACTIVO','Éxito 20 de Julio',' Clle. 21 Sur Nº 5A-34.','Pública','Comercial'],
        [4.71814,-74.03477,'ACTIVO','Carulla Clle. 140',' Cra. 11 Nº 140-29.','Pública','Comercial'],
        [4.64943,-74.05095,'ACTIVO','Colegio Nueva Granada ',' Cra. 2 Este Nº 70-20','Cerrada','Comercial'],
        [4.70264,-74.04144,'ACTIVO','CC. Unicentro 2 ',' Cra. 15 Nº 124-30','Pública','Comercial'],
        [4.66363,-74.13109,'ACTIVO','CC. Hayuelos 2 ',' Clle. 20 Nº 82-52 ','Pública','Comercial'],
        [4.71541,-74.02919,'ACTIVO','CC. Palatino 2 ',' Cra. 7 Nº 138-33','Pública','Comercial'],
        [4.61863,-74.13497,'ACTIVO','CC. Plaza de Las Américas 1 ',' Tv. 71D Nº 26-94 Sur','Pública','Comercial'],
        [4.61882,-74.13506,'ACTIVO','CC. Plaza de las Américas 2 ',' Tv. 71D Nº 26-94 Sur','Pública','Comercial'],
        [4.72297,-74.04526,'ACTIVO','Foto Japón Cedritos ','Clle. 140 Nº 18A-70','Pública','Comercial'],
        [4.60550,-74.07162,'ACTIVO','Foto Japón Calle 19','Clle. 19 Nº 7-16','Pública','Comercial'],
        [4.65604,-74.05682,'ACTIVO','Foto Japón Calle 72','Clle. 72 Nº 9-23','Pública','Comercial'],
        [4.63454,-74.14755,'ACTIVO','Foto Japón Kennedy 1 ','Clle. 37 Nº 78G-17 Sur','Pública','Comercial'],
        [4.57637,-74.12885,'ACTIVO','Foto Japón C.C. Tunal','Clle. 47B Sur Nº 44B-33 Local 2075','Pública','Comercial'],
        [4.65614,-74.10626,'ACTIVO','Edificio Torre Central ','Cra. 68D Nº 25B-86','Pública','Comercial'],
        [4.61612,-74.07067,'ACTIVO','Edificio Centro de Comercio Internacional ','Clle. 28 Nº 13A-15','Pública','Comercial'],
        [4.61088,-74.07028,'ACTIVO','Torre Colpatria ',' Cra. 7 Nº 24-84','Pública','Comercial'],
        [4.69096,-74.03838,'ACTIVO','Torre Empresarial Pacific','Clle. 110 Nº  9-25 ','Pública','Comercial'],
        [4.64068,-74.09719,'ACTIVO','Secretaria del ambiente - Gobernación de Cundinamarca ',' Av. Dorado  51-53 Torre Beneficencia - Piso 3 ','Pública','Comercial'],
        [4.73396,-74.04426,'ACTIVO','Colegios Anglo Colombiano ',' Av. 19 Nº 152A-48','Cerrada','Comercial'],
        [4.71492,-74.07599,'ACTIVO','Colegio Helvetia de Bogotá ',' Clle. 128 Nº 71A-91','Cerrada','Comercial'],
        [4.80098,-74.05111,'ACTIVO','Colegio Nueva York ',' Clle. 222 Nº 49-64 Urbanización El Jardín','Cerrada','Comercial'],
        [4.65823,-74.05654,'ACTIVO','Colegio Gimnasio Moderno ',' Clle. 74 Nº 9-99','Cerrada','Comercial'],
        [4.61734,-74.08709,'ACTIVO','La 14 Sede Bogotá 1 ','Av. Clle. 19 Nº 28-80 Paloquemado','Pública','Comercial'],
        [4.72303,-74.11470,'ACTIVO','CC. Unicentro de Occidente ',' Cra. 111C Nº 86-05','Pública','Comercial'],
        [4.62879,-74.08191,'ACTIVO','Contraloría De Bogotá ',' Cra. 32A Nº 26A-10','Pública','Comercial'],
        [4.67180,-74.15537,'ACTIVO','Zona Franca Fontibón 1 ',' Cra. 106 Nº 15-25','Cerrada','Comercial'],
        [4.67180,-74.15537,'ACTIVO','Zona Franca Fontibón 2 ',' Cra. 106 Nº 15-25','Cerrada','Comercial'],
        [4.58391,-74.14480,'ACTIVO','GM-General Motors Colombia ','Av. Boyacá Clle. 56 Sur N° 33-53','Cerrada','Comercial'],
        [4.65326,-74.10943,'ACTIVO','CC. Salitre Plaza ',' Cra. 68B Nº 24-39','Pública','Comercial'],
        [4.64287,-74.07430,'ACTIVO','CC.  Galerías ',' Clle. 53B Nº 25 21','Pública','Comercial'],
        [4.61455,-74.07069,'ACTIVO','Superintendencia de Industria y Comercio ',' Cra. 13 Nº 2 -00 Piso 3','Pública','Comercial'],
        [4.75226,-74.09321,'ACTIVO','Office Depot Suba ',' Av. Cra. 104 Nº 152-A-65','Pública','Comercial'],
        [4.69829,-74.04886,'ACTIVO','Office Depot Pepe Sierra ',' Clle. 116 Nº 18B-68','Pública','Comercial'],
        [4.76896,-74.03519,'ACTIVO','Colegio San Carlos ',' Clle. 192 Nº 9-45','Cerrada','Comercial'],
        [4.64221,-74.15608,'ACTIVO','Foto Japón C.C. Tintal','Cra. 86 Nº 6-37 Local 172-173','Pública','Comercial'],
        [4.60110,-74.07357,'ACTIVO','Foto Japón Av. Jiménez',' Cra. 7 Nº 14-36','Pública','Comercial'],
        [4.66701,-74.05296,'ACTIVO','Foto Japón Andino ',' Cra. 11 Nº 82-01 Local 307','Pública','Comercial'],
        [4.62367,-74.06656,'ACTIVO','Corporación Autónoma Regional De Cundinamarca ',' Cra. 7 Nº 36-45','Pública','Comercial'],
        [4.62136,-74.06692,'ACTIVO','Dirección Seccional de Impuestos de Grandes Contribuyentes ',' Cra. 7 Nº 34-65','Pública','Comercial'],
        [11.01372,-74.82737,'ACTIVO','Pepe Ganga CC. Buenavista ',' Cra. 53 Clle. 99 Esquina Local 321','Pública','Comercial'],
        [10.96528,-74.79335,'ACTIVO','Sao Calle 47 ',' Clle. 47 Cra. 9D Macarena','Pública','Comercial'],
        [10.96853,-74.80373,'ACTIVO','Olímpica Cra. 21',' Cra. 21B Nº 63B-50','Pública','Comercial'],
        [10.95684,-74.78987,'ACTIVO','Olímpica Clle. 36',' Clle. 36B Cra. 8 Esquina','Pública','Comercial'],
        [11.00487,-74.79548,'ACTIVO','Olímpica Clle. 73',' Clle. 73 Cra. 41C-53','Pública','Comercial'],
        [11.01568,-74.83633,'ACTIVO','Makro Villa Santos','Cra. 51B Av. Circunvalar','Pública','Comercial'],
        [10.9694,-74.79035,'ACTIVO','Éxito Murillo ',' Clle. 45 Nº 26-129','Pública','Comercial'],
        [11.00826,-74.82107,'ACTIVO','Éxito Barranquilla ',' Cra. 51B Nº 87-50','Pública','Comercial'],
        [11.01352,-74.82733,'ACTIVO','Éxito Buenavista ',' Cra. 53 con Clle. 98','Pública','Comercial'],
        [10.98610,-74.77028,'ACTIVO','Éxito Metropolitano ',' Av. Circunvalar Clle. Murillo Esquina','Pública','Comercial'],
        [10.99214,-74.79455,'ACTIVO','Foto Japón Prado ',' Cra. 50 Nº 48-227 Local 152','Pública','Comercial'],
        [7.12389,-73.12165,'ACTIVO','Pepe Ganga CC. Florida ',' Clle. 31 Nº 26A-27  Local 308','Pública','Comercial'],
        [7.12953,-73.11422,'ACTIVO','Jumbo Megamall ','Cra. 33A Nº 29-15 Local 29','Pública','Comercial'],
        [7.13659,-73.12954,'ACTIVO','Éxito Bucaramanga ',' Cra. 17 Nº 45-77.','Pública','Comercial'],
        [7.126453,-73.12032,'ACTIVO','Foto Japón CC. Cañaveral ','C.C. Cañaveral Local 107','Pública','Comercial'],
        [10.39725,-75.47489,'ACTIVO','Sao La Plazuela ',' Diag. 31 Nº 71-130 Multicentro','Pública','Comercial'],
        [10.41091,-75.48947,'ACTIVO','Makro Cartagena ',' Cra. 59B Nº 30D-21','Pública','Comercial'],
        [10.40648,-75.50326,'ACTIVO','Éxito Cartagena ',' Clle. 31 Nº 69-75.','Pública','Comercial'],
        [5.06897,-75.51348,'ACTIVO','La 14 Sede Manizales 1 ',' Cra. 20 Nº 28-40','Pública','Comercial'],
        [6.20307,-75.55863,'ACTIVO','Pepe Ganga CC. Oviedo ',' Clle. 6 Sur Nº 43A-227 Local 52-50','Pública','Comercial'],
        [6.27343,-75.57954,'ACTIVO','Jardín Botánico ',' Clle. 73 Nº 51D-14','Pública','Comercial'],
        [6.24317,-75.57222,'ACTIVO','Gobernación  Antioquia ',' Clle. 42B Nº 52-106','Pública','Comercial'],
        [6.19685,-75.57432,'ACTIVO','Jumbo CC. Santa Fe','Av. El Poblado Cra. 43A con Clle. 7 Sur','Pública','Comercial'],
        [6.23050,-75.57058,'ACTIVO','Jumbo CC. Premium Plaza','Cra. 44 Nº 29-80','Pública','Comercial'],
        [6.23592,-75.57513,'ACTIVO','Makro San Juan ',' Av. San Juan con Cra. 65','Pública','Comercial'],
        [6.33849,-75.54677,'ACTIVO','Éxito Bello ',' Diag. 51 Nº 35-120.','Pública','Comercial'],
        [6.20874,-75.56586,'ACTIVO','Éxito Poblado ',' Clle. 10 Nº 43E-135','Pública','Comercial'],
        [6.28546,-75.57217,'ACTIVO','Éxito Colombia ',' Cra. 66 Nº 49-01','Pública','Comercial'],
        [6.23544,-75.57275,'ACTIVO','Éxito Envigado ','Cra. 48 Nº 34B Sur 29','Pública','Comercial'],
        [6.24126,-75.58626,'ACTIVO','Éxito CC. Unicentro ',' Cra. 66 A Nº 34A-25 Local 039','Pública','Comercial'],
        [6.24795,-75.55942,'ACTIVO','Foto Japón 1º de Mayo ',' Clle. 52 Nº 49-114','Pública','Comercial'],
        [6.25013,-75.56621,'ACTIVO','Edificio Coltejer ',' Clle. 52 Nº 47-42 Edificio Coltejer','Pública','Comercial'],
        [6.17675,-75.59072,'ACTIVO','Almacenes Éxito Sede Administrativa ',' Cra. 48 Nº 32B Sur-139 Envigado','Pública','Comercial'],
        [6.18534,-75.57903,'ACTIVO','Office Depot Sao Paulo ',' Cra. 43A Nº 18 Sur 135','Pública','Comercial'],
        [6.19838,-75.55668,'ACTIVO','Office Depot Del Este ','CC. del Este Cra. 25 con Clle. 3 Vía del Tesoro Local 171','Pública','Comercial'],
        [6.22921,-75.57062,'ACTIVO','Foto Japón Premium Plaza ',' Cra. 44 Nº 29-80 Local 166','Pública','Comercial'],
        [6.23112,-75.58530,'ACTIVO','Almacén General - Proveeduría EPM ','Clle. 30 N° 65-315 Interior 197','Pública','Comercial'],
        [6.24534,-75.57776,'ACTIVO','Edificio EPM ','Cra. 5 Nº 24-28','Pública','Comercial'],
        [6.16991,-75.60717,'ACTIVO','Oficina de  atención al cliente - EPM Itagüí  ',' Clle. 52 Nº 47-46','Pública','Comercial'],
        [6.23377,-75.59638,'ACTIVO','Mascerca Belén - EPM ',' Cra. 76 Nº 32-74','Pública','Comercial'],
        [6.25897,-75.60663,'ACTIVO','Mascerca Floresta - EPM ',' Cra. 89B Nº 48A-37','Pública','Comercial'],
        [6.33565,-75.56143,'ACTIVO','Oficina de  atención al cliente EPM Edificio Miguel de Aguinaga ',' Clle. 52 Nº 53-49','Pública','Comercial'],
        [6.24135,-75.55382,'ACTIVO','Mascerca Buenos Aires - EPM ',' Clle. 49 Nº 31-12','Pública','Comercial'],
        [6.33189,-75.55832,'ACTIVO','Oficina de atención al cliente - EPM Bello ',' Cra. 50 Nº 46-46','Pública','Comercial'],
        [6.23314,-75.60407,'ACTIVO','CC. Los Molinos ',' Clle. 30A Nº 82A-26','Pública','Comercial'],
        [4.81556,-75.68529,'ACTIVO','Jumbo Avenida del Rio ','Av. del Río Nº 7-02','Pública','Comercial'],
        [4.81137,-75.69102,'ACTIVO','Éxito Cra. 10',' Cra. 10 Nº 14-71 ','Pública','Comercial'],
        [4.81562,-75.69478,'ACTIVO','Multidrogas Centro ',' Cra. 6 Nº 19-82 Centro Esquina','Pública','Comercial'],
        [4.81228,-75.70724,'ACTIVO','Multidrogas Av. 30 de Agosto ',' Av. 30 de Agosto Nº 34-38  Esquina','Pública','Comercial'],
        [4.80842,-75.68995,'ACTIVO','ANDI - Seccional Risaralda Quindío ',' Clle. 13 Nº 13-40 Oficina 312 A','Cerrada','Comercial'],
        [4.81350,-75.69806,'ACTIVO','Fundación Universitaria del Área Andina Seccional Pereira ',' Clle. 24 Nº 8-55','Pública','Comercial'],
        [4.65397,-74.05564,'ACTIVO','Edificio Avenida Chile','Cra. 7 Nº 7-21','Pública','Comercial'],
        [4.65726,-74.10763,'ACTIVO','Edificio World Business Port','Cra. 69 Nº 25B-44','Pública','Comercial'],
        [4.65530,-74.10596,'ACTIVO','Torre Seguros Bolívar','Av. El Dorado Nº 68B-31','Pública','Comercial'],
        [4.60478,-74.07527,'ACTIVO','Seguros Bolívar Oficina Cra. 10','Cra. 10 Nº16-39','Pública','Comercial'],
        [4.72645,-74.06079,'ACTIVO','Parque Comercial La Colina 138','Clle. 138 Nº55-53 Administración','Pública','Comercial'],
        [4.69255,-74.03473,'ACTIVO','Edificio Torres unidas 2','Av. Cra. 9 Nº 113-52','Pública','Comercial'],
        [4.69219,-74.03412,'ACTIVO','Edificio Teleport Business Park','Clle. 113 Nº 7-45 Torre B','Pública','Comercial'],
        [4.65757,-74.05384,'ACTIVO','Edificio Terpel','Cra. 7 Nº 75-51','Pública','Comercial'],
        [4.68359,-74.04742,'ACTIVO','Edificio Torre REM','Cra. 14 Nº 99-33','Pública','Comercial'],
        [4.65663,-74.05568,'ACTIVO','Federación Nacional de Cafeteros de Colombia','Clle. 73 Nº 8-13','Pública','Comercial'],
        [4.75206,-74.02397,'ACTIVO','Gimnasio José Joaquín Casas','Cra. 7 Nº 173-02','Pública','Comercial'],
        [4.78145,-74.04398,'ACTIVO','Escuela Colombiana de Ingeniería','Autopista Norte Nº 205-59','Pública','Comercial'],
        [4.79910,-74.05021,'ACTIVO','U.D.C.A. Campus Sur','Clle. 222 Nº 55-37','Pública','Comercial'],
        [4.79956,-74.05021,'ACTIVO','U.D.C.A. Campus Norte','Clle. 222 Nº 55-37','Pública','Comercial'],
        [4.65909,-74.06105,'ACTIVO','U.D.C.A. Sede Norte','Clle. 72 Nº 14-20','Pública','Comercial'],
        [4.62352,-74.07212,'ACTIVO','U.D.C.A. Sede Teusaquillo','Cra. 17 Nº 34-41','Pública','Comercial'],
        [4.65866,-74.09971,'ACTIVO','Compensar - Centro de Servicios y Desarrollo Empresarial','Av. 68 Nº 49A-47','Pública','Comercial'],
        [4.66168,-74.10123,'ACTIVO','Compensar - Centro Urbano de Recreación','Av. 68 Nº 49A-47','Pública','Comercial'],
        [4.68143,-74.05755,'ACTIVO','Compensar - Unidad de Servicios de Salud Clle. 94','Clle. 94 Nº 23-43','Pública','Comercial'],
        [4.78989,-74.04434,'ACTIVO','Gimnasio Los Andes','Av. Clle. 209 Nº 45-80','Cerrada','Comercial'],
        [4.65557,-74.11342,'ACTIVO','Colegio Agustiniano Ciudad Salitre','Clle. 23C Nº 69B-01','Cerrada','Comercial'],
        [4.61091,-74.15752,'ACTIVO','Colegio Santa Luisa','Cra. 74 Nº 42C-40 Sur','Cerrada','Comercial'],
        [4.68569,-74.05198,'ACTIVO','Edificio Prime Tower','Clle. 100 Nº 19-54','Pública','Comercial'],
        [4.65673,-74.05419,'ACTIVO','Edificio Deloitte','Cra. 7 Nº 74-09','Pública','Comercial'],
        [4.64454,-74.06438,'ACTIVO','Telefónica - Centro de experiencia Chapinero','Cra. 13 Nº 58-71','Pública','Comercial'],
        [4.63184,-74.11676,'ACTIVO','Fondo Nacional del Ahorro','Cra. 65 Nº 11-83','Pública','Comercial'],
        [4.62476,-74.06718,'ACTIVO','Ministerio de Ambiente y Desarrollo Sostenible','Clle. 37 Nº 8-40','Pública','Comercial'],
        [4.60010,-74.07352,'ACTIVO','Universidad del Rosario - Claustro','Clle. 12C Nº 6-25','Pública','Comercial'],
        [4.65437,-74.07282,'ACTIVO','Universidad del Rosario - Quinta de Mutis','Cra. 24 Nº 63C-69','Pública','Comercial'],
        [4.77459,-74.03974,'ACTIVO','Universidad del Rosario - Complementaria','Av. Cra. 45 Nº 198-40','Pública','Comercial'],
        [4.66110,-74.05968,'ACTIVO','Universidad Sergio Arboleda','Clle. 74 Nº14-14','Pública','Comercial'],
        [4.60001,-74.07789,'ACTIVO','Colegio Mayor Nuestra Señora De La Esperanza','Cra. 10 Nº 11-46 Barrio La Despensa','Cerrada','Comercial'],
        [4.75193,-74.08112,'ACTIVO','Colegio San Jorge de Inglaterra','Cra. 92 Nº 156-88  Suba','Cerrada','Comercial'],
        [4.78112,-74.05219,'ACTIVO','Colegio de la Enseñanza','Av. Clle. 201 Nº 67-12','Cerrada','Comercial'],
        [4.58488,-74.20613,'ACTIVO','CC. Unisur','Cra. 3A Nº 29A-02 Autopista Sur','Pública','Comercial'],
        [7.11655,-73.11089,'ACTIVO','CC. Gratamira','Cra. 33 Nº 48-109 Oficina 311','Pública','Comercial'],
        [7.10596,-73.09770,'ACTIVO','Universidad de Santander UDES','Clle. 70 Nº 55-210 Lagos del Cacique, Edificio Muisca Piso 2','Pública','Comercial'],
        [7.13838,-73.12007,'ACTIVO','Universidad Industrial de Santander','Cra. 27 Clle. 9','Pública','Comercial'],
        [3.41474,-76.54774,'ACTIVO','CC. Cosmocentro','Clle. 5 Nº 50-103','Pública','Comercial'],
        [3.39358,-76.54505,'ACTIVO','La 14 Sede Limonar','Autopista Clle. 5 Nº 70-05','Pública','Comercial'],
        [3.47105,-76.48592,'ACTIVO','La 14 Sede Sameco','Clle. 70 Nº 2N-30','Pública','Comercial'],
        [3.36953,-76.52474,'ACTIVO','La 14 Sede Valle del Lili','Cra. 98B Nº 25-130','Pública','Comercial'],
        [3.450548,-76.53610,'ACTIVO','La 14 Sede Centenario','Av. 4 Norte Nº 7N-46','Pública','Comercial'],
        [3.42707,-76.53770,'ACTIVO','La 14 Sede Centro Sur','Clle. 9A Nº 32A-16','Pública','Comercial'],
        [3.37411,-76.52353,'ACTIVO','Makro Valle del Lili','Cra. 94 Nº 25-60','Pública','Comercial'],
        [3.47591,-76.52953,'ACTIVO','Éxito Chipichape','Av. 6 Norte Nº 35-47 Local 519','Pública','Comercial'],
        [3.42519,-76.54486,'ACTIVO','Éxito San Fernando','Clle. 5 Nº 38D-35','Pública','Comercial'],
        [3.48738,-76.51744,'ACTIVO','Éxito La Flora','Av. 3F Norte 52N-46','Pública','Comercial'],
        [3.37330,-76.53936,'ACTIVO','Éxito Unicali','Cra. 100 Nº5 - 169 Local 244','Pública','Comercial'],
        [10.38683,-75.52068,'ACTIVO','ANDI Seccional Bolívar','Mamonal Km. 5 Sector Puerta de Hierro','Cerrada','Comercial'],
        [6.20357,-75.57158,'ACTIVO','ANDI - Seccional Antioquia','Cra. 43A Nº 1-50','Cerrada','Comercial'],
        [4.81561,-75.69495,'ACTIVO','RCN Radio','Clle. 20 Nº 6-30','Cerrada','Comercial'],
        [4.63494,-74.11301,'ACTIVO','Alpina Oficinas Centrales','Cra.  63 Nº 14-97','Cerrada','Comercial'],
        [4.67045,-74.11449,'ACTIVO','Dirección de Investigación Criminal e INTERPOL (DIJIN)','Av.  El Dorado Nº 75-25','Pública','Comercial'],
        [4.63559,-74.11375,'ACTIVO','Dirección de Protección y Servicios Especiales (DIPRO)','Clle.  14 Nº 65-85','Pública','Comercial'],
        [4.59600,-74.15809,'ACTIVO','Indusel S.A ','Autopista Sur Nº 70-51','Cerrada','Comercial'],
        [4.63748,-74.09213,'ACTIVO','Señal Colombia','Cra.  45 Nº 26-33 ','Cerrada','Comercial'],
        [4.62021,-74.09805,'ACTIVO','Mazda','Cra.  38 Nº 13-05  Puerta 4','Cerrada','Comercial'],
        [4.71076,-74.06158,'ACTIVO','Unidad Residencial Niza IX','Clle.  127B Bis Nº 53-15','Cerrada','Comercial'],
        [4.69184,-74.03366,'ACTIVO','Hocol Bogotá ','Cra.  7 Nº 113-43 Piso 16','Cerrada','Comercial'],
        [4.59566,-74.16398,'ACTIVO','Pavco Bogotá','Autopista Sur Nº 71-75','Cerrada','Comercial'],
        [4.68888,-74.05169,'ACTIVO','Findeter','Clle.  103 Nº 19-20','Cerrada','Comercial'],
        [4.67466,-74.04293,'ACTIVO','Bavaria - Sede Administrativa','Clle. 94 Nº 7A-47','Cerrada','Comercial'],
        [4.67771,-74.04684,'ACTIVO','Colombiana Kimberly Colpapel S.A.','Cra.  11A Nº 94-45 ','Cerrada','Comercial'],
        [4.67158,-74.04707,'ACTIVO','Asocolflores','Cra. 9A Nº 90-53','Cerrada','Comercial'],
        [4.60638,-74.07124,'ACTIVO','Centro de Servicios ETB','Cra.  7 Nº 20-39','Pública','Comercial'],
        [4.66623,-74.05552,'ACTIVO','CC. Atlantis Plaza','Clle.  81 Nº 13-05','Pública','Comercial'],
        [4.64646,-74.09787,'ACTIVO','Edificio T3 Ciudad Empresarial Sarmiento Angulo','Av.  Clle.  26 Nº 59-51','Pública','Comercial'],
        [4.61564,-74.06996,'ACTIVO','Edificio Palma Real','Clle. 28 Nº 13-22','Pública','Comercial'],
        [4.69602,-74.03217,'ACTIVO','Edificio Santa Ana Medical Center','Clle. 119 Nº 7-14','Pública','Comercial'],
        [4.69468,-74.08620,'ACTIVO','CC. Titán Plaza','Av.  Cra.  72 Nº 80-94','Pública','Comercial'],
        [4.62164,-74.09398,'ACTIVO','Conservas Colombina S.A.','Cra. 36 Nº 17B-54','Cerrada','Comercial'],
        [4.64852,-74.06149,'ACTIVO','Fundación Universitaria Konrad Lorenz','Cra. 9 Bis Nº 62-43','Pública','Comercial'],
        [4.60755,-74.06777,'ACTIVO','Universidad Jorge Tadeo Lozano','Cra.  4A Nº 23-40','Pública','Comercial'],
        [4.59478,-74.07103,'ACTIVO','Universidad de La Salle - Sede Candelaria','Cra. 2A Nº 10-70','Pública','Comercial'],
        [4.64508,-74.05985,'ACTIVO','Universidad de La Salle - Sede Chapinero','Cra. 5 Nº 59A-44','Pública','Comercial'],
        [4.75410,-74.02489,'ACTIVO','Universidad de La Salle - Sede Norte','Cra 7 Nº 174-85','Pública','Comercial'],
        [4.69603,-74.04352,'ACTIVO','Carulla Pepe Sierra','Cra.  15 Nº 114A-33','Pública','Comercial'],
        [4.80842,-74.06889,'ACTIVO','Colegio Colombo Gales','Av. Guaymaral Costado Sur Aeropuerto','Cerrada','Comercial'],
        [4.68035,-74.03807,'ACTIVO','Edificio grupo Santander Central Hispano','Cra. 7 Nº 99-53','Pública','Comercial'],
        [4.74689,-74.09539,'ACTIVO','Transmasivo s.a. ','Av.  Suba con Av. Ciudad de Cali, Patio Portal Suba','Cerrada','Comercial'],
        [4.68418,-74.04151,'ACTIVO','Escuela Súperior de Guerra','Cra. 11 Nº 102-50','Cerrada','Comercial'],
        [4.75536,-74.08902,'ACTIVO','Conjunto Residencial  Prados de Suba Etapa I','Cra. 102 Nº 155-19','Cerrada','Comercial'],
        [4.73725,-74.10635,'ACTIVO','Nueva Tibabuyes Sector A','Cra. 123 Nº 131-61 ','Cerrada','Comercial'],
        [4.74643,-74.04160,'ACTIVO','Petrotiger - TigerCompany  - Sede Toberín','Cra. 19 Nº 166-53','Pública','Comercial'],
        [4.73166,-74.02406,'ACTIVO','Petrotiger - TigerCompany - Edificio North Point III','Cra. 7 Nº 156-68 Piso 21','Pública','Comercial'],
        [4.69601,-74.03145,'ACTIVO','Centro Médico De la Sabana','Cra. 7A Nº 119-14','Pública','Comercial'],
        [4.53233,-74.11848,'ACTIVO','CC. Altavista','Cra. 1 Nº 65 D-58 sur','Pública','Comercial'],
        [4.66341,-74.05463,'ACTIVO','Universidad EAN Edificio de la L','Cra.11 Nº 78-47 Esquina (Clle. 78)','Pública','Comercial'],
        [4.66356,-74.05457,'ACTIVO','Universidad EAN Sede Nogal','Sede Nogal  Clle. 79 N. 11-45 Esquina','Pública','Comercial'],
        [4.76035,-74.05873,'ACTIVO','Colegio Hispanoamérica Conde Ansurez','Cra. 67 Nº 173A-80','Cerrada','Comercial'],
        [4.60471,-74.10129,'ACTIVO','Alcaldía Local de Puente Aranda','Cra.  31D Nº 4-05','Pública','Comercial'],
        [4.75446,-74.05332,'ACTIVO','Fundación Universitaria Agraria de Colombia - Uniagraria','Clle. 170 Nº 54A-10','Pública','Comercial'],
        [4.64419,-74.08342,'ACTIVO','ICONTEC','Cra. 37 Nº 52-95','Pública','Comercial'],
        [4.76293,-74.04526,'ACTIVO','Foto Japón Santafé','Clle. 185 Nº 45-03 Local 3-127','Pública','Comercial'],
        [4.64195,-74.07493,'ACTIVO','Foto Japón Galerías','Clle.  53 Nº 25-83','Pública','Comercial'],
        [4.82116,-74.03454,'ACTIVO','Colegio  Fundación  Colombia','Carretera Central del Norte (Cra. 7) km. 14-15','Cerrada','Comercial'],
        [4.59969,-74.07564,'ACTIVO','Edificio Bancol - Ministerio del Interior','Cra. 8 Nº 12B-31','Pública','Comercial'],
        [4.59546,-74.07687,'ACTIVO','Casa La Giralda - Ministerio del Interior','Cra.  8 Nº 7-93','Pública','Comercial'],
        [4.61955,-74.06323,'ACTIVO','Colegio San Bartolomé la Merced','Cra. 5 Nº 33B-80','Cerrada','Comercial'],
        [4.66112,-74.05619,'ACTIVO','Carulla Nogal','Cra. 11 Nº 76-19','Pública','Comercial'],
        [4.69852,-74.08173,'ACTIVO','Carulla Pontevedra','Av. Boyacá con Clle. 98 (Costado Oriental)','Pública','Comercial'],
        [4.65487,-74.05951,'ACTIVO','Carulla Quinta Camacho','Cra.  10A Nº 70-37','Pública','Comercial'],
        [4.70518,-74.05082,'ACTIVO','Carulla Santa Bárbara','Cra.  10A Nº 70-37','Pública','Comercial'],
        [4.68700,-74.05173,'ACTIVO','Carulla Clle. 102','Av. 19 Nº 101-66','Pública','Comercial'],
        [4.71132,-74.07272,'ACTIVO','Carulla Niza','Av. Clle. 127 Nº 60-26 Local 30','Pública','Comercial'],
        [4.73300,-74.04276,'ACTIVO','Carulla Cedro Bolívar','Cra.  17 Nº 151-44','Pública','Comercial'],
        [4.74037,-74.06437,'ACTIVO','Carulla Rincón de la Colina','Cra.  59 Nº 152B-97','Pública','Comercial'],
        [4.69125,-74.03817,'ACTIVO','Carulla Clle. 110','Clle. 110 Nº 9B-80 ','Pública','Comercial'],
        [4.72280,-74.06241,'ACTIVO','Carulla San Rafael','Clle. 134 Nº 55-30 Local 105','Pública','Comercial'],
        [4.67728,-74.07639,'ACTIVO','Sede Administrativa Clle. 80','Cra.  59A Nº 79-30','Pública','Comercial'],
        [4.64410,-74.11931,'ACTIVO','PERMODA SEDE Clle. 18 ','Clle. 17A Nº 68D-88','Cerrada','Comercial'],
        [4.74957,-74.03775,'ACTIVO','Colegio Fundación de Inglaterra','Clle. 170 Nº 15-68','Cerrada','Comercial'],
        [4.67986,-74.03884,'ACTIVO','Edificio Grupo Santander Central Hispa Nº 2','Cra. 7 Nº 99-53','Pública','Comercial'],
        [4.59916,-74.07487,'ACTIVO','Banco Corpbanca','Clle.  12 Nº 7-36','Pública','Comercial'],
        [4.71035,-74.03231,'ACTIVO','Universidad el Bosque','Cra. 9 Nº 131A-02','Pública','Comercial'],
        [4.75898,-74.15525,'ACTIVO','Terminal Terrestre de Carga','Autopista Medellín K.M 3.5 Costado Sur','Cerrada','Comercial'],
        [4.74066,-74.07154,'ACTIVO','Gimnasio el Hontanar','Cra. 76 Nº 150-26','Cerrada','Comercial'],
        [4.65956,-74.05229,'ACTIVO','BCSC - Dirección General Clle. 77','Cra. 7 Nº 77-65','Pública','Comercial'],
        [4.64569,-74.06378,'ACTIVO','BCSC - Sede Administrativa Clle. 59','Clle.  59 Nº 10-60','Pública','Comercial'],
        [4.61703,-74.06748,'ACTIVO','BCSC - Sede Administrativa Clle. 31','Clle.  31 Nº 6-90','Pública','Comercial'],
        [4.62733,-74.07814,'ACTIVO','Canal Trece','Tv. 28A Nº 39-29','Cerrada','Comercial'],
        [4.61461,-74.07081,'ACTIVO','Edificio Porvenir','Cra. 13 26A-65','Cerrada','Comercial'],
        [4.62823,-74.17246,'ACTIVO','SOMOS S.A. Patio Américas ','Cra. 86 Bis Nº 45-57 Sur','Cerrada','Comercial'],
        [4.69314,-74.13428,'ACTIVO','Avíanca - Terminal de pasajeros Puente Aéreo','Av.  El Dorado Nº 106-28','Pública','Comercial'],
        [4.69337,-74.13457,'ACTIVO','Avíanca - Mantenimiento ','Av.  El Dorado Nº 106-74','Cerrada','Comercial'],
        [4.64563,-74.09950,'ACTIVO','Avíanca - Centro Administrativo ','Av. El Dorado Nº 59-15','Cerrada','Comercial'],
        [4.65582,-74.05850,'ACTIVO','Edificio Fiduprevisora S.A.','Clle.  71 Nº 10-04 Ofc. 201','Cerrada','Comercial'],
        [4.68481,-74.05613,'ACTIVO','Edificio Proksol','Clle.  97 Nº 23-60','Cerrada','Comercial'],
        [4.66820,-74.10332,'ACTIVO',' Universidad Libre Sede Bosque Popular','Cra. 70 Nº 53-40','Pública','Comercial'],
        [4.59481,-74.07546,'ACTIVO',' Universidad Libre Sede Candelaria','Clle.  8 Nº 5-80','Pública','Comercial'],
        [4.61917,-74.06776,'ACTIVO','CC. San Martin','Cra.  7 Nº 32-12','Pública','Comercial'],
        [4.62925,-74.09770,'ACTIVO','NALSANI S.A. - TOTTO','Cra. 43 A Nº 20C-55','Cerrada','Comercial'],
        [4.64843,-74.11758,'ACTIVO','Pepsico','Cra. 69 Nº 19-75 ','Cerrada','Comercial'],
        [4.67363,-74.08909,'ACTIVO','Cruz Roja Colombiana Seccional Cundinamarca y Bogotá','Av. Cra. 68 Nº 68B-31 Edificio Bloque Norte Piso 3 ','Pública','Comercial'],
        [4.60239,-74.07233,'ACTIVO','Edificio Avíanca P.H','Clle. 16 Nº 6-66','Pública','Comercial'],
        [4.68072,-74.04034,'ACTIVO','Edificio WORLS TRADE CENTER ','Clle. 100 8A 37-55','Pública','Comercial'],
        [4.69527,-74.05537,'ACTIVO','Edificio Paralelo 108','Clle. 108 Nº 45-30','Pública','Comercial'],
        [4.68074,-74.04165,'ACTIVO','Edificio Citibank PH','Cra.  9A Nº 99-02','Pública','Comercial'],
        [10.97531,-74.77374,'ACTIVO','Bavaria  - Barranquilla','Recepción Clle. 10 Nº 38-280','Pública','Comercial'],
        [10.99637,-74.79666,'ACTIVO','Corporación Autónoma Regional del Atlántico CRA','Clle.  66 Nº 54-46','Cerrada','Comercial'],
        [11.00290,-74.81578,'ACTIVO','Carulla Clle. 82','Clle. 82 Nº 50-71','Pública','Comercial'],
        [11.01909,-74.86434,'ACTIVO','Carulla Villa Campestre','Cra.  51B Corredor Tajamares (Universitario) Nº 135','Pública','Comercial'],
        [11.00435,-74.80714,'ACTIVO','Carulla Villa Country','Clle.  78 Nº 53-70 Local 100','Pública','Comercial'],
        [10.40725,-75.50849,'ACTIVO','Surtigas S.A E.S.P','Av.  Pedro Heredia Clle. 31 Nº 47-30','Pública','Comercial'],
        [10.41179,-75.54853,'ACTIVO','Base Naval ARC "Bolívar"','Cra. 2 Nº 10-02 Barrio Bocagrande, Av.  San Martín','Cerrada','Comercial'],
        [10.41333,-75.54021,'ACTIVO','Carulla Villa Susana','Manga Cra. 20 Nº 21A-31','Pública','Comercial'],
        [10.39209,-75.48035,'ACTIVO','Carulla Santa Lucía','CC.  Santa Lucia Diag. 31Nº 57-175','Pública','Comercial'],
        [7.16212,-73.13718,'ACTIVO','Bavaria - Bucaramanga','Km. 4 vía Café Madrid','Cerrada','Comercial'],
        [7.11779,-73.10875,'ACTIVO','La Quinta Centro Comercial','Cra. 36 Nº 47-49  Oficina 404','Pública','Comercial'],
        [7.12098,-73.12501,'ACTIVO','Centro Comercial Bucacentro ','Clle. 33 Nº 18-36 Barrio Centro','Pública','Comercial'],
        [7.03770,-73.07182,'ACTIVO','Universidad Pontificia Bolivariana  ','Km. 7 Vía Piedecuesta','Pública','Comercial'],
        [7.105608,-73.11353,'ACTIVO','Súper Cajasan Puerta del Sol','Cra. 27 Nº 61-78','Pública','Comercial'],
        [7.11462,-73.10942,'ACTIVO','Foto Japón Bucaramanga 2','Clle. 51 Nº 35-40 Local 23','Pública','Comercial'],
        [7.11647,-73.11109,'ACTIVO','Foto Japón Bucaramanga 6','Clle.  48 Nº 32-84','Pública','Comercial'],
        [7.06155,-73.11380,'ACTIVO','Ecoparque Empresarial Natura Torre 1','Km 2.176 ANILLO vía GIRON FLORIDABLANCA','Cerrada','Comercial'],
        [3.47862,-76.50161,'ACTIVO','Supermercado Torres de Comfandi','Cra.  1 Nº 56-20 ','Pública','Comercial'],
        [3.36909,-76.52781,'ACTIVO','CC. Jardín Plaza','Cra.  98 Nº 16-200','Pública','Comercial'],
        [3.44813,-76.53658,'ACTIVO','Comfenalco Valle','Clle.  5 Nº 6-63','Pública','Comercial'],
        [3.47706,-76.52747,'ACTIVO','Foto Japón CC. Chipichape','CC. CHIPICHAPE Local 111-12','Pública','Comercial'],
        [3.41447,-76.54692,'ACTIVO','Foto Japón CC. Cosmocentro','CC. Cosmocentro Local 208','Pública','Comercial'],
        [3.40628,-76.53916,'ACTIVO','Comfandi - Supermercado Guadalupe','Clle. 10 Nº 56-05','Pública','Comercial'],
        [3.37055,-76.53772,'ACTIVO','Pepe Ganga Ciudad Jardín','Pepe Ganga Ciudad Jardín   Cra. 100 Nº 12A-10','Pública','Comercial'],
        [3.36908,-76.52781,'ACTIVO','Foto Japón CC. Jardín Plaza','CC. JARDIN PLAZA Local 57','Pública','Comercial'],
        [3.45686,-76.52990,'ACTIVO','Torre de Cali Plaza Hotel ','Av. de las Américas Nº 18N-26','Pública','Comercial'],
        [3.46611,-76.52761,'ACTIVO','CC. La Pasarela Piso 1','Av. 5A Nº 23D-68','Pública','Comercial'],
        [3.46627,-76.52757,'ACTIVO','CC. La Pasarela Piso 2','Av. 5A Nº 23D-68','Pública','Comercial'],
        [3.46439,-76.53241,'ACTIVO','Fundación la FES','Av. 8 Norte Clle. 22AN-15','Pública','Comercial'],
        [6.34591,-75.50963,'ACTIVO','Groupe SEB Colombia','Clle. 50 Nº 53-107 Copacabana Antioquia','Cerrada','Comercial'],
        [4.77574,-74.14092,'ACTIVO','Colegio José Max León','vía Siberia Cota Km. 2.7 Parcelas 22-23','Cerrada','Comercial'],
        [4.82305,-75.69265,'ACTIVO','Nicole SAS','Clle.8 Nº 10-225 ZONA INDUSTRIAL LA POPA','Pública','Comercial'],
        [6.13393,-75.27439,'ACTIVO','Cornare Sede Principal','Autopista Medellín - Bogotá Km. 54 El Santuario Antioquia','Pública','Comercial'],
        [6.16425,-75.58649,'ACTIVO','Secretaría del Medio Ambiente y Desarrollo Rural ','Clle.  40B Sur Nº 37-24 Barrio el Dorado ','Pública','Comercial'],
        [6.17502,-75.58531,'ACTIVO','Consumo Envigado','Av. El Bosque  Nº 23-60 ','Pública','Comercial'],
        [6.16912,-75.61642,'ACTIVO','Éxito Itagüí','Cra. 50A Nº 41-42','Pública','Comercial'],
        [6.17314,-75.60864,'ACTIVO','Secretaría del Medio Ambiente Itagüí','Edificio Judicial 2do piso   Cra. 51 Nº 51-55 (Centro Administrativo Municipal de Itagüí)','Pública','Comercial'],
        [3.25831,-76.55688,'ACTIVO','La 14 Sede  Alfaguara','Clle.  2 Nº 22-175 Km. 2 vía Chipaya','Pública','Comercial'],
        [4.71987,-73.96852,'ACTIVO','Alcaldía Municipal de La Calera','Cra. 3A Nº 6-10 Parque Principal Palacio Municipal La Calera','Pública','Comercial'],
        [5.04971,-75.48080,'ACTIVO','Mabe','Cra. 21 Nº 74-100','Cerrada','Comercial'],
        [5.06166,-75.47991,'ACTIVO','Colegio Nuestra Señora de Fátima','Clle. 63 Nº 13-23 Barrio Viveros','Cerrada','Comercial'],
        [5.05867,-75.47880,'ACTIVO','Escuela de Carabineros Alejandro Gutiérrez','Cra. 12A Nº 64C-67 Barrio La Toscana','Cerrada','Comercial'],
        [5.06224,-75.49884,'ACTIVO','CONFAMILIARES Sede Principal','Cra. 25 Clle. 50 Esquina','Pública','Comercial'],
        [5.03519,-75.46918,'ACTIVO','CONFAMILIARES Sede San Marcel','Cra. 30 Nº 93-25 Av. Alberto Mendoza','Pública','Comercial'],
        [5.04773,-75.53064,'ACTIVO','CHEC - Estación Uribe','Km. 2 Autopistas del Café','Pública','Comercial'],
        [5.06811,-75.51032,'ACTIVO','Clle. 33B Nº 20-03 CC. Fundadores Local 140','Cra. 23 Nº 21-61','Pública','Comercial'],
        [5.06034,-75.48767,'ACTIVO','Universidad Católica','Cra. 23 Nº 60-63','Pública','Comercial'],
        [5.04786,-75.48194,'ACTIVO','CI INVERMEC S.A. Zona Industrial Alta Suiza','Cra. 22 Nº 75-111 Zona Industrial Alta Suiza','Cerrada','Comercial'],
        [5.05244,-75.48263,'ACTIVO','Efigas-Manizales','Av. Kevin Ángel Nº 70-70','Pública','Comercial'],
        [6.20495,-75.57972,'ACTIVO','Industrias Haceb - Sala Exhibición ','Autopista Sur Nº 1-21 ','Cerrada','Comercial'],
        [6.22682,-75.56849,'ACTIVO','Vestimundo S.A. ','Clle. 29 Nº 43A- 01','Cerrada','Comercial'],
        [6.19000,-75.56508,'ACTIVO','Consumo Poblado','Clle. 9 SUR Nº 29 D-76','Pública','Comercial'],
        [6.22737,-75.60232,'ACTIVO','Consumo Belén','Cra. 81 Nº 25-35','Pública','Comercial'],
        [6.24996,-75.60040,'ACTIVO','Consumo América','Clle. 44 Nº 80-61','Pública','Comercial'],
        [6.25452,-75.59893,'ACTIVO','Consumo Floresta','Cra. 84 Nº 45F-12','Pública','Comercial'],
        [6.26287,-75.58902,'ACTIVO','Consumo los Colores','Cra. 74 Nº 52-100','Pública','Comercial'],
        [6.27311,-75.59390,'ACTIVO','Éxito Robledo','Cra. 12A Nº 22-13 Entrada Principal San Jerónimo','Pública','Comercial'],
        [6.23506,-75.56972,'ACTIVO','Éxito San Diego','Cra. 80 Nº 64-61','Pública','Comercial'],
        [6.18870,-75.59780,'ACTIVO','CC. PLATIN PLAZA- Zona de las Burbujas','Clle.  34 Nº 43-66','Pública','Comercial'],
        [6.24867,-75.55869,'ACTIVO','Colegio El Sufragio','Cra.  52D Nº 76-67','Cerrada','Comercial'],
        [6.17062,-75.59654,'ACTIVO','Sofasa','Cra. 39  Nº 54-31','Cerrada','Comercial'],
        [6.22421,-75.57981,'ACTIVO','Parque Zoológico Santa Fe','Cra. 49 Nº 39 Sur-100 Envigado ','Pública','Comercial'],
        [6.27878,-75.63386,'ACTIVO','I.E. Juan J. Escobar','Cra.  52 Nº 20-63','Cerrada','Comercial'],
        [4.70396,-74.22965,'ACTIVO','Centro de Desarrollo Integral','Cra. 1 Nº 2-01','Pública','Comercial'],
        [4.70521,-74.23020,'ACTIVO','Alcaldía Municipal de Mosquera','Cra. 2 Nº 2-68 Parque Principal','Pública','Comercial'],
        [3.52412,-76.30461,'ACTIVO','Supermercado estación comfandi','Cra. 33A Nº 26-98','Pública','Comercial'],
        [3.51179,-76.30675,'ACTIVO','Universidad Nacional Sede Palmira','Cra. 32  Nº 12-00 Vía a Candelaria','Pública','Comercial'],
        [4.80722,-75.68138,'ACTIVO','Multidrogas Comfamiliar','Av. Circunvalar Nº 3B-30','Pública','Comercial'],
        [4.79559,-75.69060,'ACTIVO','Universidad Tecnológica de Pereira','La Julita','Pública','Comercial'],
        [2.64556,-75.97274,'ACTIVO','Coats Cadena Andina S.A.','Av. Santander Nº 5E-87','Cerrada','Comercial'],
        [4.81364,-75.69257,'ACTIVO','Éxito Pereira Centro','Cra. 8A Nº 17-35/47','Pública','Comercial'],
        [4.90664,-75.89594,'ACTIVO','Ingenio Risaralda','Km. 2 vía La Virginia - Balboa.  Risaralda ','Cerrada','Comercial'],
        [4.81197,-75.70558,'ACTIVO','Efigas-Pereira','Av. 30 de Agosto Nº 32B-41','Pública','Comercial'],
        [4.81050,-75.68009,'ACTIVO','Centro Logístico Eje Cafetero','Clle. 1ra Nº 10W-151','Cerrada','Comercial'],
        [6.17633,-75.34606,'ACTIVO','Groupe SEB Colombia','Km. 40 Autopista Medellín-Bogotá, Vereda Galicia','Cerrada','Comercial'],
        [6.14844,-75.37815,'ACTIVO','Éxito Rionegro','Clle. 43 Av. Galán con Cra. 56C ','Pública','Comercial'],
        [6.16903,-75.42561,'ACTIVO','Fuerza Aérea Colombiana CACOM N05','Vereda la Bodega - Rionegro Antioquia','Pública','Comercial'],
        [6.15030,-75.36637,'ACTIVO','Universidad Católica de Oriente','Sector 3 Cra. 46 Nº 40B-50','Pública','Comercial'],
        [6.15316,-75.37386,'ACTIVO','Alcaldía Municipal de Rionegro','Clle. 49 Nº 50-05','Pública','Comercial'],
        [6.15063,-75.61633,'ACTIVO','Alcaldía de Sabaneta','Cra. 45 Nº 71 Sur-24','Pública','Comercial'],
        [6.16053,-75.60541,'ACTIVO','Fabrica de Calcetines Crystal S.A.','Cra. 48 Nº 52 Sur-81 Av. las Vegas','Cerrada','Comercial'],
        [4.49201,-74.25975,'ACTIVO','Alcaldía de Sibaté','Clle. 10 Nº 8-01 Parque Principal','Pública','Comercial'],
        [4.95271,-73.96417,'ACTIVO','Bavaria-Tocancipá','Km. 37 Autopista Norte Tocancipá','Cerrada','Comercial'],
        [4.96195,-73.91807,'ACTIVO','Sika Colombia - Tocancipá','Km. 20.5 Autopista Norte Vereda Canavita','Cerrada','Comercial'],
        [3.58375,-76.49475,'ACTIVO','Secretaría de salud','Clle. 6 Nº 4-69','Pública','Comercial'],
        [5.04013,-73.99294,'ACTIVO','Algarra ','Km. 4 Vía Zipaquirá Cogua','Cerrada','Comercial'],
        [4.68562,-74.07502,'ACTIVO','Foto Japón Cafam Floresta','Av. Cra. 68 Nº 90-88 Local 165','Pública','Comercial'],
        [4.86557,-74.03648,'ACTIVO','Carulla Centro Chía','Av. Pradilla 900 Este Local 1029 / 31','Pública','Comercial'],
        [6.16912,-75.58851,'ACTIVO','Oficina de atención al cliente  - EPM Envigado ','Cra. 43 N° 38A Sur 31','Pública','Comercial'],
        [4.96581,-73.91367,'ACTIVO','Alcaldía Municipal de Tocancipá','Clle. 11 N° 6-12','Pública','Comercial'],
        [4.73240,-74.06929,'ACTIVO','Colegio San Luis ','Av. Boyacá 142A- 55','Cerrada','Comercial'],
        [4.59018,-74.13520,'ACTIVO','Colegio Nuestra Señora de Fátima','Diag. 49 N° 48-71 Sur','Cerrada','Comercial'],
        [4.70156,-74.11209,'ACTIVO','Colegio Elisa Borrero de Pastrana','Calle 72 N° 94A-05','Cerrada','Comercial'],
        [4.67907,-74.10918,'ACTIVO','Centro Social de Suboficiales y Nivel Ejecutivo CESNE','Av. Clle. 63 N° 77-13 ','Cerrada','Comercial'],
        [4.65692,-74.10310,'ACTIVO','Centro Social de Agentes y Patrulleros CESAP','Diag. 44 N° 68B- 30  ','Cerrada','Comercial'],
        [4.59765,-74.08480,'ACTIVO','Policía Metropolitana de Bogotá','Av. Caracas N° 6-05 Piso 4','Cerrada','Comercial'],
        [4.62913,-74.11320,'ACTIVO','Departamento de Policía Cundinamarca','Cra. 58 N° 9 - 43 Puente Aranda','Cerrada','Comercial'],
        [4.64757,-74.09794,'ACTIVO','Dirección Administrativa y Financiera Policía Nal.','Cra. 59 N° 26-21 CAN','Cerrada','Comercial'],
        [4.73240,-74.06929,'ACTIVO','Dirección de Inteligencia Policial','Av. Boyacá N° 142 A-55 ','Cerrada','Comercial'],
        [4.70345,-74.14964,'ACTIVO','Dirección de Antinarcóticos','Base Aérea El Dorado Entrada 6','Cerrada','Comercial'],
        [4.64290,-74.09150,'ACTIVO','Dirección de Sanidad Policial ','Clle. 44 N° 50-51 ','Cerrada','Comercial'],
        [4.59277,-74.13123,'ACTIVO','Dirección  Nacional de Escuelas','Tr. 33 N° 47A-35 Sur, Barrio Fátima Complejo Muzú ','Cerrada','Comercial'],
        [4.64290,-74.09150,'ACTIVO','Dirección de Bienestar Social','Clle. 44 N° 50-51 Piso 4','Cerrada','Comercial'],
        [4.59276,-74.13124,'ACTIVO','Escuela de Cadetes de Policía General Francisco de Paula Santander','Clle. 44 Sur N° 45A-15 ','Cerrada','Comercial'],
        [4.73240,-74.06929,'ACTIVO','Escuela de Postgrados de Policía Miguel Antonio Lleras Pizarro','Av. Boyacá N° 142A-55 ','Cerrada','Comercial'],
        [4.61954,-74.15940,'ACTIVO','Comando Operativo Kennedy','Clle. 41D Sur N°78N-05','Cerrada','Comercial'],
        [4.74011,-74.08523,'ACTIVO','Comando Operativo Suba','Cra. 92 N° 146-49','Cerrada','Comercial'],
        [4.63276,-74.06076,'ACTIVO','Comando Operativo Chapinero','Cra. 2 N° 56-40','Cerrada','Comercial'],
        [4.58948,-74.19500,'ACTIVO','Estación de Policía Soacha','Clle. 40 N° 6 F-40 Soacha','Cerrada','Comercial'],
        [4.82595,-74.34220,'ACTIVO','Escuela Nacional de Carabineros Alfonso López Pumarejo','Km. 4 Vía Ecopetrol Vereda Mancilla Hacienda Las Margaritas Facatativá','Cerrada','Comercial'],
        [4.72147,-74.28149,'ACTIVO','Escuela de Suboficiales y Nivel Ejecutivo Gonzalo Jiménez de Quesada','Km. 20, Vía Sibaté','Cerrada','Comercial'],
        [4.81658,-75.71247,'ACTIVO','Colegio Nuestra Señora de Fátima','Cra. 7 N° 40-55','Cerrada','Comercial'],
        [4.80565,-75.71790,'ACTIVO','Policía Metropolitana','Av. de las Américas N° 46-35','Cerrada','Comercial'],
        [4.81754,-75.69855,'ACTIVO','Departamento de Policía','Cra. 4 Bis N° 24-39 Barrio San Jorge','Cerrada','Comercial'],
        [6.30494,-75.56254,'ACTIVO','Escuela de Policía Carlos Holguín Mallarino ESCOL','Clle. 111A N° 64C-35, Barrio las Brisas ','Cerrada','Comercial'],
        [6.24695,-75.56492,'ACTIVO','Policía Metropolitana del Valle de Aburrá','Clle. 48 N° 45-58 ','Cerrada','Comercial'],
        [6.26998,-75.57658,'ACTIVO','Departamento de Policía','Clle. 71 N° 65-20 Barrio El Volador','Cerrada','Comercial'],
        [6.31145,-75.55260,'ACTIVO','Colegio Santo Domingo de Guzmán','Cra. 45 N°  22D-184 Bello','Cerrada','Comercial'],
        [10.38185,-75.46546,'ACTIVO','Colegio Nuestra Señora de Fátima','Diag.  31 N° 85-158 Barrio Ternera ','Cerrada','Comercial'],
        [10.40879,-75.53685,'ACTIVO','Policía Metropolitana','Clle. Real N° 24-03, Barrio La Manga','Cerrada','Comercial'],
        [10.39150,-75.48655,'ACTIVO','Departamento de Policía','Barrio Blas de Lezo Manzana 10 Local 13','Cerrada','Comercial'],
        [10.98367,-74.78836,'ACTIVO','Policía Metropolitana','Cra. 43 N° 47-53','Cerrada','Comercial'],
        [10.92746,-74.79003,'ACTIVO','Escuela de Policía Antonio Nariño','Av. Circunvalar N° 45-30 ','Cerrada','Comercial'],
        [10.92926,-74.77869,'ACTIVO','Colegio Nuestra Señora de Fátima','Clle. 32 N°30-152 ','Cerrada','Comercial'],
        [10.91511,-74.81882,'ACTIVO','Departamento de Policía','Clle. 81 N° 14-33','Cerrada','Comercial'],
        [7.11596,-73.12849,'ACTIVO','Colegio Nuestra Señora de Fátima ','Cra. 12 No. 41-25-31 ','Cerrada','Comercial'],
        [7.11587,-73.12936,'ACTIVO','Policía Metropolitana','Clle. 41  N° 11-44','Cerrada','Comercial'],
        [7.12840,-73.12479,'ACTIVO','Departamento de Policía Santander','Clle. 20 N° 20-52 San Francisco ','Cerrada','Comercial'],
        [4.91933,-74.01542,'ACTIVO','Groupe SEB Colombia','Km. 1 Vía Cajicá- Zipaquirá','Cerrada','Comercial'],
        [4.69646,-74.07052,'ACTIVO','Telefónica - Sede Morato','Tr. 60 N° 114A-55','Cerrada','Comercial'],
        [3.52772,-76.31615,'ACTIVO','La 14 Sede  Palmira','Clle. 31 N°44-23 Km. 2 Vía las Palmas','Pública','Comercial'],
        [3.48398,-76.50320,'ACTIVO','Colegio Nuestra Señora de Fátima','Clle. 62N  N° 6N-31','Cerrada','Comercial'],
        [3.46084,-76.52754,'ACTIVO','Policía Metropolitana','Clle. 21  N° 1N-65','Cerrada','Comercial'],
        [3.46084,-76.52754,'ACTIVO','Departamento de Policía','Clle. 21 N° 1N-65','Cerrada','Comercial'],
        [4.64442,-74.09573,'ACTIVO','FFMM Edificio Ejército','Av. el Dorado CAN Cra. 54 N° 26-25','Cerrada','Comercial'],
        [4.64442,-74.09573,'ACTIVO','FFMM Edificio de Fuerza Aérea','Av. el Dorado CAN Cra. 54 N° 26-25','Cerrada','Comercial'],
        [4.64442,-74.09573,'ACTIVO','FFMM Edificio Comando General','Av. el Dorado CAN Cra. 54 N° 26-25','Cerrada','Comercial'],
        [4.58441,-74.20627,'ACTIVO','Centro Comercial Unisur','Cra. 3A N° 29A-02 Autopista Sur','Pública','Comercial'],
        [4.70983,-74.22711,'ACTIVO','Parque Cultural - Auditorio Municipal','Clle. 10 con Cra. 3ra Esquina','Pública','Comercial'],
        [4.62987,-74.10410,'ACTIVO','Cantón Caldas 1','Cra. 50 N° 18-06 Edificio Sabio Caldas Sexto Piso (por la Guardia de la PM13)','Cerrada','Comercial'],
        [4.62987,-74.10410,'ACTIVO','Cantón Caldas 2','Cra. 50 N° 18-06 Edificio Sabio Caldas Sexto Piso (por la Guardia de la PM13)','Cerrada','Comercial'],
        [12.58104,-81.70511,'ACTIVO','Centro Comercial New Point Plaza','Av. Providencia Nº 1-35 Edificio New Point','Pública','Comercial'],
        [12.57861,-81.69983,'ACTIVO','Supermercado Ganatiendas','Av. 20 de Julio Nº 8-80 ','Pública','Comercial'],
        [11.24087,-74.21485,'ACTIVO','Departamento de Policía Magdalena','Clle. 22 Nº 1C-74 Santa Marta ','Cerrada','Comercial'],
        [4.24668,-75.01014,'ACTIVO','CENOP San Luis','Vereda La Laguna, Hacienda Los Pijaos, San Luís (Tolima)','Cerrada','Comercial'],
        [4.33107,-74.39322,'ACTIVO','Escuela de Patrulleros Provincia de Sumapaz','Clle. 19 Nº 50-24, Barrio La Gran Colombia','Cerrada','Comercial'],
        [3.43545,-76.51941,'ACTIVO','Comfandi Prado','Cra. 23 N° 26B-46','Pública','Comercial'],
        [4.86124,-74.03370,'ACTIVO','Universidad de la Sabana','Km. 7 de la Autopista Norte','Pública','Comercial'],
        [4.62565,-74.08259,'ACTIVO','Secretaria Distrital de la Hacienda','Cra. 30 Nº 25-90','Pública','Comercial'],
        [6.33529,-75.55863,'ACTIVO','Secretaría del Medio Ambiente','Edificio de la Alcaldía - Cra. 50 Nº 51-00','Pública','Comercial'],
        [4.91663,-74.02531,'ACTIVO','Alcaldía Municipal de Cajicá','Clle. 2 Nº 04-07','Pública','Comercial'],
        [3.46486,-76.50092,'ACTIVO','Foto Japón CC. UNICO','CC. UNICO  L 207','Pública','Comercial'],
        [6.14690,-75.37850,'ACTIVO','C.C. San Nicolás (Regional Valles de San Nicolás Cornare)','Clle. 43 N° 54-139','Pública','Comercial'],
        [1.20625,-77.28583,'ACTIVO','Éxito Pasto Panamericana','Clle. 2 Nº 22B-96','Pública','Comercial'],
        [1.21748,-77.27986,'ACTIVO','Éxito Pasto Centro','Clle. 18 Nº 26-40','Pública','Comercial'],
        [7.05752,-73.09122,'ACTIVO','Fundación Colegio UIS','Autopista Floridablanca, vía Ruitoque bajo Nº 27-240','Pública','Comercial'],
        [4.70265,-74.04242,'ACTIVO','Foto Japón C.C. UNICENTRO','Cra. 15 Nº 123-30 L-275','Pública','Comercial'],
        [11.24632,-74.21112,'ACTIVO','Carulla Arrecife','Cra. 4 N° 11A-119','Pública','Comercial'],
        [11.23192,-74.19977,'ACTIVO','Foto Japón Santa Marta Ocean Mail','Av.  del Rio con Av. del Ferrocarril Local 19 Piso 1','Pública','Comercial'],
        [4.53432,-75.67417,'ACTIVO','Foto Japón Armenia 1','Cra. 17 Nº 20-61','Pública','Comercial'],
        [4.89964,-74.03643,'ACTIVO','Colegio Mayor de los Andes','Km. 3 vía Chía - Cajicá','Cerrada','Comercial'],
        [7.07359,-73.11036,'ACTIVO','Fundación Oftalmológica de Santander Foscal ','Av. El Bosque Nº 23-60 ','Cerrada','Comercial'],
        [4.80956,-75.67951,'ACTIVO','Agroavícola San Marino ','Clle. 1A Nº 10W-151 Barrio Pedregales','Cerrada','Comercial'],
        [4.97262,-74.00341,'ACTIVO','Brinsa','Km. 6 vía Cajicá - Zipaquirá','Cerrada','Comercial'],
        [4.81811,-74.35822,'ACTIVO','Centro Comercial Pórtico','Cra. 5 Nº 13-50','Pública','Comercial'],
        [4.80749,-75.71892,'ACTIVO','Corporación Autónoma Regional del Risaralda CARDER','Av. las Américas Nº 46-40 ','Pública','Comercial'],
        [10.31771,-75.50133,'ACTIVO','Propilco','Zona Industrial Mamonal Km. 8','Cerrada','Comercial'],
        [3.45057,-76.53617,'ACTIVO','Edificio Banco de Occidente ','Cra. 4 N° 7-61  ','Pública','Comercial'],
        [4.85056,-74.06407,'ACTIVO','Servicio de Audiología Starkey','Cra.10 Nº 0-49 L- 201  Centro Comercial Vivenza','Pública','Mini-contenedor'],
        [4.66784,-74.09982,'ACTIVO','Jardín Botánico José celestino Mutis','Av. Clle. 63 Nº 68-95','Pública','Comercial'],
        [4.68261,-74.05755,'ACTIVO','Compañía de Seguros Positiva','Autopista Norte Nº 94-72','Pública','Comercial'],
        [4.62864,-74.11292,'ACTIVO','Bayer S.A.','Cra. 58 N° 10-76','Cerrada','Comercial'],
        [4.65669,-74.05759,'ACTIVO','LIBERTY SEGUROS','Clle. 72 Nº 10-07 Piso 7','Pública','Comercial'],
        [4.62502,-74.07777,'ACTIVO','Concejo Bogotá','Clle. 36 Nº 28A-41','Pública','Comercial'],
        [4.62382,-74.06650,'ACTIVO','Corporación Autónoma Regional De Cundinamarca ','Cra. 7 N° 36-45','Pública','Comercial'],
        [4.67911,-74.04801,'ACTIVO','Starkey Laboratories Colombia Ltda.','Cra. 13 Nº 94A-25 Oficina 504','Pública','Mini-contenedor'],
        [4.64722,-74.09731,'ACTIVO','Hospital Central del Policía ','Cra.59 Nº 26-21 CAN','Pública','Mini-contenedor'],
        [4.64723,-74.09729,'ACTIVO','Hospital Central del Policía ','Tr. 45 Nº 40-13 CAN','Pública','Mini-contenedor'],
        [4.65009,-74.06060,'ACTIVO','Claudia Forero','Clle. 65 Nº 9-23 Consultorio 103','Pública','Mini-contenedor'],
        [4.70684,-74.05207,'ACTIVO','Clínica Reina Sofía','Av. Clle. 127 Nº 21-60 Consultorio 305','Pública','Mini-contenedor'],
        [4.67751,-74.04881,'ACTIVO','Claudia Londoño ','Clle. 93 B Nº 13-92 Consultorio 401 ','Pública','Mini-contenedor'],
        [4.64295,-74.07749,'ACTIVO','Centro Audioprotésico ','Clle. 53 Nº 28-18 Galerías','Pública','Mini-contenedor'],
        [9.30266,-75.39705,'ACTIVO','Diana Rodríguez','Clle. 21 Nº 16-11 La Pajuela  Consultorio 3B','Pública','Mini-contenedor'],
        [8.75430,-75.88790,'ACTIVO','Diana Rodríguez','Clle. 25 Nº 3-14','Pública','Mini-contenedor'],
        [5.06407,-75.49804,'ACTIVO','Bertha Villegas ','Centro Médico Plaza 51','Pública','Mini-contenedor'],
        [5.06007,-75.49117,'ACTIVO','María Claudia Monsalve','Cra. 24 Nº 56-50 Clínica Santillana','Pública','Mini-contenedor'],
        [4.81543,-75.69318,'ACTIVO','Luz Marina Coy','Cra. 6 Nº 18-46 consultorio 302','Pública','Mini-contenedor'],
        [4.81638,-75.69400,'ACTIVO','clínica y Boutique de la Audición','Clle. 19 Nº 5-13 consultorio 806A','Pública','Mini-contenedor'],
        [6.25133,-75.56380,'ACTIVO','Audiología Carmenza Gómez','Clle. 54 Nº 46-27 Consultorio 1304','Pública','Mini-contenedor'],
        [6.24886,-75.56584,'ACTIVO','Centro Médico Otológico','Clle. 51 Nº 45-93 clínica Soma Cons. 107','Pública','Mini-contenedor'],
        [6.21349,-75.59634,'ACTIVO','Myriam Patricia Montes ','Diag. 75B No 2A-80 Cons. 304','Pública','Mini-contenedor'],
        [6.24987,-75.60256,'ACTIVO','Fundación Prodebiles ','Clle. 43B Nº 81-95','Pública','Mini-contenedor'],
        [6.26067,-75.56506,'ACTIVO','Institución prestadora de Salud','Cra. 51A Nº 62-42 Piso 2','Pública','Mini-contenedor'],
        [10.39277,-75.48001,'ACTIVO','Servicios Fonoaudiológicos del Caribe ','Barrio Santa Lucía Manzana F Lote 18','Pública','Mini-contenedor'],
        [10.39277,-75.48001,'ACTIVO','Servicios Fonoaudiológicos del Caribe ','Centro Médico Los Ejecutivos Consultorio 301','Pública','Mini-contenedor'],
        [4.65943,-74.10830,'ACTIVO','Edificio Bogotá Corporate Center','Av. Clle. 26 Nº 69B-45','Cerrada','Comercial'],
        [6.18143,-75.56953,'ACTIVO','Carulla San Lucas','Clle. 20 sur Nº 27-124','Pública','Comercial'],
        [6.19769,-75.57493,'ACTIVO','Carulla Oviedo','Cra. 43 B Nº 6 Sur-140','Pública','Comercial'],
        [6.19827,-75.56559,'ACTIVO','Carulla La Visitación','Cra.32 A Nº 2 Sur-55','Pública','Comercial'],
        [6.24482,-75.59457,'ACTIVO','Carulla Laureles','Tr. 39 B Nº 73B-22','Pública','Comercial'],
        [6.21759,-75.56502,'ACTIVO','Carulla Palmas','Clle. 18 Nº 35-69','Pública','Comercial'],
        [6.28581,-75.55545,'ACTIVO','Éxito Aranjuez','Clle. 94 Nº 98-13','Pública','Comercial'],
        [6.24634,-75.60176,'ACTIVO','Éxito Laureles','Cra. 81 Nº 37-100','Pública','Comercial'],
        [6.25124,-75.59976,'ACTIVO','Éxito La América','Cra. 79B Nº 45-90','Pública','Comercial'],
        [6.24666,-75.56630,'ACTIVO','Éxito San Antonio','Clle. 48 Nº 46-115','Pública','Comercial'],
        [6.14931,-75.61782,'ACTIVO','Éxito Sabaneta','Cra. 44 Nº 74A Sur-62','Pública','Comercial'],
        [4.68547,-74.03674,'ACTIVO','AFEAU-CANTON NORTE','Cra. 7ª Clle. 106-10  ','Cerrada','Comercial'],
        [4.81405,-75.69778,'ACTIVO','Cámara de Comercio de Pereira','Cra. 8 Nº 23-09 Local 10','Cerrada','Comercial'],
        [6.16704,-75.56931,'ACTIVO','Consumo Terracina','Cra. 27 Nº 35 Sur-180','Pública','Comercial'],
        [6.30142,-75.57229,'ACTIVO','Consumo Pedregal','Cra.74 Nº 104-4','Pública','Comercial'],
        [6.15284,-75.37518,'ACTIVO','Consumo Rionegro','Cra. 51Nº 48-35','Pública','Comercial'],
        [6.32345,-75.56078,'ACTIVO','Consumo Niquia','Av. 38 Nº 55-80','Pública','Comercial'],
        [4.78233,-74.05421,'ACTIVO','Colegio Los Nogales','Clle. 202 Nº 56-50 ','Cerrada','Comercial'],
        [4.75594,-74.06123,'ACTIVO','Colegio Abraham Lincoln Sede Bachillerato','Av. Clle. 170 Nº 65-31','Cerrada','Comercial'],
        [4.59438,-74.07832,'ACTIVO','Ministerio de Hacienda','Cra. 7A N° 6-45','Pública','Comercial'],
        [4.56968,-74.10439,'ACTIVO','Colegio El Carmen Teresiano','Cra.11A Nº 32-64 Sur','Cerrada','Comercial'],
        [4.65131,-74.07538,'ACTIVO','Colegio Nuestra Señora del Pilar  ','Clle. 62 Nº 27A-12','Cerrada','Comercial'],
        [4.65342,-74.14515,'ACTIVO','Colegio Agustiniano Tagaste','Cra. 88 Nº 11A-21','Cerrada','Comercial'],
        [4.65397,-74.05563,'ACTIVO','Edificio Carrera Séptima','Cra. 7 Nº 71-52','Pública','Comercial'],
        [4.64369,-74.11948,'ACTIVO','INVIMA','Cra. 68D Nº 17-11/21','Pública','Comercial'],
        [7.13050,-73.10967,'ACTIVO','Empresa de Acueducto de Bucaramanga -  Parque del  Agua','Diag. 32 Nº 30A-51 Parque del Agua','Pública','Comercial'],
        [4.68717,-74.05167,'ACTIVO','Centro Médico Otológico José A. Rivas S.A.','Av. 19 Nº 100-88','Pública','Mini-contenedor'],
        [4.68717,-74.05167,'ACTIVO','Centro Médico Otológico José A. Rivas S.A.','Av. 19 Nº 100-88','Pública','Mini-contenedor'],
        [4.63718,-74.07281,'ACTIVO','Audiosalud Integral - Palermo','Tr. 21 Nº 47-76  ','Pública','Mini-contenedor'],
        [4.61681,-74.15524,'ACTIVO','Audiosalud Integral - Av. 1º de Mayo','Av. 1º de Mayo Nº 40G-35 Sur Diagonal al Hospital Kennedy ','Pública','Mini-contenedor'],
        [4.69609,-74.03269,'ACTIVO','Audiosalud Integral - Medical Center','Clle. 119 Nº 7-14  Consultorio 301','Pública','Mini-contenedor'],
        [5.02373,-74.00016,'ACTIVO','Audiosalud Integral - Zipaquirá','Cra.11 Nº 7-13 ','Pública','Mini-contenedor'],
        [3.37526,-76.53372,'ACTIVO','Universidad del Valle - Sede Meléndez','Clle. 13 Nº 100-00 ','Pública','Comercial'],
        [3.52825,-76.31728,'ACTIVO','C.C. LLANOGRANDE PLAZA','Km. 2 vía Las Palmas, Palmira','Pública','Comercial'],
        [4.67919,-74.04502,'ACTIVO','Indra Company Calle 96','Clle. 96 Nº 13-11 Chicó','Pública','Comercial'],
        [4.74111,-74.08424,'ACTIVO','Dirección Local de Educación Suba','Cra. 91 Nº 146C-29','Pública','Comercial'],
        [4.54397,-75.66147,'ACTIVO','Nora Stella Pérez','Cra. 12 Nº 0-75 Consultorio 507 clínica Del café','Pública','Mini-contenedor'],
        [0.82359,-77.63702,'ACTIVO','Patricia Esther Moran ','Clle. 12A Nº 7-12 Oficina 3 Edificio la Sultana','Pública','Mini-contenedor'],
        [7.11363,-73.11232,'ACTIVO','Audiomic','Clle. 51A Nº 31-18','Pública','Mini-contenedor'],
        [2.45195,-76.59829,'ACTIVO','Centro de Audición y Lenguaje ','Clle. 16 Norte Nº 6-27 Consultorio 303','Pública','Mini-contenedor'],
        [3.42564,-76.54472,'ACTIVO','Proaudio ','Cra. 38 A Nº 5A-100 Consultorio 317 Torre A','Pública','Mini-contenedor'],
        [3.42412,-76.54399,'ACTIVO','Instituto Ciegos y Sordos de Cali','Cra. 38 Nº 5B 1-39 Piso 2','Pública','Mini-contenedor'],
        [5.34887,-72.39850,'ACTIVO','Consultorio Fonoaudiológico','Cra. 22 Nº 9-28 Consultorios  204-302','Pública','Mini-contenedor'],
        [10.99406,-74.81446,'ACTIVO','Te oigo Centro Auditivo','Cra. 42F Nº 79-76 Local  3','Pública','Mini-contenedor'],
        [2.68288,-75.32567,'ACTIVO','Cenaudio','Cra. 9 Nº 16-16','Pública','Mini-contenedor'],
        [3.55840,-76.38543,'ACTIVO','Zona Franca Permanente Palmaseca','Contiguo Aeropuerto Alfonso Bonilla Aragón','Cerrada','Comercial'],
        [6.27439,-75.58863,'ACTIVO','Instituto Tecnológico Metropolitano','Clle. 73 N° 76A-35','Pública','Comercial'],
        [6.24100,-75.59643,'ACTIVO','Fundación Universitaria Autónoma de las Américas','Circular 73 N° 35-04  ','Pública','Comercial'],
        [3.44930,-76.53492,'ACTIVO','CANDEASEO S.A.E.S.P.','Cra. 6 Nº 8-30','Pública','Comercial'],
        [4.63822,-74.08436,'ACTIVO','Universidad Nacional de Colombia','Cra.  45 Nº 26-85 Edificio Uriel Gutiérrez of. 323','Pública','Comercial'],
        [4.76584,-74.05557,'ACTIVO','Colegio Stella Matutina de Bogotá','Cra. 67 Nº 180-88. ','Cerrada','Comercial'],
        [4.80868,-74.07087,'ACTIVO','Colegio Gimnasio Colombo Británico','Costado sur del Aeropuerto de Guaymaral','Cerrada','Comercial'],
        [4.92832,-73.95634,'ACTIVO','Corona-Parque Industrial Sopó','Km. 2 Vía Briceño-Sopó','Cerrada','Comercial'],
        [6.16192,-75.60537,'ACTIVO','C.C. Mayorca','Clle. 51 Sur Nº 48-57','Pública','Comercial'],
        [11.01676,-74.87345,'ACTIVO','Universidad del Atlántico','Km. 7 antigua vía Puerto Colombia ','Pública','Comercial'],
        [10.40093,-75.51624,'ACTIVO','Aguas de Cartagena',' Tr. 45 Nº 26-160 Barrio Paraguay','Pública','Comercial'],
        [1.22468,-77.28994,'ACTIVO','VERDEEN S.A.S','Cra. 43Nº 16A - 19','Pública','Comercial'],
        [4.67473,-74.04840,'ACTIVO','Edificio Capital Park ','Clle. 93 Nº 11A-28','Pública','Comercial'],
        [4.62713,-74.06304,'ACTIVO','Universidad Javeriana','Cra. 7 Nº 40-62','Pública','Comercial'],
        [4.62713,-74.06304,'ACTIVO','Universidad Javeriana','Cra. 7 Nº 40-62','Pública','Comercial'],
        [6.26717,-75.56915,'ACTIVO','Universidad de Antioquia','Clle. 67 Nº 53-108 Bloque 18-215','Pública','Comercial'],
        [3.47098,-76.52935,'ACTIVO','Parques Nacionales Naturales-Dirección Territorial Pacifico','Clle. 29 Norte Nº 6N-43','Pública','Comercial'],
        [3.41227,-76.54068,'ACTIVO','C.C. Palmetto Plaza','Clle. 9 Nº 48-51','Pública','Comercial'],
        [4.61575,-74.09403,'ACTIVO','Secretaria Distrital de Salud','Cra.  32 Nº 12-81','Pública','Comercial'],
        [6.17711,-75.58429,'ACTIVO','Corporación Educativa Colombo Británico- Envigado','Tr. 31 Sur Nº 32D-02','Cerrada','Comercial'],
        [5.06334,-75.48551,'ACTIVO','Sede Administrativa Aguas de Manizales','Av. kevin Ángel N° 59-181','Pública','Comercial'],
        [3.46176,-76.50407,'ACTIVO','Reckitt Benckiser ','Clle. 46 N° 5-76','Pública','Comercial'],
        [4.68027,-74.08250,'ACTIVO','C.C. Metrópolis','Av. Cra. 68 Nº 75A-50','Pública','Comercial'],
        [4.66604,-74.05141,'ACTIVO','Edificio Protección','Av. 82 Nº 10-50','Pública','Comercial'],
        [4.69382,-74.03419,'ACTIVO','Edificio Torre Cusezar','Clle. 116 N° 7-15','Pública','Comercial'],
        [4.65883,-74.05294,'ACTIVO','Edificio Q.B.E Central de Seguros','Cra. 7 Nº 76-35','Pública','Comercial'],
        [4.61476,-74.07157,'ACTIVO','Edificio Bulevar Tequendama','Clle. 26A Nº 13-97','Pública','Comercial'],
        [4.61830,-74.08595,'ACTIVO','Calima Centro Comercial','Clle. 19 Nº 28-80','Pública','Comercial'],
        [3.46702,-76.51017,'ACTIVO','Colgate Palmolive CIA ','Cra.1 Nº 40-108','Cerrada','Comercial'],
        [7.12103,-73.11490,'ACTIVO','Instituto del Corazón - Sede Ambulatoria','Cra. 28 Nº 40-11','Pública','Comercial'],
        [4.44257,-75.23833,'ACTIVO','Foto Japón Ibagué 4','Cra.3 Nº 14A-19','Pública','Comercial'],
        [4.75909,-74.15199,'ACTIVO','COPIDROGAS','Autopista Bogotá - Medellín km. 4,7','Pública','Comercial'],
        [4.59554,-74.07755,'ACTIVO','Presidencia de la República ','Clle. 7 Nº 6-54','Cerrada','Comercial'],
        [4.67355,-74.14386,'ACTIVO','Alcaldía Local de Fontibón','Cra. 99 Nº 18 -02','Pública','Comercial'],
        [4.66619,-74.05451,'ACTIVO','El  Retiro Centro Comercial ','Clle. 82 Nº 11-75 ','Pública','Comercial'],
        [6.27314,-75.59115,'ACTIVO','Colegio Mayor de Antioquia','Cra. 78 Nº 65-46','Pública','Comercial'],
        [4.62105,-74.07306,'ACTIVO','Compensar Unipanamericana Fundación Universitaria ','Av. Clle. 32 Nº 17-37','Pública','Comercial'],
        [4.58309,-74.09588,'ACTIVO',' Dirección Local de Educación Antonio Nariño','Clle. 14 Sur Nº 12C-26','Pública','Comercial'],
        [4.67055,-74.11954,'ACTIVO',' Dirección Local de Educación Fontibón','Clle. 25B Nº 81-55','Pública','Comercial'],
        [4.64993,-74.10183,'ACTIVO','Secretaria de Educación','Av. El Dorado Nº 66-63','Pública','Comercial'],
        [4.66900,-74.05672,'ACTIVO','clínica Country','Cra. 16 N° 82-57','Pública','Comercial'],
        [4.24835,-75.01947,'ACTIVO','CENOP San Luis','Vereda La Laguna, Hacienda Los Pijaos, San Luís (Tolima)','Cerrada','Comercial'],
        [4.24664,-75.01879,'ACTIVO','CENOP San Luis','Vereda La Laguna, Hacienda Los Pijaos, San Luís (Tolima)','Cerrada','Comercial'],
        [4.24869,-75.01879,'ACTIVO','CENOP San Luis','Vereda La Laguna, Hacienda Los Pijaos, San Luís (Tolima)','Cerrada','Comercial'],
        [10.98532,-73.56344,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [11.02576,-73.56069,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [11.01498,-73.51400,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [10.98262,-73.49478,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [10.95566,-73.48928,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [10.92060,-73.49478,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [11.07159,-73.64309,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [11.09585,-73.58541,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [11.10393,-73.53872,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [11.07159,-73.52773,'ACTIVO','Programa Sierra Viva','Sierra Nevada de Santa Marta','Cerrada','Rural'],
        [3.53270,-76.49354,'ACTIVO','Bavaria- Cali','Clle. 15 N° 25A-37 Acopi-Jumbo','Cerrada','Rural'],
        [2.93448,-75.28490,'ACTIVO','Cenaudio','Cra. 9 Nº 16-16','Pública','Mini-contenedor'],
        [1.14552,-76.64690,'ACTIVO','Ana Lucía Leyton ','Clle. 7 Nº 4-22','Pública','Mini-contenedor'],
        [4.64250,-74.05441,'ACTIVO','Universidad Manuela Beltran','Av. Circunvalar Nº 60-00','Pública','Comercial'],
        [4.58791,-74.19753,'ACTIVO','Easy Soacha','Cra. 2 Nº 36-81B - San Mateo','Pública','Comercial'],
        [6.25971,-75.57084,'ACTIVO','Easy Prado','Clle. 60 Nº 56-77','Pública','Comercial'],
        [4.67584,-74.08060,'ACTIVO','DIRECCION LOCAL DE EDUCACION BARRIOS UNIDOS','Clle. 74A Nº 63-04','Pública','Comercial'],
        [4.65398,-74.11529,'ACTIVO','Terminal de Transporte - Sede Salitre','Diag. 23 Nº 69-11','Pública','Comercial'],
        [4.79539,-74.04431,'ACTIVO','LICEO DE COLOMBIA','Clle. 219 N° 50-30','Pública','Comercial'],
        [4.76103,-74.06119,'ACTIVO','Jardin Infantil por Un Mañana','Cra. 68 Nº 173A-39','Pública','Comercial'],
        [4.54464,-75.66297,'ACTIVO','Clinica del Café','Cra. 12 Nº 0-75 Cons. 509','Pública','Mini-contenedor'],
        [11.00118,-74.81448,'ACTIVO','Centro Médico Continental','Cra. 49C Nº 80-125 Cons. 309','Pública','Mini-contenedor'],
        [7.11585,-73.11423,'ACTIVO','Edificio KBC','Clle. 49 Nº 27A-65 Cons. 106 Barrio Sotomayor','Pública','Mini-contenedor'],
        [3.89667,-76.29793,'ACTIVO','Centro Médico Integrado','Clle. 5 Nº 9-65','Pública','Mini-contenedor'],
        [3.42666,-76.54590,'ACTIVO','Clínica Vida Edificio de Colores','Clle. 5D Nº 38A-35  Torre 1- Piso 4 Cons. 424','Pública','Mini-contenedor'],
        [10.42575,-75.54559,'ACTIVO','Edificio Citibank','Centro Avenida Venezuela Piso 5 - Ofi. 51','Pública','Mini-contenedor'],
        [7.88492,-72.49736,'ACTIVO','Centro de Especialistas San José','Calle 13 Nº 1E-44 Ofi. 508B','Pública','Mini-contenedor'],
        [4.43707,-75.20335,'ACTIVO','Edificio Surgimédica','Cra. 6A Nº 60-19 Cons. 607','Pública','Mini-contenedor'],
        [5.06253,-75.49872,'ACTIVO','Edificio Colmenares','Clle. 50 Nº 25-65 Cons. 306','Pública','Mini-contenedor'],
        [6.21461,-75.56985,'ACTIVO','Edificio Colinas del Poblado','Cra. 43A Nº 14-27 Ofi. 205 - 604','Pública','Mini-contenedor'],
        [2.93005,-75.28859,'ACTIVO','Clínica Central','Clle. 11 Nº 6-47 Con. 404','Pública','Mini-contenedor'],
        [1.22732,-77.28595,'ACTIVO','Centro Comercial Valle de Atriz','Cra. 42 Nº 18A-94 Local 232','Pública','Mini-contenedor'],
        [4.81590,-75.69435,'ACTIVO','Centro Comercial Nova Centro','Clle. 20 Nº 5-39 Cons. 401','Pública','Mini-contenedor'],
        [2.44616,-76.60620,'ACTIVO','Edificio Hornaza','Cra. 8 Nº 2-44 Cons. 101','Pública','Mini-contenedor'],
        [11.23977,-74.21046,'ACTIVO','Centro Comercial La 22','Clle. 22 Nº 6-82 Local 8','Pública','Mini-contenedor'],
        [4.08371,-76.18924,'ACTIVO','Centro Profesional de Salud y Bienestar Vitta','Clle. 26 Nº 36-15 Cons. 204','Pública','Mini-contenedor'],
        [5.53317,-73.36523,'ACTIVO','Centro Comercial Plaza Real','Clle. 20 Nº 12-84 Ofc. 208A','Pública','Mini-contenedor'],
        [4.14335,-73.63771,'ACTIVO','Barrio Barzal','Clle. 33A Nº 38-69 Local 110','Pública','Mini-contenedor'],
        [4.70187,-74.03284,'ACTIVO','SOLER & CO','Av. 9 Nº 126-18 Ofi. 203','Cerrada','Mini-contenedor'],
        [4.80446,-75.67320,'ACTIVO','ACUEDUCTO CESTILLAL DIAMANTE','Corregimiento Altagracia Via Principal Casa 82','Pública','Comercial'],
        [4.87657,-75.87594,'ACTIVO','Zona Franca Internacional de Pereira','Corregimiento de caimalito, Zona Franca Internacional de Pereira, Edificio Usuario Operador','Pública','Comercial'],
    ];

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
            position: {lat: beach[0], lng: beach[1]},
            map: map,
            icon: image,
            title: beach[3],
            address: beach[4],
            zIndex: 1,
            numero: i
        });

        google.maps.event.addListener(marker, 'mouseover', function () {
            $('#marker-tooltip').hide();
            var point = fromLatLngToPoint(this.getPosition(), map);
            var pos = this.getPosition();
            // console.log(point);
            var htmlString =  "<b>"+this.title+"</b><br>"+"<p>"+this.address+"</p>";
            ($('#marker-tooltip').find("#informa")).html(htmlString);
            $(".como-llegar").unbind( "click" );
            $(".como-llegar").click(function(){
                //var end = new google.maps.LatLng(beaches[n][1],  beaches[n][2]);
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

        /*google.maps.event.addListener(marker, 'mouseout', function () {
            $('#marker-tooltip').hide();
        });*/
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
