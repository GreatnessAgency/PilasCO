<?php $cont = 1; ?>
<?php if( isset( $alert ) ):?><div id="message"><?=$alert?></div><?php endif?>
<script type="text/javascript">
var cont = 0;
var tot = 1;
</script>
<form name="ZavForm" onSubmit="return sendForm( this, '#main', '<?=$site_url?>', '<?=$controller;?>/edit/<?=$shared.'/'.$lang?>')" method="post">
<div id="general">
	<div>&nbsp;</div>
	<div class="title"><?=$titulo;?></div>
    <div>&nbsp;</div>
	<div class="tasks">
		<div class="filter" style="padding-top:5px">
			<label><b><?php echo $acto;?> <?=$contenido;?></b></label>
		</div>
		<div class="back">
			<?php $borrar = ($modo=='Crear')? $items[0]->shared : ""; ?>
			<a href="#" onclick="LoadContent( '#main', '<?=$site_url;?>', '<?=$controller;?>/index/0/<?=$lang.'/'.$borrar;?>' )">
				<img src="<?=$template;?>images/back.png" alt="Regresar" title="Regresar" /> Regresar al listado
			</a>
		</div>
		<div class="pages">
			<img src="<?=$template;?>images/info.png" alt="Modo Agregar" title="Modo Agregar" />
			<label>Esta en modo <?php echo $modo;?></label>
		</div>
	</div>
	<div class="content2" style="background:#<?php echo $color;?>">
	<?php if($all_langs > 1){ ?>
        <div class="lang">
			<div class="row">
				<div class="form-content">
					<div class="txt-content">Agregar Idioma:</div>
					<select class="lev1 input" onchange="if(this.value != '') addTab(this,'#tabs')" <?=(count($langs)==0)?'disabled="disabled"':''?>>
						<option>Seleccione...</option>
						<?php foreach( $langs as $l ):?>
						<option value="<?=$l->value;?>"><?=$l->name;?></option>
						<?php endforeach?>
					</select>
				</div>
			</div>
			<div class="row" style="display:none">
				<div style="float:left">
					<select class="lev2">
						<?php foreach( $items as $ls ):?>
						<option value="<?=$ls->lang_id;?>"><?=$ls->lang_name;?></option>
						<?php endforeach?>
					</select>
				</div>
			</div>
		</div>
<!-- Cierro lang -->
    <div>&nbsp;</div>
    <div id="tabs">
        <ul>
			<?php foreach( $items as $key => $i ):?>
				<li>
					<a href="#tabs-<?=$i->lang_id;?>">
						<?=$i->lang_name;?>
					</a>
					<?php if($key!=0):?><span class="ui-icon ui-icon-close">Remove Tab</span><?php endif?>
				</li>
			<?php endforeach?>
		</ul>
	<?php } ?>
        <?php foreach( $items as $key => $i ){?>
		<div id="tabs-<?=$i->lang_id;?>">
        <input type="hidden" name="idioma[]" value="<?=$i->lang_id;?>" />
        <input type="hidden" name="id_item[]" class="eid" value="<?=$i->id;?>" />
        	<?php if($key == 0){?>
			<?php
				$id = $i->id;
				$status_id = $i->status_id;
			/*estado del item key 0 usado para replicarlo en los idiomas nuevos*/ }?>
			<div class="row">
		        <div class="form-content">
		            <div class="txt-content"><span class="c_red">*</span> Nombre de la ciudad</div>
		            <input name="titulo[]" id="Nombre-ciudad_1" class="input" type="text" value="<?php echo @$i->titulo; ?>" />
		        </div>
			</div>
			<div class="row">
				<div class="txt-content"><span class="c_red">*</span> Contenido</div>
				<textarea name="contenido[]" id="Contenido-noticia_5" class="input editor" style="height: 250px;"><?php echo @$i->contenido; ?></textarea>
			</div>
			<h3>Imagen noticia</h3>
			<div class="row" id="Imagen-noticia_div">
				<div class="thumb-content">
					<img class="thumbnail" src="<?php echo (@$i->imagen != "")? $filepath.'images/'.$i->imagen.'?t='.time() : $template.'images/no_image.gif'; ?>" height="71" />
				</div>
				<div class="form-content">
					<div class="txt-content">Imagen : <span class="c_gray"><?=$icon->desc;?></span></div>
					<iframe src="<?=$site_url?>upload/upload_img/<?=$icon->width;?>/<?=$icon->height;?>/Imagen-noticia_1" width="280" marginheight="0" height="25" frameborder="0" scrolling="no"/>
					<input name="imagen" id="Imagen-noticia_1" type="hidden" value="<?php echo $i->imagen;?>" />
				</div>
			</div>
        </div>
		<!-- end tab <?=$i->lang;?> -->
        <?php  }//end foreach?>
	<?php if($all_langs > 1){ ?>
        </div>
		<!-- end tabs -->
	<?php } ?>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
		<div class="row">
			<?php if($modo  == 'Crear'){ ?>
				<div class="col-sm-2">
					<input type="hidden" name="status_id" value="oculto" />
				</div>
				<div class="col-sm-2">&nbsp;</div>
			<?php }else{  if($user->rol_id == 0 || @$this->permisos->pub == 't'){ ?>
			
			<div class="col-sm-2">Estado del contenido: </div>
			<div class="col-sm-2">
					<select name="status_id" class="input">
						<option value="publico" <?php echo ($status_id == 'publico')?'selected="selected"':"";?>> Publico </option>
						<option value="oculto" <?php echo ($status_id == 'oculto')?'selected="selected"':"";?>> Oculto </option>
					</select>
			</div>
			<?php }} ?>
			<div class="col-sm-2">&nbsp;</div>
			<div class="col-sm-6">
				<div class="actions">
					<a href="#!" class="btn" onclick="LoadContent( '#main', '<?=$site_url?>', '<?=$controller?>/index/0/<?=$lang.'/'.$borrar;?>' )">
						<img src="<?=$template?>images/cancel.png" alt="Cancelar" title="Cancelar" /> Cancelar
					</a>
					<button class="btn">
						<img  src="<?=$template?>images/ok.png" title="<?php echo  $boton.' '.$contenido ?>"  /> <?php echo  $boton; ?>
					</button>
				</div>
			</div>
			<div class="spacer">&nbsp;</div>
		</div>
	</div>
<!-- end content2 -->
</div>
<!-- end general -->
</form>
