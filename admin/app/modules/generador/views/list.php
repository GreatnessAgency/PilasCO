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
			<a href="#!" onclick="LoadContent( '#main', '<?=$site_url?>', '<?=$controller;?>/create/<?=$lang;?>',
				function(){ Mitab('<?=$site_url?>', '<?=$controller;?>', <?=$lang;?>) })">
				<img src="<?=$template?>images/add.png" alt="Agregar" title="Agregar" /> Crear nuevo 
			</a>
		</div>
	</div>
	<div style="margin:10px 0;">
		<table id="table" style="width: 100%; text-align:center;">
	        <thead>
				<tr>
					<th>Modulo</th>
					<th>Descripción</th>
					<th>Multiple</th>
					<th>Acciones</th>
				</tr>
	        </thead>
	        <tbody>
	        	<?php  foreach( $items as $item ){ ?>
				<tr>
					<td><?php echo $item->title;?></td>
					<td><?php echo $item->description;?></td>
					<td><?php echo $item->content;?></td>
					<td>
						<a href="javascript:void(0);" onclick="myConfirm('Desea <?=($item->status_id == 'publico')? 'Inhabilitar':'Habilitar';?> este(a) <?=$contenido;?>.'
						, '#main'
						, '<?=$site_url?>'
						, '<?=$controller;?>/publish/<?=($item->status_id == 'publico')? 'oculto':'publico';?>/<?=$item->shared;?>');" class="btn">
							<img title="Click para <?=($item->status_id == 'publico')? 'Inhabilitar':'Habilitar'?>" 
							src="<?=$template;?>images/<?=($item->status_id == 'publico')? 'true':'false'?>.png"> <?=($item->status_id == 'publico')? 'Ocultar':'Publicar'?>
						</a>
						<a href="javascript:void(0);" onclick="LoadContent( '#main'
						, '<?=$site_url?>'
						, '<?=$controller;?>/edit/<?=$item->shared;?>'
						, function(){ Mitab('<?=$site_url?>', '<?=$controller;?>', <?=$lang;?>) });" class="btn">
							<img title="Editar" src="<?=$template;?>images/edit.png"> Editar
						</a>
						<a href="javascript:void(0);" onclick="myConfirm( 'Desea borrar este(a) <?=$contenido;?>'
						, '#main'
						, '<?=$site_url;?>'
						, '<?=$controller;?>/delete/<?=$item->shared;?>' )" class="btn">
							<img title="Eliminar" src="<?=$template;?>images/delete.png" /> Eliminar
						</a>
					</td>
				</tr>
				<?php } ?>
	        </tbody>
	    </table>
	</div>
</div>
