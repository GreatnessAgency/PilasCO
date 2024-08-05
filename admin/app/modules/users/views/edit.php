<script type="text/javascript">
var cont = 0;
var tot = 1;

function checkValue(caja){
	c = $(caja);
	if(c.is(':checked')){
		c.val('t');
	}else{
		c.val('f');
	}
}

function getNiveles(nu){
	$('input.levels').val('f');
	$('input.levels').attr('checked', false);
	if(nu != ""){
	$('input.level-'+nu).attr('checked', true);
	$('input.level-'+nu).val('t');
	}
}
</script>
<?php if( isset( $alert ) ):?><div id="message"><?=$alert?></div><?php endif?>
<form name="ZavForm" onSubmit="return sendForm( this, '#main', '<?=$site_url?>', 'users/edit/<?=$item->id;?>/')" method="post">
<div id="general">
	<div class="title">Usuarios:</div>
	<div class="tasks">
		<div class="filter" style="padding-top:5px">
			<label><b>Agregando Usuario</b></label>
		</div>
		<div class="back">
			<a href="#" onclick="LoadContent( '#main', '<?=$site_url?>', 'users' )">
				<img src="<?=$template?>images/back.png" alt="Regresar" title="Regresar" /> Regresar al listado
			</a>
		</div>
		<div class="pages">
			<img src="<?=$template?>images/info.png" alt="Modo Agregar" title="Modo Agregar" />
			<label>Esta en modo Agregar</label>
		</div>
		<div class="spacer">&nbsp;</div>
	</div>
	<div class="content2" style="background:#e7f7d0">
		<div class="row">
            <div class="form-content">
                <div class="txt-content">Nombres:</div>
                <input name="first_name" id="Nombres" class="input" type="text" value="<?=$item->first_name;?>"/>
            </div>			
		</div>
		<div class="row">
            <div class="form-content">
                <div class="txt-content">Apellidos:</div>
                <input name="last_name" id="Apellidos" class="input" type="text" value="<?=$item->last_name;?>"/>
            </div>			
		</div>
		<div class="row">
            <div class="form-content">
                <div class="txt-content"><span class="c_red">*</span> Nombre de Usuario:</div>
                <input name="username" id="Usuario_1" class="input" type="text" value="<?=$item->username;?>"/>
            </div>			
		</div>
		<div class="row">
			<div class="form-content">
                <div class="txt-content">Contrase&ntilde;a:</div>
                <input name="password" id="Contrasena" class="input" type="password" value="" />
            </div>
		</div>
		<div class="row">
			<div class="form-content">
                <div class="txt-content"><span class="c_red">*</span> Correo elect&oacute;nico:</div>
                <input name="email" id="Email_2" class="input" type="text" value="<?=$item->email;?>" />
            </div>
		</div>
		<div class="row" style="text-align:center;">
			El nivel <strong> Usuario </strong> no cuenta con acceso al zav_admin
		</div>	
		<div class="row">
			<div class="form-content">
                <div class="txt-content"><span class="c_red">*</span> Niveles: <span class="c_gray">pre-establecidos</span></div>
                <select name="rol_id" class="input" id="Nivel_1" onchange="getNiveles(this.value);">
                	<option value="">Seleccione...</option>
					<?php if($user->rol_id == 0){?>
						<option value="0" <?=( 0 == $item->rol_id)?'selected="selected"':"";?>>Super Administrador</option>
					<?php }?>
                	<?php foreach($detetc as $t) {?>
						<option value="<?=$t->value;?>" <?=( $t->value == $item->rol_id)?'selected="selected"':"";?>><?=$t->name;?></option>								
					<?php }?>
				</select>
            </div>
		</div>
		<h3>Acciones</h3>
		<div class="row">
			<div class="actions">
				<a href="#" onclick="LoadContent( '#main', '<?=$site_url?>', 'users' )">
					<img src="<?=$template?>images/cancel.png" alt="Cancelar" title="Cancelar" /> Cancelar
				</a>
				<input type="image" src="<?=$template?>images/ok.png" alt="Actualizar" title="Actualizar" class="clean" />
				<input type="submit" value="Actualizar" class="clean" />
			</div>
			<div class="spacer">&nbsp;</div>
		</div>
		<div>&nbsp;</div>
	</div>
</div>
</form>