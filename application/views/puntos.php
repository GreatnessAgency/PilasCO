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
          <h2 class="titulo">Puntos de recolección:</h2>
          
          <p class="texto">Encuentra tu punto de recolección más cercano y <strong>¡Lleva tus Pilas ya!  </strong> 2024></p>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <form class="formulario-select">
          <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-lg-push-6">
            <select id="select_ciudades" class="form-control ciudades" name="">
              <option selected disabled>Selecciona tu ciudad</option>
                <!-- las opciones se insertan por medio de un json  -->
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
      <img src="<?php echo $assets; ?>images/puntos-cercanos.svg" alt="Ver puntos cercanos">
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
<script>
  var beaches = <?php echo $puntos ?>;
</script>
<script src="<?php echo $assets;?>js/mapa-google.js"></script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA58moEOBg4lVNBoD-3CiULdJDycZJktxQ&callback=initMap">

</script>