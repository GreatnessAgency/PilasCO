<div class="row">
	<div class="form-content">
        <div class="txt-content">Archivo de Video: <span class="c_gray">(FLV)</span></div>
        <select name="video<?=$lang;?>[]" id="Archivo-video<?=$itemid;?>_1" class="input">
			<option value="">Seleccione el archivo...</option>
			<?php foreach( $files as $f ):?>
			<option value="<?php echo $f?>"><?php echo $f?></option>
			<?php endforeach?>
		</select>
    </div>
    <div class="form-content">
        <div class="txt-content">Descripci&oacute;n:</div>
        <textarea name="descripcion_video<?=$lang;?>[]" id="Descripcion-video<?=$itemid;?>_a" class="input" style="height:80px;"></textarea>
    </div>
</div>