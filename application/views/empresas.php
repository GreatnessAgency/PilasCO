<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="conoce">
  <div class="container-fluid cabezote empresa">
   <div class="miga">
        <a href="#">Inicio</a>
        <span> - </span>
        <a href="#" class="actual">Empresariales e institucionales</a>
      </div>
    <div class="container interna empresas">
      <div class="col-xs-12	col-sm-12	col-md-12 col-lg-12">
        <div class="icono-seccion">
         <img class="icono" src="<?php echo $assets; ?>images/menu/hogar.svg" alt="Conoce el programa">
        </div>
        <div class="introduccion-seccion">
          <h2 class="titulo">Empresariales e institucionales:</h2>
        </div>
      </div>
    </div>  
  </div>
  <div class="container-fluid notas sombra">
    <div class="row">
    <div class="container interna-seccion2">
      <div class="listado-notas">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 empresa-texto">
          <h3 class="titulo">¡Tú eres el protagonista, nosotros tu equipo!.<br>
          <span>Vincula a tu organización y ayúdale a estar Pilas con el Ambiente promoviendo una cultura de recolección.</span></h3>
          <p class="texto">Pilas con el Ambiente da un manejo adecuado a las pilas y acumuladores entregados, de acuerdo con la normatividad para el manejo de estos residuos.</p>
      </div>
   </div>
 </div>
</div>
</div> 

<div class="container-fluid notas neutral">
  <div class="container interna-seccion2">
    <div class="listado-notas">    
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 empresa-titulos">
          <h3 class="titulo">Participa y conviértete en un líder ambiental:</h3>
          <p class="parrafo1">Programa tu recolección en las ciudades de Bogotá y Medellín a partir de 8 Kg, en el resto del país (con cobertura) a partir de 40 Kg.</p>
       </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nota-principal">
        <div class="modal-wrapper" id="popup">
           <div class="popup-contenedor">
           <h3>Registro</h3>
           <form id="register_form" role="form" method="post" action="">
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			                <input type="text" name="empresa" id="Empresa" class="form-control input-sm" placeholder="Empresa" required>
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="text" name="nombre" id="Nombre-de-contacto" class="form-control input-sm" placeholder="Nombre de contacto" required>
			    					</div>
			    				</div>
			    			</div>

			    		<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
                        <select id="tipo de documento" name="tipo_documento" class="form-control input-sm" required>
                           <option value="">Tipo de Documento</option>   
                           <option value="C.C.">CC</option>
                           <option value="N.I.T">NIT</option>
                        </select>
			    					</div>
                  </div>
                  
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="text" name="numero_documento" id="numero-de-documento" class="form-control input-sm" placeholder="Número de documento" required>
			    					</div>
			    				</div>
			    			</div>

	             <div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="text" name="direccion" id="direccion" class="form-control input-sm" placeholder="Dirección" required>
			    					</div>
                  </div>
                  
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="text" name="ciudad" id="ciudad" class="form-control input-sm" placeholder="Ciudad" required>
			    					</div>
			    				</div>
			    			</div>

			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="number" name="telefono" id="telefono" class="form-control input-sm" placeholder="Teléfono" required>
			    					</div>
                  </div>
                  
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="email" name="email" id="e-mail" class="form-control input-sm" placeholder="e-Mail" required>
			    					</div>
			    				</div>
			    			</div>
                
                <div class="form-group">
                  <textarea name="mensaje" id="mensaje" cols="30" rows="10" class="form-control input-sm" placeholder="¿Porqué quieres vincularte a Pilas con el Ambiente?" required></textarea>
                </div>
                <input type="checkbox" name="acepto-recibir" value="acepto-recibir" required><label for="acepto-recibir">Acepto recibir información por e-mail.</label>
                <br>
                <input type="submit" value="Enviar" class="btn btn-info btn-sm">
			    	
			    		</form>
              <a class="popup-cerrar" href="#">X</a>
          </div>
        </div>
          <div class="numero col-xs-1 col-sm-1 col-md-1 col-lg-1">1</div>
          <div class="icon_corres col-xs-2 col-sm-2 col-md-2 col-lg-2">
          <img src="<?php echo $assets; ?>images/empresa_correo1.svg" alt="correo">
          </div>
          <div class="caja_info empresa_boton col-xs-4 col-sm-4 col-md-4 col-lg-9">¿Eres un aliado de Pilas con el Ambiente? Si aún no, 
             <a href="#popup" class="popup-link"> Regístrate aquí </a> y uno de nuestros <br> colaboradores se comunicará contigo para coordinar la inscripción.
          </div>

        </div>  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nota-principal">
          <div class="numero col-xs-1 col-sm-1 col-md-1 col-lg-1">2</div>
          <div class="icon_corres col-xs-2 col-sm-2 col-md-2 col-lg-2">
          <img src="<?php echo $assets; ?>images/empresa_mano2.svg" alt="union">
          </div>
          <div class="caja_info3 col-xs-4 col-sm-4 col-md-4 col-lg-9">
            <a class="segundario-empresa" href="#ancla-contacto">Haz tu solicitud de recolección.</a>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 empresa-titulos">
          <p class="parrafo">Con tu participación, recibirás el certificado de disposición final sin ningún costo y como reconocimiento del avance de tu organización en gestión ambiental. (Que se entregara en 45 y 60 días).</p>
       </div>
      </div>
    </div>
  </div>

  <div class="container-fluid color">
     <div class="container interna-seccion2">
       <div class="listado-notas">  
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 empresa-from">
           <form id="sticker_form" class="form-horizontal col-xs-12 col-sm-12 col-md-8 col-lg-8" action="/action_page.php" method="post">
              <span class="col-xs-12 col-sm-12 col-md-10 col-lg-10">Descarga los Sticker y arma tu propio mini-contenedor:</span>
              <div class="form-group">
               <div class="col-sm-10">
                  <input type="text" class="form-control" id="Nombre" placeholder="Nombre" name="nombre" required>
               </div>
             </div>
             
             <div class="form-group">
               <div class="col-sm-10">
                  <input type="email" class="form-control" id="email" placeholder="e-Mail" name="email" required>
               </div>
             </div>

             <div class="form-group">
               <div class="col-sm-10">
                  <input type="number" class="form-control" id="telefono" placeholder="Teléfono" name="telefono" required>
               </div>
             </div>

             <div class="form-group">
                <div class="col-sm-10">          
                  <input type="text" class="form-control" id="empresa" placeholder="Empresa" name="empresa" required>
               </div> 
             </div>

             <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                  <div class="checkbox">
                   <label><input type="checkbox" name="acepto recibir" required>Acepto recibir información por e-mail.</label>
                </div>
               </div>
             </div>

            <div class="form-group">        
               <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Descargar.</button>
              </div>
            </div>
          </form>
          <div class="imagen_form">
          </div>
         </div>
       </div>
       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 empresa-titulos2">
          <h3 class="titulo">¡Cuando las pilas estén fuera de su lugar, tu recolección será vital!.</h3>
          <p class="texto_info">Haz tu solicitud de recolección a partir de 8 Kg, sigue estos pasos: <a href="mailto:info-digital@pilascolombia.com"> info-digital@pilascolombia.com</a></p>
       </div>
     </div>
  </div>
</div>

