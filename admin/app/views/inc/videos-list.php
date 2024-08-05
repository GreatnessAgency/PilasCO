<?php 
$videos = (isset($i->videos))? $i->videos : array();

foreach($videos as $v){ ?>
<div id="clone_<?=$cont;?>">
	<div class="row">
		<div class="form-content">
			<div class="txt-content">Tipo de video:</div>
			<div style="float:left">
				<select id="<?=$i->lang;?>-video-<?=$cont;?>_1" class="input" onChange="getVideoLang(this, '<?=$site_url;?>', '<?=$controller?>');valNull(this.id);">
					<option value="">-- Seleccione --</option>
					<option value="1" <?=($v->tipo_video == 1)? 'selected="selected"':'';?>>Archivo de Video (FLV)</option>
					<option value="2" <?=($v->tipo_video == 2)? 'selected="selected"':'';?>>Video de Youtube &oacute; Vimeo</option>
				</select>
			</div>
			<input name="tipo_video[<?=$i->lang_id;?>][]" id="<?=$i->lang;?>-video-<?=$cont;?>_b" type="hidden" value="<?=$v->tipo_video;?>" />
		</div>			
	</div>
	<div id="<?=$i->lang;?>-video-<?=$cont;?>_div">
		<?php if($v->tipo_video == 1){?>
			<div class="row">
				<div class="form-content">
					<div class="txt-content">Archivo de Video: <span class="c_gray">(FLV)</span></div>
					<select name="video[<?=$i->lang_id;?>][]" id="<?=$i->lang;?>-archivo-video-<?=$cont;?>_1" class="input">
						<option value="">Seleccione el archivo...</option>
						<?php foreach( $files as $f ):?>
						<option value="<?=$f?>" <?=($v->video == $f)? 'selected="selected"':'';?>><?=$f?></option>
						<?php endforeach?>
					</select>
				</div>
				<div class="form-content">
					<div class="txt-content">Descripci&oacute;n:</div>
					<textarea name="descripcion_video[<?=$i->lang_id;?>][]" id="<?=$i->lang;?>-descripcion-video-<?=$cont;?>_a" class="input" style="height:80px;"><?=$v->descripcion_video;?></textarea>
				</div>
			</div>
		<?php }elseif($v->tipo_video == 2){?>
			<div class="row">
				<div class="form-content">
					<div class="txt-content">Script de Video:</div>
					<textarea name="video[<?=$i->lang_id;?>][]" id="<?=$i->lang;?>-codigo-video-<?=$cont;?>_1" class="input" style="height:80px;"><?=$v->video;?></textarea>
				</div>
				<div class="form-content">
					<div class="txt-content">Descripci&oacute;n:</div>
					<textarea name="descripcion_video[<?=$i->lang_id;?>][]" id="<?=$i->lang;?>-descripcion-video-<?=$cont;?>_a" class="input" style="height:80px;"><?=$v->descripcion_video;?></textarea>
				</div>
			</div>
		<?php }else{?>
			<input name="video[]" type="hidden" value="" />
			<input name="descripcion_video[]" type="hidden" value="" />
		<?php }?>
	</div>
	<div class="form-content input_link">
		<a id="clone_<?=$cont;?>." href="#!" onclick="RemoveDup( this, 'videos' );" style="display:block; text-align:center; margin-top:5px;">
			<img src="<?=$template?>images/delete.png" alt="Borrar" title="Eliminar este video" />
			<span>Eliminar este video</span>
		</a>
	</div>
</div>
<?php $cont++; }?>