<div class="puntos">
  <div class="container-fluid cabezote">
    <div class="container interna puntos">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="miga">
          <a href="#">Inicio</a>
          <span> - </span>
          <a href="#" class="actual">Puntos de recolección</a>
        </div>
        <div class="icono-seccion">
          <svg class="icono"><use xlink:href="<?php echo $assets; ?>images/sprites.svg#icono-puntos"></use></svg>
        </div>
        <div class="introduccion-seccion">
          <h2 class="titulo">Puntos de recolección</h2>
          <p class="texto">Encuentra tu punto de recolección más cercano y <strong>¡Lleva tus Pilas ya!</strong></p>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <form class="formulario-select">
          <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-lg-push-6">
            <select id="select_ciudades" class="form-control ciudades" name="">
              <option selected disabled>Selecciona tu ciudad</option>
              <option value='{"lat":4.49215, "lng":-75.70934}'>Armenia</option>
              <option value='{"lat":10.97787, "lng":-74.80376}'>Barranquilla</option>
              <option value='{"lat":6.34002, "lng":-75.56216}'>Bello</option>
              <option value='{"lat":4.59826, "lng":-74.07533}'>Bogotá</option>
              <option value='{"lat":7.10908, "lng":-73.11988}'>Bucaramanga</option>
              <option value='{"lat":3.88661, "lng":-77.07022}'>Buenaventura</option>
              <option value='{"lat":4.92043, "lng":-74.02716}'>Cajicá</option>
              <option value='{"lat":3.42055, "lng":-76.52222}'>Cali</option>
              <option value='{"lat":3.39884, "lng":-76.38476}'>Candelaria Valle</option>
              <option value='{"lat":10.38733, "lng":-75.51966}'>Cartagena</option>
              <option value='{"lat":4.86757, "lng":-74.03817}'>Chía</option>
              <option value='{"lat":6.34443, "lng":-75.50801}'>Copacabana</option>
              <option value='{"lat":4.80956, "lng":-74.09812}'>Cota</option>
              <option value='{"lat":4.83649, "lng":-75.66971}'>Dosquebradas</option>
              <option value='{"lat":6.13751, "lng":-75.26495}'>El Santuario Antioquia</option>
              <option value='{"lat":6.16666, "lng":-75.56666}'>Envigado</option>
              <option value='{"lat":4.14861, "lng":-74.88535}'>Espinal</option>
              <option value='{"lat":4.81502, "lng":-74.35646}'>Facatativá</option>
              <option value='{"lat":7.06076, "lng":-73.09697}'>Florida Blanca</option>
              <option value='{"lat":4.71666, "lng":-74.21666}'>Funza</option>
              <option value='{"lat":4.32455, "lng":-74.41207}'>Fusagasuga</option>
              <option value='{"lat":6.19856, "lng":-75.58443}'>Guayabal</option>
              <option value='{"lat":2.70069, "lng":-75.51855}'>Huila</option>
              <option value='{"lat":4.44028, "lng":-75.24983}'>Ibagué</option>
              <option value='{"lat":0.82058, "lng":-77.65879}'>Ipiales</option>
              <option value='{"lat":6.17662, "lng":-75.61270}'>Itagüí</option>
              <option value='{"lat":3.22467, "lng":-76.62160}'>Jamundi</option>
              <option value='{"lat":4.71937, "lng":-73.96979}'>La Calera</option>
              <option value='{"lat":4.76129, "lng":-74.27661}'>Madrid</option>
              <option value='{"lat":5.06798, "lng":-75.51738}'>Manizales</option>
              <option value='{"lat":6.23592, "lng":-75.57513}'>Medellín</option>
              <option value='{"lat":1.15008, "lng":-76.64782}'>Mocoa</option>
              <option value='{"lat":8.60485, "lng":-75.97411}'>Montería</option>
              <option value='{"lat":4.70777, "lng":-74.23277}'>Mosquera</option>
              <option value='{"lat":2.99625, "lng":-75.30471}'>Neiva</option>
              <option value='{"lat":3.58478, "lng":-76.22176}'>Palmira</option>
              <option value='{"lat":1.20459, "lng":-77.28206}'>Pasto</option>
              <option value='{"lat":4.81429, "lng":-75.69464}'>Pereira</option>
              <option value='{"lat":2.44238, "lng":-76.57919}'>Popayán</option>
              <option value='{"lat":6.14840, "lng":-75.40565}'>Rionegro</option>
              <option value='{"lat":6.13833, "lng":-75.61091}'>Sabaneta</option>
              <option value='{"lat":12.55673, "lng":-81.71852}'>San Andrés y Providencia</option>
              <option value='{"lat":6.24931, "lng":-75.59027}'>San Juan</option>
              <option value='{"lat":11.23401, "lng":-74.19501}'>Santa Marta</option>
              <option value='{"lat":4.49118, "lng":-74.26067}'>Sibaté</option>
              <option value='{"lat":9.31541, "lng":-75.43847}'>Sincelejo</option>
              <option value='{"lat":4.58333, "lng":-74.21666}'>Soacha</option>
              <option value='{"lat":10.90325, "lng":74.77740}'>Soledad Atlántico</option>
              <option value='{"lat":4.89142, "lng":-73.96359}'>Sopo</option>
              <option value='{"lat":4.96666, "lng":-73.91666}'>Tocancipa</option>
              <option value='{"lat":6.14840, "lng":-75.40565}'>Yopal</option>
              <option value='{"lat":3.59397, "lng":-76.51220}'>Yumbo</option>
              <option value='{"lat":5.02735, "lng":-74.00968}'>Zipaquirá</option>
              <option value='{"lat":3.85604, "lng":-76.11643}'>Buga</option>
              <option value='{"lat":8.07888, "lng":-72.47656}'>Cúcuta</option>
              <option value='{"lat":4.03710, "lng":-76.06657}'>Tuluá</option>
              <option value='{"lat":5.51566, "lng":-73.37549}'>Tunja</option>
              <option value='{"lat":4.11172, "lng":-73.46514}'>Villavicencio</option>
            </select>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="container-fluid contenido-interna">
    <div class="container interna-seccion4 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style=" height: 500px; width:  100%;">
    <div class="capsula-map">
        
    </div>
      <div id="map" class="cont-mapa-munic"></div>
      <div id="marker-tooltip">
        <div id="informa"></div>
        <div class="botones-tooltip">
          <button class="como-llegar">¿Cómo llegar?</button>
          <button class="como-ver">StreetView</button>
        </div>
      </div>
   </div>
  </div>
  <div class="container-fluid menu-puntos">
    <div class="container">
      <a class="boton-puntos" href="#" onclick="toogleLocator()">
      <img src="<?php echo $assets; ?>images/puntos-cercanos.svg" alt="puntos cercanos">
        <p class="texto"></p>
      </a>
    </div>
  </div>
  </div>
</div>
<style>
  /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
  #map {
    height: 100%;
  }
  /* Optional: Makes the sample page fill the window. */
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
</style>
<script src="<?php echo $assets;?>js/mapa-google.js"></script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLx2cQEJG16Vc14fQp9j8xBuLKn0QPSx0&callback=initMap">
</script>