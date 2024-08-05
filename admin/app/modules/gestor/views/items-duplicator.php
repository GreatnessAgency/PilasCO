<?php if($items){ ?>

<table class="zv-table" width="300px">

	<tr>

		<?php foreach($fields as $field){ ?>

		<th><?php echo $field->description;?> </th>

		<?php } ?>

		<th>Acciones</th>

	</tr>

	<?php foreach($items as $item){ ?>

	<tr>

	<?php 

		foreach($fields as $col){

		foreach($item as $llave => $value){

		if($col->name == $llave){

			if($col->type == 'image'){ ?>

			<td><img src="<?php  echo (@$value != "")? $root_url.'/assets/files/images/'.$value.'?t='.time() : $template.'images/no_image.gif'; ?>" height="40" /></td>

		<?php }elseif($col->type == 'editor'){ ?>

			<td><?php echo strip_tags($value);?></td>

		<?php }else{ ?>

			<td><?php echo $value;?></td>

		<?php }?> 

	<?php }}} ?>

		<td>

			<?php if($user->rol_id == 0 || @$this->permisos->edi == 't'){  

				if(@$component->specs->publish == "true"){ ?>

			<a href="#!" onclick="if( confirm('Desea <?=(@$item->status_id== 'publico')? 'Inhabilitar':'Habilitar';?> este item.')){

					LoadContent('#ListadoItemsDe<?php echo $item->content_id.'-'.$component->id;?>', 

					'<?php echo $site_url?>', 

					'<?php echo $controller;?>/pub_item_duplicator/<?=($item->status_id== 'publico')? 'oculto':'publico'?>/<?php echo $item->id.'/'.$item->content_id.'/'.$component->id;?>', 'noctrl'); }">

				<img title="Click para <?=($item->status_id== 'publico')? 'Inhabilitar':'Habilitar'?>" src="<?=$template;?>images/<?=($item->status_id== 'publico')? 'true':'false'?>.png"> 

			</a>

			<?php }  ?>

			<a href="#!" onclick="agregarEditarItem( <?php echo $item->id;?>, <?php echo $item->content_id;?>, <?php echo $component->id;?>);" style="">

				<img src="<?=$template?>images/edit.png" alt="Borrar" title="Editar Información" />

			</a>

			<?php }  ?>

			

			<?php  if($user->rol_id == 0 || @$this->permisos->del == 't'){

			if(@$component->specs->delete == "true"){ ?>

			<a href="#!" onclick="if(confirm('Esta seguro de borrar esta Item?')){

					LoadContent('#ListadoItemsDe<?php echo $item->content_id.'-'.$component->id;?>', '<?=$site_url?>', '<?=$controller;?>/del_item_duplicator/<?=$item->id. '/' .$item->content_id.'/'.$component->id;?>', 'noctrl' );

				}" style="">

				<img src="<?=$template?>images/delete.png" alt="Borrar" title="Eliminar Información" />

			</a>

			<?php }}  ?>

		</td>

	</tr>

	<?php } ?>

</table>

<?php } ?>

<div class="paginador">

	<?php echo $pagination; ?>

</div>