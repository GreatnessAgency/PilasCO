<?php if( isset( $alert ) ):?><div id="message" style="margin-top:10px;"><?=$alert?></div><?php endif?>
<script type="text/javascript">
$(document).ready( function() {
	$('#table').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	} );
});
</script>
<div id="general">
	<div class="title"><?php echo $titulo;?></div>
	<div class="tasks">
		<div class="int-content" style="width:98%;">
			<?php if($user->rol_id == 0 || @$this->permisos->edi == 't'){?>
			<a href="#!" onclick="LoadContent( '#main', '<?=$site_url?>', '<?=$controller;?>/create/<?=$lang;?>/',
				function(){ Mitab('<?=$site_url?>', '<?=$controller;?>', <?=$lang;?>) })">
				<img src="<?=$template?>images/add.png" alt="Agregar" title="Agregar" /> Crear <?php echo $contenido;?>
			</a>
			<?php } ?>
			<div style="float:right;">
				<a href="<?php echo $template;?>guia_admin.pdf" target="_blank" class="btn">
				<img src="<?php echo $template;?>images/help.png" alt="Ayuda" title="Ayuda"> Ayuda</a>
			</div>
		</div>
	</div>
	<div style="margin:10px 0;">
		<table id="table" style="width: 100%; text-align:center;">
	        <thead>
	            <tr>
	                <th>#</th>
	                <th>Nombre <?php echo $contenido;?></th>
	                <th>Acciones</th>
	            </tr>
	        </thead>
	        <tbody>
	        	<?php foreach( $items as $item ){ ?>
				 <tr class="<?=($item->status_id == 'publico')? 'publico':"";?>">
					<td>
						<a class="fancybox" rel="group" href="<?=($item->imagen != "" )? $filepath.'images/'.$item->imagen : $template.'images/no_image.gif';?>" style="cursor: pointer;">
						  <img src="<?=($item->imagen != "" )? $filepath.'images/'.$item->imagen : $template.'images/no_image.gif';?>" height="60" class="img_proj" >
						</a>
					</td>
					<td><?=@$item->titulo;?></td>
					<td>
					<?php if($user->rol_id == 0 || @$this->permisos->pub == 't'){?>
						<a href="#!" onclick="myConfirm(
							'Desea <?=($item->status_id == 'publico')? 'Inhabilitar':'Habilitar';?> este(a) <?=$contenido;?>.'
							, '#main'
							, '<?=$site_url?>'
							, '<?=$controller;?>/publish/<?=($item->status_id == 'publico')? 'oculto':'publico'?>/<?=$item->shared;?>');" class="btn">
							<img title="Click para <?=($item->status_id == 'publico')? 'Inhabilitar':'Habilitar'?>" src="<?=$template;?>images/<?=($item->status_id == 'publico')? 'true':'false'?>.png"> <?=($item->status_id == 'publico')? 'Ocultar':'Publicar'?>
						</a>
					<?php }?>
					<?php if($user->rol_id == 0 || @$this->permisos->edi == 't'){?>
						<a href="#" onclick="LoadContent( '#main', '<?=$site_url?>', '<?=$controller;?>/edit/<?=$item->shared;?>', function(){ Mitab('<?=$site_url?>', '<?=$controller;?>', <?=$lang;?>) });" class="btn">
							<img title="Editar" src="<?=$template;?>images/edit.png"> Editar
						</a>
					<?php }?>
					<?php  if($user->rol_id == 0 || @$this->permisos->del == 't'){?>
						<a href="#" onclick="myConfirm( 'Desea borrar este(a) <?=$contenido;?>', '#main', '<?=$site_url;?>', '<?=$controller;?>/delete/<?=$item->shared;?>' )" class="btn">
							<img title="Eliminar" src="<?=$template;?>images/delete.png" /> Eliminar
						</a>
					<?php }  ?>
					</td>
				</tr>
				<?php } ?>
	        </tbody>
	    </table>
	</div>
</div>
