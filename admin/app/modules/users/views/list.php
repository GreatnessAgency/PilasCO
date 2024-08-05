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
	<div class="title">Gestor de Usuarios</div>
	<div class="tasks">
		<div class="int-content" style="width:98%;">
		<?php if($user->rol_id == 0 || @$user->permisos->users->cre == 't'){?>	
			<a href="#!" onclick="LoadContent( '#main', '<?=$site_url;?>', 'users/create/')">
				<img src="<?=$template;?>images/add.png" alt="Agregar" title="Agregar" /> Crear nuevo Usuario.
			</a>
		<?php }?>
		<div class="fR">
			<a href="<?=$template;?>images/manuales/Guia Admin Principal.pdf" target="_blank" class="btn">
				<img src="<?=$template?>images/pdf.jpg" alt="Agregar" title="Agregar" /> Descargar Instructivo
			</a>
		</div>
		</div>
	</div>
	<div style="margin:10px 0;">
		<table id="table" style="width: 100%; text-align:center;">
	        <thead>
	            <tr>
	                <th>Nombres</th>
	                <th>Usuario</th>
	                <th>E-mail</th>
	                <th>Tipo</th>
	                <th>Acciones</th>
	            </tr>
	        </thead>
	        <tbody>
	        	<?php foreach( $items as $item ){?>
	             <tr>
	                <td><?=$item->first_name.' '.$item->last_name;?></td>
	                <td><?=$item->username;?></td>
	                <td><?=$item->email;?></td>
	                <td><?=$item->rol;?></td>
	                <td>
					<?php if($user->rol_id == 0 || @$user->permisos->users->pub == 't'){?>
	                	<a href="#!" onclick="myConfirm( 
	                		'Desea <?=($item->status_id == 't')? 'Inabilitar':'Habilitar';?> este(a) <?=$contenido;?>.', '#main', '<?=$site_url?>', '<?=$controller;?>/publish/<?=($item->status_id == 't')? 'f':'t'?>/<?=$item->id;?>')" class="btn">
	                		<img title="Click para <?=($item->status_id == 't')? 'Inabilitar':'Habilitar'?>" src="<?=$template;?>images/<?=($item->status_id == 't')? 'true':'false'?>.png"> <?=($item->status_id == 't')? 'Ocultar':'Publicar'?>
	                	</a>
					<?php }?>
					<?php if($user->rol_id == 0 || @$user->permisos->users->edi == 't'){?>
	                	<a href="#" onclick="LoadContent( '#main', '<?=$site_url?>', '<?=$controller;?>/edit/<?=$item->id;?>')" class="btn">
	                		<img title="Editar" src="<?=$template;?>images/edit.png"> Editar
	                	</a>
					<?php }?>
					<?php if($user->rol_id == 0 || @$user->permisos->users->del == 't'){?>
	                	<a href="#" onclick="myConfirm( 'Desea borrar este(a) <?=$contenido;?>', '#main', '<?=$site_url;?>', '<?=$controller;?>/delete/<?=$item->id;?>' )" class="btn">
	                		<img title="Eliminar" src="<?=$template;?>images/delete.png" /> Eliminar
	                	</a>
					<?php }?>
	                </td>
	            </tr> 
	            <?php }?>             
	        </tbody>
	    </table>
	</div>
</div>