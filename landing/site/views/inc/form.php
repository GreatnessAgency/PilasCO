<script type="text/javascript">
$(function(){
	$('input[type=checkbox]').click(function(){
		if($(this).is(':checked')){
			$(this).val('t');
		}else{
			$(this).val('f');
		}
	});
});

function validaEnvia(elm, form){
 	btn = $(elm); 	
 	var status = false;
 	var input = new Array();
 	var filter=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
 	input[0] = $('input[name="nombre"]');
 	input[1] = $('input[name="email"]');

 	$(input).each(function(){
		label = $(this).attr('name');
 		if($(this).val() == ""){
 			status = false;
 			$(this).addClass('error');
 			$(this).focus();
 			alert($('label[for='+label+']').text()+' Campo Obligatorio');
 			return false;
 		}else{
 			$(this).removeClass('error');
 			status = true;
 		}
 		//
 		if($(this).attr('name') == 'email'){
			if(!filter.test( $(this).val()) ){
				status = false;
	 			$(this).addClass('error');
				$(this).focus();
				alert($('label[for='+label+']').text()+' Verifique este Campo');
	 			return false;
			}
 		}
 	});
	
	if(status === false){
		return false;
	}
	
	privacy = $('input[name=auth-email]');
	
	if(privacy.val() != 't'){
		privacy.focus();
		alert('Debe aceptar los terminos de privacidad.');
		status = false;
		return false;
	}else{
		status = true;
	}

 	if(status === true && btn.hasClass('deactive') === false){
 		org = btn.text();
 		btn.addClass('deactive');
 		btn.text(' Espere... ');
 		$(form).submit();
 	}
}
</script>
<div class="form-cont">
	<div style="margin-top:37px"></div>
	<div class="web-int form-int">
		<div class="form-title font01">¿Te interesa el programa?</div>
		<div class="web-cont form-desc">
			Recibe más información sobre este diplomado ingresando tus datos.
		</div>
		<form id="form-info" action="<?php echo $site_url;?>main/enviar/<?php echo $url;?>" class="form-int web-int" method="post">
			<input name="programa" type="hidden" value="<?php echo $title;?>" />
			<label for="nombre"><span class="cRed">*</span> Nombre completo</label>
			<input name="nombre" type="text" class="input" value="" />
			<label for="email"><span class="cRed">*</span> Correo Electr&oacute;nico</label>
			<input name="email" type="text" class="input" value="" />					
			<label for="telefono">Teléfono</label>
			<input name="telefono" type="text" class="input"  />
			<div class="web-cont form-check-cont">
				<div class="fL">
					<label for="auth-email"><span class="cRed">*</span>
					<input name="auth-email" type="checkbox" value="f" class="check" /></label>
				</div>
				<div class="fR">
					Autorizo a la Universidad Jorge Tadeo Lozano a que me envíe información relacionada con el programa de acuerdo a las disposiciones generales para la protección de mis datos personales contenidas en la legislación Colombiana
				</div>
			</div>
			<div class="web-cont" style="height:50px">&nbsp;</div>
			<div class="web-int">
				<a href="#!" onclick="validaEnvia(this, '#form-info');" class="form-btn font01">Deseo más información</a>
			</div>
		</form>
	</div>
</div>
<div class="web-cont" style="height:600px">&nbsp;</div>
<div class="web-cont logos-cont">
	<a href="http://utadeo.edu.co/" target="_blank">
	<img src="<?php echo $template;?>images/universidad-jorge-tadeo-lozano.jpg" alt="Universidad Jorge Tadeo Lozano - Bogotá, Colombia" /></a>
</div>
<?php if($url == 'publicidad-digital'){ ?>
<div class="web-cont logos-cont">
	<a href="http://www.iabcolombia.com/" target="_blank">
	<img src="<?php echo $template;?>images/interactive-adversiting-bureau-colombia.jpg" alt="Interactive Advertising Bureau Colombia" /></a>
</div>
<?php }?>