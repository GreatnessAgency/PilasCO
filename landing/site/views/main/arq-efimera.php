<?php include(APPPATH.'views/inc/head.php');?>
<meta property="og:title" content="<?php echo $title;?>"/>
<meta property="og:url" content="<?php echo $site_url.@$url;?>"/>
<meta property="og:image" content="<?php echo $template;?>images/<?php echo @$imagen;?>"/>
<meta property="og:site_name" content="<?php echo $title;?>"/>
<meta property="og:description" content="Introducir al participante en el dise&ntilde;o de espacios ef&iacute;meros desde la concepci&oacute;n de la idea hasta su materializaci&oacute;n, ofreciendo las herramientas necesarias para exaltar las cualidades del producto, resolviendo el espacio comercial interior y exterior."/>
</head><!--fin head-->
<body id="<?php echo $body_id?>">
	<div id="wrapper">
		<?php include(APPPATH.'views/inc/header.php');?>
        <div id="content">
			<div class="web-wrapper web-int info-cont" style="">
			<div class="web-cont banner-cont">
				<img src="<?php echo $template;?>images/<?php echo $imagen;?>" alt="<?php echo $title;?>" />
			</div>
			<div class="web-cont " style="">
			<div class="start-side">
				<h3>OBJETIVOS</h3>
				<div class="web-cont">
					<ul>
					<li>Introducir al participante en el dise&ntilde;o de espacios ef&iacute;meros desde la concepci&oacute;n de la idea hasta su materializaci&oacute;n, ofreciendo las herramientas necesarias para exaltar las cualidades del producto, resolviendo el espacio comercial interior y exterior.</li>
					<li>Contribuir con las estrategias empresariales de mercadeo, vinculando al producto con sus consumidores de manera directa y activa&nbsp;a trav&eacute;s de la utilizaci&oacute;n de los espacios de exhibici&oacute;n y venta.</li>
					<li>Proyectar el dise&ntilde;o de espacios ef&iacute;meros desde sus posibilidades comunicacionales, tomando como soporte distintos materiales de car&aacute;cter sostenible.</li>
					</ul>
				</div>
				<h3>DESCUENTOS</h3>
				<div class="web-cont">
					<p>Correspondiente a un 10% sobre&nbsp;la matr&iacute;cula:</p>
					<ul>
						<li>Egresados U. Jorge Tadeo Lozano</li>
						<li>Afiliados a Cafam o Colsubsidio</li>
						<li>Tres o m&aacute;s participantes inscritos por&nbsp;una empresa <br/>(carta de compromiso).</li>
					</ul>
				</div>
				
				<h3>VALOR INSCRIPCI&Oacute;N</h3>
				<p>$ 119.000 <br /> Fecha límite de inscripción: 26 de Marzo de 2013
					</p>
				<h3>VALOR MATRÍCULA</h3>
				<p>$ 1.872.000 <br /> Fecha primer pago matrícula: 1 de Abril de 2013
					</p>
				<h3>FINANCIACIÓN</h3>
				<p>Apoyo financiero - Módulo 5,  oficina 101</p>
				<h3>INTENSIDAD:</h3>
				<p>120 horas</p>
				<h3>FECHA DE INICIO:</h3>
				<p>8 de Abril de 2013</p>
				<h3>HORARIO:</h3>
				<p>Lunes a jueves de 6:00 a 9:00 p.m. <br/>
					Sábado de 9:00 a 12:00 m</p>
			</div>
			<div class="end-side">	
				<?php include(APPPATH.'views/inc/form.php');?>
			</div>
			</div>
			</div>
	    </div>	
        <!-- End Content --> 
       <div id="push">&nbsp;</div>
    </div>
    <!--End wrapper--> 
	<?php include(APPPATH.'views/inc/footer.php');?>
</body>
</html>