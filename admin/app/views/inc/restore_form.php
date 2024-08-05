<?php 
/*
 * si no existe la variable llave carga el formulario de enviar mail de recuperacion
 * si exite muestra el formulario de re escribir contraseña.	
 */
if(!isset($llave)){
?>
<form id="web_form" onSubmit="return sendForm( this, '#login_content', '<?php echo $site_url?>', 'home/restore_data/')" method="post">
	<?php if( isset( $msj ) ){echo $msj; }?>	
	<div class="zav-content" style="margin:7px 0;">
		<div class="zav-int-content" style="width:220px;">
            <div class="txt-content">Correo Elect&oacute;nico:</div>
            <input name="email" id="Correo-electónico_1" type="text" class="ipt-log" value="" />
            <div class="c_gray" style="text-align:center; margin-top:5px;">Se enviar&aacute; datos de recuperaci&oacute;n</div>
        </div>
	</div>
	<div class="zav-content" style="margin:7px 0;">
		<div class="zav-int-content" style="width:220px;">
			<div style="float:left;">
				<a onclick="LoadContent('#login_content','<?=$site_url;?>','home/login/');" href="#!" class="c_red-dos">&laquo; Cancelar</a>
			</div>
			<div style="float:right;">
				<input type="submit" value="Enviar" class="btn-red">
			</div>
		</div>
	</div>
</form>
<?php }else{?>
<form id="web_form" onSubmit="return sendForm( this, '#login_content', '<?php echo $site_url?>', 'home/change_pass?key=<?=urlencode($llave);?>')" method="post">
	<?php if( isset( $msj ) ){echo $msj; }?>	
	<div class="zav-content" style="margin:7px 0;">
		<div class="zav-int-content" style="width:220px;">
            <div class="txt-content">Correo Elect&oacute;nico:</div>
            <div class="c_gray" style="margin-top:2px;">Al cual se le env&iacute;o este enlace</div>
            <input name="email" id="Correo-electónico_1" type="text" class="ipt-log" value="" />
        </div>
	</div>
	<div class="zav-content" style="margin:7px 0;">
		<div class="zav-int-content" style="width:220px;">
            <div class="txt-content">Nueva Contrase&ntilde;a:</div>
            <input name="password" id="Contraseña_1" type="password" class="ipt-log" value="" />
        </div>
	</div>
	<div class="zav-content" style="margin:7px 0;">
		<div class="zav-int-content" style="width:220px;">
			<div style="float:left;">
				<a onclick="LoadContent('#login_content','<?=$site_url;?>','home/login/');" href="#!" class="c_red-dos">&laquo; Volver</a>
			</div>
			<div style="float:right;">
				<input type="submit" value="Cambiar Contrase&ntilde;a" class="btn-red">
			</div>
		</div>
	</div>
</form>	
	
<?php }?>