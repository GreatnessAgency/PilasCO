<div class="QueryStr" style="display: none"><?php echo '?component='.$component->id; ?></div>
<?php foreach( $imgs as $im ){?>
<li id="<?=$im->id;?>_">
	<div class="" style="text-align:center;">
		<div class="int-content ui-state-default ui-corner-all" title="Arrastrar para cambiar la posici&oacute;n" style="cursor:move; width:95%;">
			<span class="ui-icon ui-icon-arrow-4-diag">&nbsp;</span>
		</div>
	</div>
	<div class="">
		<div class="img-gall-content">
			<img src="<?=$filepath.'images/'.$im->value;?>" alt="Imagen" height="100" />
		</div>
	</div>
	<div class="">
		<div class="int-content desc_it"><?=$im->description;?></div>
	</div>
	<div class="">
		<?php if($user->rol_id == 0 || @$this->permisos->edi == 't'){ ?>
		<div class="btn-actions edit_it">
			<a href="#!" title="Editar" onclick="allowUpdate('#<?=$im->id;?>_', '<?php echo $site_url; ?>', '<?=$controller;?>/update_image/<?=$im->id. '/' .$component->id;?>');">
				<img src="<?=$template;?>images/edit.png" border="0"/>
			</a>
		</div>
		<?php if(@$specs->publish == "true"){ ?>
		<div class="btn-actions">
			<a href="#!" style="float:left;"  title="Eliminar"
			onclick="if(confirm('<?=($im->status_id== 'publico')? 'Inhabilitar':'Habilitar';?> esta Imagen?')){LoadContent('#g_<?=$im->content_id.'-'.$component->id;?>', '<?=$site_url?>', '<?=$controller;?>/publish_image/<?=($im->status_id== 'publico')? 'oculto':'publico';?>/<?=$im->id. '/' .$im->content_id. '/' .$component->id;?>', 'noctrl' ); 
			delImage('<?=$im->id;?>'); 
			$('.gallery').sortable( 'refresh' ); }">
			<img src="<?=$template;?>images/<?=($im->status_id== 'publico')? 'true':'false'?>.png" title="Click para <?=($im->status_id== 'publico')? 'Inhabilitar':'Habilitar'?>" />
			</a>
		</div> 
		<?php }} ?>
		<?php 
		if($user->rol_id == 0 || @$this->permisos->del == 't'){
			if(@$specs->delete == "true"){ ?>
		<div class="btn-actions">
            <a href="#!" style="float:left;"  title="Eliminar"
            onclick="if(confirm('Esta seguro de borrar esta imagen?')){LoadContent('#g_<?=$im->content_id.'-'.$component->id;?>', '<?=$site_url?>', '<?=$controller;?>/delete_image/<?=$im->id. '/' .$im->content_id. '/' .$component->id;?>', 'noctrl' ); 
            delImage('<?=$im->id;?>'); 
            $('.gallery').sortable( 'refresh' ); }">
            <img src="<?=$template;?>images/delete.png" alt="Borrar" />
            </a>
		</div>
		<?php }} ?>
	</div>
</li>
<?php }?>