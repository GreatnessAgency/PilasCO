<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="es" class="ie6 ielt9"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="ie7 ielt9"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="ie8 ielt9"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Pilas Colombia</title>
        
        <meta property="fb:app_id" content="219290648248249" />
        <meta property="og:title" content="Pilas Colombia" />
        <meta property="og:type" content="Article" />
        <meta property="og:url" content="http://pilascolombia.com/landing/" />
        <meta property="og:description" content="En el cuidado del medio ambiente todos tenemos una gran responsabilidad, productores, importadores y consumidores #PilasconelAmbiente" />

        
        <meta property="og:image" content="http://pilascolombia.com/landing/site/images/avatar.jpg" />
        
	<!-- meta tags -->

	<!-- css styles and fonts -->
	<script type="text/javascript" src="<?php echo $template;?>js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo $template;?>js/jquery.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $template;?>js/jquery.validationEngine/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?php echo $template;?>js/jquery.validationEngine/jquery.validationEngine-es.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $template;?>js/jquery.validationEngine/css/validationEngine.jquery.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo $template;?>css/swis711BT/stylesheet.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo $template;?>css/swis711LT/stylesheet.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo $template;?>css/forms.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo $template;?>css/style.css" >
	
<script type="text/javascript">
$(document).ready(function(){
    var form = 'form[name="form_info"]';
    $(form).validationEngine({
        addFailureCssClassToField:"error", 
        validationEventTrigger: "submit",
        ajaxFormValidation: true,
        ajaxFormValidationMethod: 'post',
        onBeforeAjaxFormValidation: function(form, options){
            $('.btn-send').button('loading');
        },
        onAjaxFormComplete: function(form, status, json, options){
            if( status) {
                $('.btn-send').button('reset');
                if(json.response.code === 200){
                    $('#form_info').each(function(){
                        //this.reset();
                    });
                    //gracias
                    window.location.href = json.url;
                }
            }
        },
        onFailure: function() {
            $('.btn-send').button('reset');
            alert( "Ocurrio un error, sus respuestas no se guardaron, por favor inténtelo de nuevo." );
        }
    });
    
    $('.terminosClose, .terminos').on('click',function(e) {
        e.preventDefault();
        $('.terminos-box').slideToggle('slow');
    });
    
    $('.btn-send').on('click', function(e) {
       e.preventDefault();
       if(!$(this).hasClass('disabled')){
           $('form[name="form_info"]').submit();
       }       
    });
    
    $('.link-enviar').on('click', function(e) {
       e.preventDefault();
       $(this).toggleClass('collapsed');
       if( $(this).hasClass('collapsed') ){
            $(this).html('Registre sus datos');
            $('span.registre').hide();
            $('form[name="form_info"]').attr('action', $('form[name="form_info"]').attr('action') + '/share');
            $('label[for=nombre]').html('<span class="obli">*</span> Nombre del responsable');
            $('#nombre').focus();
            $('#nit').hide();
            $('label[for=nit]').hide();
            $('#cargo').hide();
            $('label[for=cargo]').hide();
            $('#ciudad').hide();
            $('label[for=ciudad]').hide();
            $('#telefono').hide();
            $('label[for=telefono]').hide();
       }else{
            $(this).html('Env&iacute;elo al &Aacute;rea encargada');
            $('span.registre').show();
            $('form[name="form_info"]').attr('action', $('form[name="form_info"]').attr('action').replace('/share'));
            $('label[for=nombre]').html('<span class="obli">*</span> Nombre completo');
            $('#nombre').focus();
            $('#nit').show();
            $('label[for=nit]').show();
            $('#cargo').show();
            $('label[for=cargo]').show();
            $('#ciudad').show();
            $('label[for=ciudad]').show();
            $('#telefono').show();
            $('label[for=telefono]').show();
       }
       
    });
        
});

function enviarAmigo(boton){
	validate(boton, 'form[name=Comparte]', 'registrar-datos.php?compartir=t', function(data){
		if(data == 'f'){
			alert('Hubo un error al enviar el mensaje inténtelo nuevamente.');
		}else{
			$('form[name=Comparte] input').val('');
			alert('Mensaje enviado con éxito, muchas gracias.');
			$('#enviarAmigos').slideToggle();
		}
	});
}
</script>	

</head>
<body>
	<header>
		<div class="barra_sup">&nbsp;</div>
	</header>
	<section class="wrapper">	
		<article class="logos left_content">
			<div style=" display:table;">
				<img style="margin-left:0;" src="<?php echo $template;?>images/pilas_con_el_ambiente.png" title="Pilas con el Ambiente">
				<img src="<?php echo $template;?>images/andi_logo.png" title="Andi">
				<img src="<?php echo $template;?>images/logo_ministerio.png" title="MinAmbiente">
			</div>
			<div>
				<div class="tag_cont">
					<h1 class="cOrange">Lidere en su empresa las actividades de posconsumo de <span class="cBrown">pilas usadas</span> junto al programa Pilas con el Ambiente de la ANDI.</h1>
					<p>El programa Pilas con el Ambiente, tiene como principal objetivo cerrar el ciclo de vida del producto de manera conjunta con el consumidor y en beneficio del medio ambiente.</p>
				</div>

				<div class="block_cont">
					<h2 class="cBrown">Beneficios para su empresa:</h2>
					<ul class="item_list">
                                            <li>Constancia del volumen recibido junto con una copia del acta de disposici&oacute;n final.</li>
                                                <li>Disposici&oacute;n final de las pilas usadas sin costo alguno.</li>
                                                <li>Manejo adecuado de las pilas entregadas, acorde con la legislaci&oacute;n vigente.</li>
                                                <li>Su organizaci&oacute;n trabajar&aacute; de acuerdo a las tendencias mundiales en materia de cuidado medioambiental y tratamiento de estos residuos.</li>
						<li>Fomento de la cultura ambiental al interior de su empresa.</li>
					</ul>
				</div>
				<div class="block_cont">
					<h2 class="cBrown">Beneficios para el medio ambiente y la comunidad:</h2>
					<ul class="item_list">
                                            <li>La disposici&oacute;n segura impedir&aacute; que estos finalicen en fuentes de agua o lugares no aptos para dichos residuos.</li>
						<li>Mejora la capacidad de los rellenos sanitarios.</li>
						<li>Facilita y optimiza el trabajo de las personas que recolectan estos residuos.</li>
					</ul>
				</div>
				<div class="end_tag">
					<p class="fsize28">En el cuidado del medio ambiente todos tenemos una gran responsabilidad, productores, importadores y consumidores.<br/>
                                            <span class="fsize33 cOrange">&iexcl;S&uacute;mese a esta iniciativa&excl;</span></p>
				</div>
			</div>
		</article>
		<article class="right_content">
			<div class="btn_registrese">
				<div class="btn_left">&nbsp;</div>
                                <div class="btn_fill">Reg&iacute;strese</div>
				<div class="btn_right">&nbsp;</div>
			</div>
			<div class="bloque">Es muy sencillo:<br/>
                            <p><a href="#!" class="link-enviar">Env&iacute;elo al &Aacute;rea encargada</a></p><br>
                            <span class="registre">O registre sus datos en el siguiente formulario.</span>
			</div>

                        <form name="form_info" id="form_info" action="<?php echo $site_url;?>main/enviar/<?php echo $url;?>" method="POST">
				<label class="label_input" for="nombre"><span class="obli">*</span> Nombre completo</label>
                                <input name="nombre" id="nombre" class="input required validate[required]" type="text" value="" />
				<label class="label_input" for="cargo"> Cargo</label>
                                <input name="cargo" id="cargo" class="input" type="text" value="" />
				<div>
                                    <div class="terminos-box">
                                        <div class="close"><a href="#!" class="terminosClose">x</a></div>
                                            <div class="terminos-title">T&eacute;rminos y condiciones</div>
                                            <div class="terminos-text">Manifiesto que en virtud de la Ley 1581 de 2012 &quot;Por la cual se dictan disposiciones generales para la protecci&oacute;n de datos personales&quot;, autorizo al Programa posconsumo de la ANDI, Pilas con el Ambiente de manera expresa para llevar a cabo el uso y tratamiento de todos los datos personales y/o de la compa&ntilde;&iacute;a aqu&iacute; suministrados para ampliar informaci&oacute;n relacionada con el Programa Pilas con el Ambiente.</div>
                                    </div>
				</div>
				<label class="label_input" for="razon_social"><span class="obli">*</span> Raz&oacute;n social</label>
                                <input name="razon_social" id="razon_social" class="input required validate[required]" type="text" value="" />
				<label class="label_input" for="nit"><span class="obli">*</span> Nit</label>
				<input name="nit" id="nit" class="input required validate[required]" type="text" value="" />
				<label class="label_input" for="ciudad"><span class="obli">*</span> Ciudad</label>
                                <input name="ciudad" id="ciudad" class="input required validate[required]" type="text" value="" />
				<label class="label_input" for="email"><span class="obli">*</span> Correo electr&oacute;nico</label>
				<input name="email" class="input email required validate[required,custom[email]]" type="text" value="" />
                                <label class="label_input" for="telefono"><span class="obli">*</span> Tel&eacute;fono</label>
                                <input name="telefono" id="telefono" class="input required onlynum validate[required,custom[phone]]" type="text" value="" />
				<div class="terminos_cont">
					<div class="terminos_check">
                                            <input name="aceptaterminos" type="checkbox" class="required validate[required]" value="1" />
					</div>
					<div>
                                            <label for="terminos" class="terminos_link cOrange">Acepto <a href="#!" class="terminos">t&eacute;rminos y condiciones.</a></label>
					</div>
				</div>
				<div>&nbsp;</div>
				<div>&nbsp;</div>
                                <input type="hidden" name="interes" value="pilas">
                               

			</form>
			<div>
				<a href="#!" class="btn-send" data-loading-text="Enviando...">
                                    Quiero ser parte del programa
				</a>
			</div>
				<div style="font-size:12px; display: table; margin: -10px 0 0 30px; width: 250px; color:gray;"><br/>* Campos Obligatorios</div>
		</article>
		<div id="push" class="wrapper">&nbsp;</div>	
	</section>	
	<div class="footer">
		<div class="footer-wrapper">
			<div class="footer_content">
				<div>
					<p>Todos los derechos reservados Â© 2013</p>
				</div>
				<div class="separator">&nbsp;</div>
				<div class="zav"><p><a href="http://www.zavgroup.com" target="_blank">Desarrollado por Zav Group</a></p></div>
			</div>
			<div class="pilascol">&nbsp;</div>
		</div>
	</div>
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7526679-31']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>