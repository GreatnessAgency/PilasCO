<option value="">-- Seleccione --</option>
<?php foreach($categorias as $c){ ?>	
<option value="<?=$c->shared;?>" <?php echo ($c->shared == @$shared_categoria)? 'selected="selected"' : "";?>><?=$c->description;?></option>
<?php } ?>
<option value="editar">Agregar - Editar Categorías</option>