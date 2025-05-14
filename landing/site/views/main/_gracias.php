<?php include(APPPATH.'views/inc/head.php');?>
<?php echo $conversion;?>
<script type="text/javascript">
function recomendar(){
	if($('input[name=sharemail]').val() != ""){ 
		$('#form-recomendar').submit(); 
	}else{ 
		alert('Debes ingresar por lo menos 1 correo electrónico,  separado por coma.');
	}
}
</script>
</head><!--fin head-->
<body id="<?php echo $body_id?>">
	<div id="wrapper">
		<?php include(APPPATH.'views/inc/header.php');?>
        <div id="content">
			<div class="web-wrapper web-int gracias-cont">
			<div class="gracias-img">Gracias por Contactar con Nosotros.</div>
			<div class="fL gracias-de">
				Educación Continuada<br/>
				Universidad Jorge Tadeo Lozano
			</div>
			<div class="fR">
				<div class="file-info">Puedes descargar en el siguiente vínculo el pdf <br/> del  programa.</div>
				<div class="file-btn"><a href="<?php echo $site_url;?>main/download/<?php echo $file;?>" target="_blank">Descargar Programa</a></div>
				<div class="file-info">Comunícate con nosotros para brindarte mayor <br/> asesoría al teléfono <span class="info-tel c02">2427030 ext. 3954/58</span></div>
				<div class="email-info">Toda esta información será enviada a tu correo electrónico, <br/> por favor agrega a tu lista de contactos nuestro correo: <br/><span class="c02">diplomados@utadeo.edu.co</span> <br/>para evitar que se vaya a la bandeja de correos no <br/>deseados o spam.</div>
			<div class="web-int share-cont">	
				<div class="social-title">Comparte esta información</div>
				<div class="web-cont social-cont">
					<div style="float:left;">
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $site_url.$file?>" data-text="<?php echo $title;?>" data-lang="es">Twittear</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>
					<div style="float:left;">
						<a name="fb_share" type="button_count" share_url="<?php echo $site_url.$file?>" href="https://www.facebook.com/sharer.php">Share</a> 
						<script src="https://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script> 
					</div>
				</div>
				<div class="social-title">Envíale esta información a tus amigos</div>
				<div class="web-cont envia-cont">
					<form id="form-recomendar" action="<?php echo $site_url;?>main/recomendar/<?php echo $file.'/'.$correoe.'/'.$nombrep?>" method="post">
						<input value="" name="sharemail" placeholder="nombre@correoelectronico.com, nombre@correoelectronico.com" />
						<a href="#!" onclick="recomendar();">Enviar</a>
					</form>
				</div>
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