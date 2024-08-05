<?php $cont = 1; ?>
<?php if( isset( $alert ) ):?><div id="message"><?=$alert?></div><?php endif?>
<script type="text/javascript">
var cont = 0;
var tot = 1;

function enviarZavForm(form){
	ak_validate( form, { 
		ajax:'<?=$site_url?><?=$controller;?>/edit/<?=$shared.'/'.$lang.'/'.$modo;?>'
		, func: function(obj){ 
				//
				LoadContent('#main', '<?=$site_url;?>', obj.params, function(){ Mitab('<?=$site_url?>', '<?=$controller;?>', 1) }); 
			}
		});
	return false;
};

function getAmigable(name, to){
	$.get('<?php echo $site_url.$controller; ?>/getAmigable?string='+name, function(data){
		$(to).val(data);
	});
}

</script>
<form name="ZavForm" onsubmit="return enviarZavForm(this); return false;" method="post">
<div id="general">
	<div>&nbsp;</div>
	<div class="title"><?=$titulo;?></div>
    <div>&nbsp;</div>
	<div class="tasks">
		<div class="filter" style="padding-top:5px">
			<label><b><?php echo $acto.' '.$contenido;?></b></label>
		</div>
		<div class="back">
			<?php $borrar = ($modo=='Crear')? $item->shared : "";  ?>
			<a href="#" onclick="LoadContent( '#main', '<?=$site_url;?>', '<?=$controller;?>/index/<?='/0/'.$lang.'/'.$borrar;?>' )">
				<img src="<?=$template;?>images/back.png" alt="Regresar" title="Regresar" /> Regresar al listado
			</a>
		</div>
		<div class="pages">
			<img src="<?=$template;?>images/info.png" alt="Modo Agregar" title="Modo Agregar" />
			<label>Esta en modo <?php echo $modo;?></label>
		</div>
	</div>
	<div class="content2" style="background:#<?php echo $color;?>">
		<div id="tabs-<?=$item->lang_id;?>">
        	<?php 
				$id = $item->id;
				$status = $item->status_id;
				/*estado del item key 0 usado para replicarlo en los idiomas nuevos*/ 
			?>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label for="title"> <span class="c_red">*</span> Nombre del Modulo </label>
					<input name="title" class="input required" value="<?php echo @$item->title; ?>" onkeyup="getAmigable(this.value,'#ModuloFriendly');" />
					<div>&nbsp;</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<label for="friendly"> <span class="c_red">*</span> Identificador del Modulo  (alfabetico)</label>
					<?php if(@$item->friendly == ""){ ?>
						<input id="ModuloFriendly" name="friendly" class="input required" value="" />
					<?php }else{ ?>
						<div class="input-disable"><?php echo @$item->friendly; ?></div>
					<?php } ?>
					<div>&nbsp;</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<label for="description"> <span class="c_red">*</span> Descripción del Modulo </label>
					<input name="description" class="input required" value="<?php echo @$item->description; ?>" />
					<div>&nbsp;</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<label for="content"> <span class="c_red">*</span> Tipo de modulo </label>
					<select name="content" class="input required">
						<option value=""> -- Seleccione -- </option>
						<option value="unico" <?php echo (@$item->content=='unico')? 'selected="selected"':""; ?>> Único (Unico item) </option>
						<option value="multiple" <?php echo (@$item->content=='multiple')? 'selected="selected"':""; ?>> Multiple (Listado de items) </option>
					</select>
					<div>&nbsp;</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<label for="position"> <span class="c_red">*</span> Orden </label>
					<input name="position" class="input required" value="<?php echo @$item->position; ?>" />
					<div>&nbsp;</div>
				</div>
			</div>
			
			<h4>Componentes del modulo</h4>
			<div>&nbsp;</div>
			<div class="GeneradorSector">
				<div id="itemsGenerador" class="row"></div>
			</div>
			<div>&nbsp;</div>
			<div class="row" style="text-align:center">
				<a href="#!" onclick="agregarEditarComponente( 0, <?php echo $id; ?>, 0);">
					<img src="<?php echo $template;?>images/add.png" alt="Agregar" title="Agregar Componente" />
					<span>Agregar Componente</span>
				</a>
			</div>
			<div>&nbsp;</div>
			<div id="itemsDuplicadores"></div>
       </div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
		<div class="row">
			<?php if($modo  == 'Crear'){ ?>
				<div class="col-sm-2">
					<input type="hidden" name="status_id" value="oculto" />
				</div>
				<div class="col-sm-2">&nbsp;</div>
			<?php }else{ ?>
			<div class="col-sm-2">Estado del contenido: </div>
			<div class="col-sm-2">
				<select name="status_id" class="input">
					<option value="publico" <?php echo ($status == 'publico')? 'selected="selected"' : "";?>> Publico </option>
					<option value="oculto" <?php echo ($status == 'oculto')? 'selected="selected"' : "";?>> Oculto </option>
				</select>
			</div>
			<?php } ?>
			<div class="col-sm-2">&nbsp;</div>
			<div class="col-sm-6">
				<div class="actions">
					<a href="#!" class="btn" onclick="LoadContent( '#main', '<?=$site_url?>', '<?=$controller?>/index/<?='/0/'.$lang.'/'.$borrar;?>', function(){ Mitab('<?=$site_url?>', 'gestor', 1); });">
						<img src="<?=$template?>images/cancel.png" alt="Cancelar" title="Cancelar" /> Cancelar
					</a>
					<button class="btn">
						<img  src="<?=$template?>images/ok.png" title="<?php echo  $boton.' '.$contenido ?>"  /> <?php echo  $boton; ?>
					</button>
				</div>
			</div>
		</div>
		<div class="spacer">&nbsp;</div>
	</div>
<!-- end content2 -->
</div>
<!-- end general -->
</form>
<!-- Inicio tabs CLON -->

<script type="text/javascript">

$(function(){
	var popGen = $( ".popGenerador" );
	if(popGen.length <= 0){
		$('body').append('<div id="popGenerador" class="popGenerador"><form></form></div>');	
	}
});

function consultarDups(ide){
	$.getJSON('<?=$site_url.$controller;?>/get_dups/'+ide, function(resp){
		//
		renderComponents(resp, '#Dup'+ide);
	});
}

function renderComponents(items, Dup){
	var to = Dup || "#itemsGenerador";
	
	if(items){
		if(items.length > 0){
			for(i in items){
				renderComp(items[i], to);
			}
			
		//	$( to ).sortable( "destroy" );
		//	sortGenerador(to);
		}
	}
};

function renderComp(item, Dup){
	var to = Dup || "#itemsGenerador";
	
	var mid = (item.content_id != "")? item.content_id : 0;
	var did = (item.father_id != "")? item.father_id : 0;
	
	var clase = 'col-sm-'+item.size;
		clase += (item.status_id == 'publico')? "" : ' inhabilitado';
		
	var out = '<div id="'+item.id+'_" class="itemComponent '+clase+'"><div class="itemCompInt">';
		out += '<h5><span>'+ item.description+'</span>';
		out += ' ( <a href="#!" onclick="agregarEditarComponente('+item.id+','+mid+','+did+');">'+item.type+'</a> )';
		out += '</h5>';
	out += '</div></div>';
	
	$(to).append(out);
	
	if(item.type == 'duplicator'){
		
		var uot = '<h4>Componentes de '+ item.description +'</h4>'+
					'<div>&nbsp;</div>'+
					'<div class="GeneradorSector"><div id="Dup'+item.id+'" class="row Duplicators">';
			uot += '</div></div><div>&nbsp;</div>';
			uot += '<div>&nbsp;</div>'+
				'<div class="row" style="text-align:center">'+
					'<a href="#!" onclick="agregarEditarComponente( 0, <?php echo $id; ?>, '+item.id+');">'+
						'<img src="<?php echo $template;?>images/add.png" alt="Agregar" title="Agregar Componente" />'+
						'<span>Agregar Componente</span>'+
					'</a>'+
				'</div><div>&nbsp;</div>';
		
		$('#itemsDuplicadores').append(uot);
		//
		setTimeout(function(){
			consultarDups(item.id);
		}, 1500)
	}
	
	$( to ).sortable( "destroy" );
	sortGenerador(to);
};


renderComponents(<?php echo json_encode($item->components); ?>);

function sortGenerador(Dup){
	
	var to = Dup || "#itemsGenerador";
	
	$(to).sortable({
		revert: false,
		placeholder: "sortable-placeholder",
		update: function( event, ui ){
			//
			$( this ).sortable( "option", "disabled", true );
			var items = '';
			$( this ).find( ".itemComponent" ).each( function(){
				items += $( this ).attr( "id" );
			});
			
			var full = '<?php echo $site_url.$controller; ?>/update_positions/' + items;
			
			$.ajax({ type: "GET", url: full,
				success: function( html ){
					$( to ).sortable( "option", "disabled", false );
				}
			});
		},
		start: function( event, ui ) {
			var obj = $(ui.item[0]);

			$(to+' .sortable-placeholder').css({
				width: obj.width()
			//	height: 100
			});
		}
		,opacity: 0.5
	}).disableSelection();
}

function componenteOpciones(tipo, mId, dId){
	var moduleId = mId || 0;
	var dupId = dId || 0;
	var queryStr = '?moduleId='+moduleId+'&dupId='+dupId;
	LoadContent('.compOpciones', '<?php echo $site_url;?>', '<?php echo $controller;?>/get_opts/'+tipo+queryStr, 'noctrl');
}

function agregarEditarComponente(id, moduleId, dupId){
	var ide = id || 0;
	var mid = moduleId || 0;
	var did = dupId || 0;
	
	$( "#popGenerador" ).dialog({
		modal: true
		,width: 600
		,height: 'auto'
		,resizable: true
		,open: function(){
			LoadContent('#popGenerador form', '<?php echo $site_url;?>', '<?php echo $controller;?>/get_item/'+ide+'/'+mid+'/'+did, 'noctrl');
		}
		,buttons:{
			'Guardar': function(){
				ak_validate( '#popGenerador form', { 
					div : '#main'
					,ajax : '<?php echo $site_url.$controller;?>/set_item/'+ide+'/'+mid +'/'+did 
					,func : function(d){
						if(d.success === false){
							alert(d.msj);
							return false;
						}else{
							var obj = d.obj;
							var Dup = (did != 0)? '#Dup'+did : undefined;
							
							//
							if(obj.name != undefined){
								//es nuevo crear elemento
								renderComp(obj, Dup);
							}else{
								//update elemento existente
								var elm = $('#'+ obj.id +'_');
								var status = (obj.status_id == 'publico')? "" : ' inhabilitado';
								
								elm.removeClass (function (index, css) {
									return (css.match (/\bcol-\S+/g) || []).join(' ');
								});
								elm.removeClass( 'inhabilitado');
								elm.addClass( status );
								elm.addClass( 'col-sm-'+obj.size );
								elm.find('h5 span').text( obj.description );
								elm.find('a').text( obj.type );
							}
							//
							$('#popGenerador').dialog('close');
						}
					}
				});
			}
			,'Cancelar': function(){
				$(this).dialog('close');
			}
		}
		
	});
};

function componenteSelector(valor){
	$('#selectorFuente textarea').val('');
	$('#selectorModulos select').val('');
	
	if(valor =='module'){
		$('#selectorModulos').css('display', 'block');
		$('#selectorModulos select').addClass('required');
		$('#selectorFuente').css('display', 'none');
	}else{
		$('#selectorModulos').css('display', 'none');
		$('#selectorModulos select').removeClass('required');
		$('#selectorFuente').css('display', 'block');
	}
}
</script>
