<?php if( isset( $alert ) ):?><div id="message" style="margin-top:10px;"><?=$alert?></div><?php endif?>

<script type="text/javascript">

$(document).ready( function() {

	$('#table').dataTable( {

		"bJQueryUI": true,

		"sPaginationType": "full_numbers"

	});

});

</script>

<div id="general">

	<div class="title"><?php echo $titulo;?></div>

	<div class="tasks">

		<div class="int-content" style="width:98%;">

			<?php  if($user->rol_id == 0 || @$this->permisos->edi == 't'){ ?>

			<a href="#!" onclick="LoadContent( '#main', '<?=$site_url?>', '<?=$controller;?>/create/<?=$module->id.'/'.$lang;?>',

				function(){ Mitab('<?=$site_url?>', '<?=$controller;?>', <?=$lang;?>) })">

				<img src="<?=$template?>images/add.png" alt="Agregar" title="Agregar" /> Crear nuevo 

			</a>

			<?php  } ?>

			<!--div style="float:right;">

				<span>Idioma:</span>

				<select onchange="LoadContent( '#main', '<?php echo $site_url?>', '<?php echo $controller; ?>/index/' + this.value )" class="langu input" style="width:150px; height:20px;">

					<?php foreach( $langs as $i ){  ?>

					<option value="<?php echo $i->id?>" <?php echo ($lang == $i->id)?'selected="selected"':''?>><?php echo $i->name?></option>

					<?php } ?>

				</select>

			</div-->

		</div>

	</div>

	<div style="margin:10px 0;">

		<table id="table" style="width: 100%; text-align:center;">

	        <thead>

				<tr>

					<th>&nbsp;</th>

					<?php foreach( $module->components as $k => $comp ){ 

						$attrs = json_decode($comp->attributes);

						if($comp->type == 'duplicator' || ( $comp->type == 'input' && @$attrs->widget =='lanlong')){ continue; }  

						if($k >= 4){ break; } ?>	

						<th><?php echo $comp->description; ?></th>

					<?php } ?>	

					<th>Acciones</th>

				</tr>

	        </thead>

	        <tbody>

	        	<?php  foreach( $items as $item ){ ?>

				 <tr>

					<td>&nbsp;</td>

					<?php foreach( $module->components as $k => $comp ){ 

						$attrs = json_decode($comp->attributes);

						if($comp->type == 'duplicator' || ( $comp->type == 'input' && @$attrs->widget =='lanlong')){ continue; } 

						if($k >= 4){ break; }

						$key = $comp->name; ?>	

						<?php if(  $comp->type == 'image' ){ ?>	

							<td>

								<a class="fancybox" rel="group" href="<?=(@$item->$key != "" )? $filepath.'images/'.@$item->$key : $template.'images/no_image.gif';?>" style="cursor: pointer;">

								  <img src="<?=(@$item->$key != "" )? $root_url.'images/'.@$item->$key : $template.'images/no_image.gif';?>" height="60" class="img_proj" >

								</a>

							</td>

						<?php }else{ ?>

							<td><?php echo @$item->$key;?></td>

						<?php }  ?>	

					<?php }  ?>	

					<td>

						<!--a href="#!" onclick="openPreview('<?=$root_url;?>');" class="btn">

							<img title="Click para previsualizar" src="<?=$template;?>images/preview.png"/> <br/> Ver

						</a-->

					<?php  if($user->rol_id == 0 || @$this->permisos->pub == 't'){?>

						<a href="#!" onclick="myConfirm('Desea <?=($item->status_id == 'publico')? 'Inhabilitar':'Habilitar';?> este(a) <?=$contenido;?>.'

						, '#main'

						, '<?=$site_url?>'

						, '<?=$controller;?>/publish/<?=($item->status_id == 'publico')? 'oculto':'publico'?>/<?=$item->shared.'/'.$module->id;?>');" class="btn">

							<img title="Click para <?=($item->status_id == 'publico')? 'Inhabilitar':'Habilitar'?>" src="<?=$template;?>images/<?=($item->status_id == 'publico')? 'true':'false'?>.png"> <?=($item->status_id == 'publico')? 'Ocultar':'Publicar'?>

						</a>

					<?php  } ?>

					<?php  if($user->rol_id == 0 || @$this->permisos->edi == 't'){?>

						<a href="#!" onclick="LoadContent( '#main'

						, '<?=$site_url?>'

						, '<?=$controller;?>/edit/<?=$module->id.'/'.$item->shared;?>'

						, function(){ Mitab('<?=$site_url?>', '<?=$controller;?>', <?=$lang;?>) });" class="btn">

							<img title="Editar" src="<?=$template;?>images/edit.png"> Editar

						</a>

					<?php  } ?>

					<?php  if($user->rol_id == 0 || @$this->permisos->del == 't'){?>

						<a href="#!" onclick="myConfirm( 'Desea borrar este(a) <?=$contenido;?>'

						, '#main'

						, '<?=$site_url;?>'

						, '<?=$controller;?>/delete/<?=$module->id.'/'.$item->shared;?>' )" class="btn">

							<img title="Eliminar" src="<?=$template;?>images/delete.png" /> Eliminar

						</a>

					<?php  }  ?>

					</td>

				</tr>

				<?php } ?>

	        </tbody>

	    </table>

	</div>

</div>

