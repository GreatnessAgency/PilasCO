<script type="text/javascript">
$(function(){
	killItemsOf();
	
});

function killItemsOf(){
	var dialogos = $('.EditarItemsDe');
	for(i in dialogos){
		if(i > 0){
			$(dialogos[i]).remove();
		}
	}
	
	var dialogos2 = $('.ListadoItemsDe');
	for(i in dialogos2){
		if(i > 0){
			$(dialogos2[i]).remove();
		}
	}
}
	
	
function openBoxListadoItems(ide){
	$('#ListadoItemsDe').dialog({
		modal: true
		,width: 'auto'
		,height: 'auto'
		,resizable: true
		,open: function(){
	//		LoadContent('#ListadoItemsDe', '<?php echo $site_url;?>', '<?php echo $controller;?>/get_items_duplicator/0/'+ide +'/0' , 'noctrl' );
		}
		,close: function(event, ui) {
	//		LoadContent('#Categoria-proyectos_1', '<?php echo $site_url;?>', '<?php echo $controller;?>/get_categorias_select/', 'noctrl' );
			$(this).dialog('destroy');			
		}
	});
}

function agregarEditarItem(iden, fami, component){
	var id = iden || 0;
	var ide = fami || "";
	var comp = component || 0;
	
	if(comp <= 0){
		alert('Error en la ejecución del, componente.');
		return false;
	}
	
	$('#EditarItemsDe').dialog({
		modal: true
		,width: 600
		,height: 'auto'
		,resizable: true
		,open: function(){
			LoadContent('#EditarItemsDe form', '<?php echo $site_url;?>', '<?php echo $controller;?>/get_item_duplicator/'+id+'/'+ide+'/'+comp, 'noctrl', function(){
				editor('<?php echo $site_url;?>', '<?php echo $controller;?>', 1, '#EditarItemsDe form');
			});
		}
		,close: function(event, ui) {
			
			var edts = $('#EditarItemsDe form textarea.editor');
			for(var i=0; i< edts.length; i++) {
				tinymce.get($(edts[i]).attr('id')).remove();
			}
			if($('#EditarItemsDe form input.colorpick').length > 0){
				$('#EditarItemsDe form input.colorpick').miniColors('destroy');
			}
			
			$(this).find('input, select, textarea').val('');
			$(this).dialog('destroy');
			
			killItemsOf();	
		}
		,buttons:{
			'Guardar': function(){
				ak_validate( '#EditarItemsDe form', { 
					div : '#main'
					,ajax : '<?php echo $site_url.$controller;?>/set_item_duplicator/'+id+'/'+ide +'/'+comp 
					,func : function(d){
						LoadContent('#ListadoItemsDe'+ide+'-'+comp, '<?php echo $site_url;?>', '<?php echo $controller;?>/get_items_duplicator/1/'+ide +'/'+comp, 'noctrl' );
						$('#EditarItemsDe').dialog('close');
					}
				});
			}
			,'Cancelar': function(){
				$(this).dialog('close');
			}
		}
	});
}

function PaginationItems(page, div, contentId, componentId){
	var pagina = page || 1;
	var element = div || '#ListadoItemsDe';
	var ide = contentId || 0;
	var comp = componentId || 0;
	LoadContent(element, '<?php echo $site_url;?>', '<?php echo $controller;?>/get_items_duplicator/'+pagina+'/'+ide +'/'+comp , 'noctrl' );
}
</script>


<div id="ListadoItemsDe" class="ListadoItemsDe" style="display: none;"></div>

<div id="EditarItemsDe" class="EditarItemsDe" style="display: none; min-width: 320px;">
	<form style="width:90%; margin:0 auto;" class="row" id="formEditarItemsDe"></form>
</div>