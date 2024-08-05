<?php if(isset( $item )){ ?>
<div class="col-sm-6">
	<label for="description"> <span class="c_red">*</span> Título del campo </label>
	<input name="description" class="input required" value="<?php echo @$item->description; ?>" onkeyup="getAmigable(this.value,'#ComponenteFriendly');" />
	<div>&nbsp;</div>
</div>
<div class="col-sm-6">
	<label for="friendly"> <span class="c_red">*</span> Identificador del campo  (alfabetico)</label>
	<?php if(@$item->name == ""){ ?>
		<input id="ComponenteFriendly" name="friendly" class="input required" value="" />
	<?php }else{ ?>
		<div class="input-disable"><?php echo @$item->name; ?></div>
	<?php } ?>
	<div>&nbsp;</div>
</div>
<div class="col-sm-6">
	<label for="type"> <span class="c_red">*</span> Componente </label>
	<select name="type" class="input required" onchange="componenteOpciones(this.value, <?php echo @$moduleId;?>, <?php echo @$dupId;?>);">
		<option value=""> -- Seleccione 1 tipo -- </option>
		<option value="input" <?php echo (@$item->type=='input')? 'selected="selected"':""; ?>> Input (Texto) </option>
		<option value="select" <?php echo (@$item->type=='select')? 'selected="selected"':""; ?>> Selector </option>
		<option value="textarea" <?php echo (@$item->type=='textarea')? 'selected="selected"':""; ?>> Textarea </option>
		<option value="editor" <?php echo (@$item->type=='editor')? 'selected="selected"':""; ?>> Editor </option>
		<option value="image" <?php echo (@$item->type=='image')? 'selected="selected"':""; ?>> Imagen </option>
		<option value="document" <?php echo (@$item->type=='document')? 'selected="selected"':""; ?>> Documento </option>
		<?php if($dupId == 0){ ?>
		<option value="gallery" <?php echo (@$item->type=='gallery')? 'selected="selected"':""; ?>> Galería </option>
		<option value="duplicator" <?php echo (@$item->type=='duplicator')? 'selected="selected"':""; ?>> Duplicador </option>
		<?php } ?>
		<option value="separator" <?php echo (@$item->type=='separator')? 'selected="selected"':""; ?>> Separador </option>
	</select>
	<div>&nbsp;</div>
</div>
<div class="col-sm-6">
	<label for="size"> Tamaño del Componente </label>
	<select name="size" class="input">
		<option value="12" <?php echo (@$item->size=='12')? 'selected="selected"':""; ?>> 1/1 (100%) </option>
		<option value="6" <?php echo (@$item->size=='6')? 'selected="selected"':""; ?>> 1/2 (50%) </option>
		<?php if($dupId == 0){ ?>
		<option value="4" <?php echo (@$item->size=='4')? 'selected="selected"':""; ?>> 1/3  (33%) </option>
		<option value="8" <?php echo (@$item->size=='8')? 'selected="selected"':""; ?>> 2/3  (66%) </option>
		<?php } ?>
	</select>
	<div>&nbsp;</div>
</div>
<div class="col-sm-6">
	<label for="status_id"> Estado </label>
	<select name="status_id" class="input">
		<option value="oculto" <?php echo (@$item->status_id=='oculto')? 'selected="selected"':""; ?>> Oculto </option>
		<option value="publico" <?php echo (@$item->status_id=='publico')? 'selected="selected"':""; ?>> Público </option>
	</select>
	<div>&nbsp;</div>
</div>
<div class="compOpciones">
<?php } ?>

<?php if(in_array('required', $opciones)){ ?>
<div class="col-sm-6">
	<label for="required">  Obligatorio </label>
	<select name="required" class="input">
		<option value="false"> NO </option>
		<option value="true" <?php echo (@$opt->required == "true")? 'selected="selected"':""; ?>> SI </option>
	</select>
	<div>&nbsp;</div>
</div>
<?php } ?>

<?php if(in_array('length', $opciones)){ ?>

<div class="col-sm-6">
	<label for="length"> <span class="c_red">*</span> Longitud del campo (0 es auto)  </label>
	<input name="length" class="input required onlynum" value="<?php echo @$opt->length; ?>" />
	<div>&nbsp;</div>
</div>

<?php } ?>

<?php if(in_array('validation', $opciones)){ ?>

<div class="col-sm-6">
	<label for="validation">  Validación adicional </label>
	<select name="validation" class="input">
		<option value=""> Ninguna </option>
		<option value="email" <?php echo (@$opt->validation == 'email')? 'selected="selected"':""; ?>> Que sea e-mail </option>
		<option value="onlynum" <?php echo (@$opt->validation == 'onlynum')? 'selected="selected"':""; ?>> Que sea numerico </option>
		<option value="fecha" <?php echo (@$opt->validation == 'fecha')? 'selected="selected"':""; ?>> Que una fecha (yyyy-mm-dd) </option>
	</select>
	<div>&nbsp;</div>
</div>

<?php } ?>

<?php if(in_array('widget', $opciones)){ ?>

<div class="col-sm-6">
	<label for="widget">  Complemento (widget) </label>
	<select name="widget" class="input">
		<option value=""> Ninguno </option>
		<option value="lanlong" <?php echo (@$opt->widget == 'lanlong')? 'selected="selected"':""; ?>> Ubicación ( Mapa ) Double</option>
		<option value="datepick" <?php echo (@$opt->widget == 'datepick')? 'selected="selected"':""; ?>> Calendario (<?php echo date('Y-m-d H:i:s') ?>) </option>
		<option value="colorpick" <?php echo (@$opt->widget == 'colorpick')? 'selected="selected"':""; ?>> Selector color ( #0066ff ) </option>
		<option value="preciopick" <?php echo (@$opt->widget == 'preciopick')? 'selected="selected"':""; ?>> Campo Precio ( 2000.00 ) Double</option>
		<option value="int" <?php echo (@$opt->widget == 'int')? 'selected="selected"':""; ?>> Campo Númerico ( 200 ) Int</option>
	</select>
	<div>&nbsp;</div>
</div>

<?php } ?>

<?php if(in_array('from', $opciones)){ ?>

<div class="col-sm-12">
	<label for="from"> <span class="c_red">*</span> Fuente de los datos </label>
	<select name="from" class="input required" onchange="componenteSelector(this.value);">
		<option value="string" <?php echo (@$opt->from == 'string')? 'selected="selected"':""; ?>> Items separados por coma (,) </option>
		<option value="json" <?php echo (@$opt->from == 'json')? 'selected="selected"':""; ?>> JSON objeto {}</option>
		<option value="module" <?php echo (@$opt->from == 'module')? 'selected="selected"':""; ?>> Items de otro modulo (Relación) </option>
	</select>
	<div>&nbsp;</div>
</div>
<div class="col-sm-12" id="selectorModulos" style="display: <?php echo (@$opt->from == 'module')? 'block':'none'; ?>">
	<label for="module"> <span class="c_red">*</span> Modulo </label>
	<select name="module" class="input <?php echo (@$opt->from == 'module')? 'required':""; ?>" onchange="$('#selectorFuente textarea').val(this.value);">
		<option value=""> Seleccione </option>
		<?php foreach($modules as $module){ ?>
		<option value="<?php echo @$module->id; ?>" <?php echo (@$module->id == @$opt->source)? 'selected="selected"' : ""; ?>> <?php echo @$module->title; ?> </option>
		<?php } ?>
	</select>
	<div>&nbsp;</div>
<?php if(@$dupId == 0){ ?>
	<label for="selectable"> <span class="c_red">*</span> Habilitado para </label>
	<select name="selectable" class="input">
		<option value="one" <?php echo ('only' == @$opt->selectable)? 'selected="selected"' : ""; ?>> Seleccionar 1 Item </option>
		<option value="multiple" <?php echo ('multiple' == @$opt->selectable)? 'selected="selected"' : ""; ?>> Selecctor Multiple </option>
	</select>
	<div>&nbsp;</div>
<?php } ?>
</div>

<div class="col-sm-12" id="selectorFuente" style="display: <?php echo (@$opt->from == 'module')? 'none':'block'; ?>">
	<label for="source"> <span class="c_red">*</span> Contenido de datos </label>
	<textarea name="source" class="input required"><?php echo @$opt->source; ?></textarea>
	<div>&nbsp;</div>
</div>

<?php } ?>

<?php if(in_array('width', $opciones)){ ?>

<div class="col-sm-6">
	<label for="width"> <span class="c_red">*</span> Ancho (0 es auto) </label>
	<input name="width" class="input required onlynum" value="<?php echo @$opt->width; ?>" />
	<div>&nbsp;</div>
</div>

<?php } ?>
<?php if(in_array('height', $opciones)){ ?>

<div class="col-sm-6">
	<label for="height"> <span class="c_red">*</span> Altura  (0 es auto) </label>
	<input name="height" class="input required onlynum" value="<?php echo @$opt->height; ?>" />
	<div>&nbsp;</div>
</div>

<?php } ?>

<?php if(in_array('thumb', $opciones)){ ?>

<div class="col-sm-6">
	<label for="thumb"> Estilo de la miniatura </label>
	<select name="thumb" class="input">
		<option value=""> Al lado del selector  </option>
		<option value="thumb-nostyle" <?php echo (@$opt->thumb == 'thumb-nostyle')? 'selected="selected"':""; ?>> Encima del selector </option>
	</select>
	<div>&nbsp;</div>
</div>

<?php } ?>

<?php if(in_array('formats', $opciones)){ ?>

<div class="col-sm-6">
	<label for="formats"> <span class="c_red">*</span> Formatos separados por coma (,) </label>
	<input name="formats" class="input required" value="<?php echo @$opt->formats; ?>" placeholder="pdf,doc,xls"  />
	<div>&nbsp;</div>
</div>

<?php } ?>

<?php if(in_array('publish', $opciones)){ ?>

<div class="col-sm-6">
	<label for="publish"> Validar estado (Público ó Oculto) </label>
	<select name="publish" class="input">
		<option value="false"> NO  </option>
		<option value="true" <?php echo (@$opt->publish == "true")? 'selected="selected"':""; ?>> SI </option>
	</select>
	<div>&nbsp;</div>
</div>

<?php } ?>

<?php if(in_array('delete', $opciones)){ ?>

<div class="col-sm-6">
	<label for="delete"> Permite eliminar items </label>
	<select name="delete" class="input">
		<option value="false"> NO </option>
		<option value="true" <?php echo (@$opt->delete == "true")? 'selected="selected"':""; ?>> SI </option>
	</select>
	<div>&nbsp;</div>
</div>

<?php } ?>


<?php if(in_array('order', $opciones)){ ?>

<div class="col-sm-6">
	<label for="order"> Preguntar la posición (Orden) </label>
	<select name="order" class="input">
		<option value="false"> NO  </option>
		<option value="true" <?php echo (@$opt->order == "true")? 'selected="selected"':""; ?>> SI </option>
	</select>
	<div>&nbsp;</div>
</div>

<?php } ?>

<?php if(in_array('tot', $opciones)){ ?>

<div class="col-sm-6">
	<label for="tot"> <span class="c_red">*</span> Máximo de elementos (0 es auto) </label>
	<input name="tot" class="input required onlynum" value="<?php echo @$opt->tot; ?>"  />
	<div>&nbsp;</div>
</div>

<?php } ?>


<?php if(isset( $item )){ ?>
</div>
<?php } ?>