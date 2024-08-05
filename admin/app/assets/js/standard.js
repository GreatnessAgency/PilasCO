// JavaScript Document

function mostrar(id){
	$(id).style.display = "block";
}

function ocultar(id){
	$(id).style.display = "none";
}

function empty(valor){
	if(valor == '' || valor == null){
		return true;
	}else{
		return false;
	}
}

function LoadContent( div, url, params, func, callback ){
	var fullUrl = url + params;
	var loadImage = '<div style="text-align:center"><img src="./app/assets/images/ajax-loader.gif" /> Cargando...</div>';

	if(func != 'noctrl'){
		for( edId in tinymce.editors ) {
			tinymce.get(edId).remove();
			//tinymce.execCommand('mceRemoveControl', false, edId);
		// retira el control del tinyMCE sobre los textareas, al estar dentro del for lo hace por cada textarea; Importante si se quiere volver a ver el editor despues de una recarga ajax...
		}
	}

	$( div ).html( loadImage );
	
	$.ajax({ type: "GET", url: fullUrl,
		success: function( html ){
			$( div ).html( html );
			setTimeout( function(){ $( "#message" ).slideUp( 400 ); }, 1500 );
			getDataTable(url);
			if( func != undefined && func != 'noctrl' ){
				global = func;
				func();
				
			}
			if(typeof callback == "function"){
				callback();
			}
		}
	});
}

function myConfirm( message, div, url, params, func ){
	var conf = window.confirm( message );
	if( conf ){
		LoadContent( div, url, params, func );
	}
}

function editor(urlsitio, parametros, language, select){
	
	var selector = (typeof select != "undefined")? select : "div#general";
	
	tinymce.init({
		selector: selector+' textarea.editor',
		theme: "modern",
		//fontsize_formats: "8pt 9pt 10pt 11pt 12pt 26pt 36pt",
		toolbar1: "insertfile undo redo | cut copy paste pastetext | selectall | styleselect | bold underline italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code",
		menu: {
		 //edit: {title: 'Edit', items: 'cut copy paste pastetext | selectall'}
		},
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste filemanager"
		],
		content_css: 'app/assets/css/editor.css',
		style_formats : [
				{title: "Parrafo general", inline: 'span', classes: 'parrafo_gen'}
				,{title: "Parrafo destacado", inline: 'span', classes: 'parrafo_desta'}
				,{title: "Recuadro en texto", block: 'div', classes: 'pr-box-ct '}
				,{title: "Título 1 destacado", inline: 'span', classes: 'pr-ct-label'}
				,{title: "Título 2 destacado", inline: 'span', classes: 'pr-ct-num t-green'}
		],
		//image_advtab: true,
		relative_urls: false
	//	document_base_url: '',
	});
	
	tinymce.init({
		selector: selector+' textarea.editor-mini',
		theme: "modern",
		//fontsize_formats: "8pt 9pt 10pt 11pt 12pt 26pt 36pt",
		toolbar1: "cut copy paste styleselect | bold underline italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		menu: {
		 //edit: {title: 'Edit', items: 'cut copy paste pastetext | selectall'}
		},
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste filemanager"
		],
		content_css: 'app/assets/css/editor.css',
		style_formats : [
				{title: "Parrafo general", inline: 'span', classes: 'parrafo_gen'}
				,{title: "Parrafo destacado", inline: 'span', classes: 'parrafo_desta'}
				,{title: "Recuadro en texto", block: 'div', classes: 'pr-box-ct '}
				,{title: "Título 1 destacado", inline: 'span', classes: 'pr-ct-label'}
				,{title: "Título 2 destacado", inline: 'span', classes: 'pr-ct-num t-green'}
		],
		//image_advtab: true,
		relative_urls: false
		//	document_base_url: '',
	});
	
	sortable(urlsitio, parametros, language, select);	
	
};// Fin editor

function sortable(urlsitio, parametros, language, select){
	//
	var selector = (typeof select != "undefined")? select : "div#general";
	
	$(selector+' .gallery').sortable({
		revert: false,
		placeholder: "sortable-placeholder",
		update: function( event, ui ){
			$( this ).sortable( "option", "disabled", true );
			var items = '';
			
			$( this ).children( "li" ).each( function(){
				items += $( this ).attr( "id" );
			});
			var queryStr = $(this).find('.QueryStr').text() || "";
			
			var full = urlsitio+parametros+'/update_positions/' + items + queryStr;
			
			$.ajax({ type: "GET", url: full,
				success: function( html ){
					$( ".gallery" ).sortable( "option", "disabled", false );
				}
			});
		}
	});
	
	$("ul, li").disableSelection();
	
	calendar(select);
}; // Fin sortable

function calendar(select){
	
	var selector = (typeof select != "undefined")? select : "div#general";
	
	if($(selector+' input.datepick').length > 0){
		
		$( selector +' input.datepick' ).mouseover( function(){
			$(this).datepicker({
				changeMonth: true,
				changeYear: true,
				monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
				dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
				dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
				dateFormat: 'yy-mm-dd'
			});
		});
	}
	
	//colorpicker
	if($(selector+' input.colorpick').length > 0){
		$(selector+' input.colorpick').miniColors();
	}
	
	//pricepicker
	var numeroDecimales = function(){
		/* your code here */
		var valor = 0; /* example only */
		return valor;
	};
	
	if($(selector+' input.pricepick').length > 0){
		$(selector+' input.pricepick').autoNumeric('init', {
			mDec: numeroDecimales
		});
	}
	
};

var Mitab = function(urlsitio, parametros, language){
		// Idiomas por pestañas
		$('#tabs').tabs({
			tabTemplate: '<li><a href="#{href}">#{label}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>',
			selected: language-1,
			add: function(event, ui) {
				var cont = '#tabs-' + tab_counter;
				clone('div.clon', cont, tab_counter, function(){ Mitab(urlsitio, parametros, language); });
			}
		});
		$( '#tabs span.ui-icon-close' ).die( 'click' );
		$( '#tabs span.ui-icon-close' ).live('click', function() {
			if( msg( 'Esta a punto de borrar un idioma. Desea continuar?' ) ){
				var index = $( 'li', $( '#tabs' ) ).index( $( this ).parent() );
				var ele = $( '#tabs ul li' ).get(index);
				var cont = $( ele ).children('a').attr('href') + ' input.eid';
				var id = $( cont ).val();
				var pos = ( $( ele ).children('a').attr('href') ).replace( '#tabs-', '' );
				var lev1 = "select.lev1 option[value=" + pos + "]";
				var lev2 = "select.lev2 option[value=" + pos + "]";
				var ed = $( ele ).children('a').attr('href')+ ' textarea.editor';
				
				$(ed).each(function(){
					tinyMCE.execCommand('mceRemoveControl', false, $(this).attr('id'));
				});
								
				$.ajax({ type: "GET", url: urlsitio+parametros+'/simple_delete/'+ id,
					success: function( html ){
						$( '#tabs' ).tabs( 'remove', index );
						$( lev2 ).appendTo( "select.lev1" );
						$( "select.lev1" ).attr( "disabled", false );
						$( "select.lev1" ).val( "0" );
					}
				});
			}
		});
		
		editor(urlsitio, parametros, language);
}; // Fin tabs

function cleanConfirm( mesage, url ){
	var conf = window.confirm( mesage );
	if( conf ){
		document.location.href = url;
	}
}

function serializeObject(form){
   var o = {};
   var a = $(form).serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};

function ak_buscalabel(form, ipt){
	var str = ipt.attr('name');
	if(str.indexOf("[]") >= 0){ 
		var name = str.replace('[]', '');
	}else{
		var name = str;
	}
	var label = form.find('label[for='+name+']');
	
	if(label.length > 0){
		var out = label.text() || "";	
		return out;
	}else{
		var out = ipt.attr('placeholder') || "";	
		return out;
	}
}

function ak_validate( form, opts ){
	//@opts { bt, ajax, func}
	var options = {};
	$.extend(options, opts);
	var form = $(form);
	var btn = (options.bt != undefined)? $(options.bt) : form.find('input[type=submit]');
	var inputs = form.find('input, textarea, select');
	var tip = $('.ak-tooltip');

	for(var i = 0; i < inputs.length; i++)
	{
		ipt = $(inputs[i]);
		//
		if(ipt.hasClass('editor') || ipt.hasClass('editor-mini')){
			var cont = tinyMCE.get( ipt.attr('id') ).getContent();
			ipt.val(cont);
		}
		
		if(ipt.hasClass('required') && ipt.val() == ""){
			label = ak_buscalabel(form, ipt);
			ipt.addClass('error');
			ak_showtip( ipt, label+': Este campo es obligatorio');
			return false;
		}else{
			tip.remove();
			ipt.removeClass('error');
		}
		if(ipt.hasClass('email') && ipt.val() != ""){
			if(ipt.val().indexOf('@') == '-1' || ipt.val().indexOf('.') == '-1'){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, 'Verifique el correo electr&oacute;nico.');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		if(ipt.hasClass('price') && ipt.val() != ""){
			var filter=/^([0-9.,]+)*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+': Este campo solo permite n&uacute;meros y punto despues de los centavos.');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		
		if(ipt.hasClass('onlynum') && ipt.val() != ""){
			var filter=/^([0-9]+)*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+': Este campo solo permite n&uacute;meros.');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		if(ipt.hasClass('onlydot') && ipt.val() != ""){
			var filter=/^([0-9.]+)*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+': Este campo solo permite n&uacute;meros y punto (.)');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		if(ipt.hasClass('cedula') && ipt.val() != ""){
			var filter=/^([0-9.-]+)*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+': Este campo solo permite n&uacute;meros, punto (.) y guion (-)');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		if(ipt.hasClass('nicename') && ipt.val() != ""){
			var filter=/^([a-zA-Z0-9\-]+)*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+': No puede contener caracteres $&?!, mayusculas, acentos ni espacios.');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		//
		if(ipt.hasClass('phone') && ipt.val() != ""){
			var filter=/^([0-9-\s]+)*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+' Verifique este campo.');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		
		if(ipt.hasClass('estatura') && ipt.val() != ""){
			var filter=/([0-2]{1})\.([0-9]{2})*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+' El formato correcto es similar a 1.65');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		
		if(ipt.hasClass('fecha') && ipt.val() != ""){
			var filter=/([0-9]{4})-([0-9]{2})-([0-9]{2})*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+' El formato correcto es similar a 1980-07-23');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		
		if(ipt.hasClass('fecha-hora') && ipt.val() != ""){
			var filter=/([0-9]{4})-([0-9]{2})-([0-9]{2})\s([0-9]{2}):([0-9]{2}):([0-9]{2})*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+' El formato correcto es similar a 1980-07-23 10:45:00');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		
		if(ipt.hasClass('fecha-dma') && ipt.val() != ""){
			var filter=/([0-9]{2})\/([0-9]{2})\/([0-9]{4})*$/;
			if(!filter.test(ipt.val())){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+' El formato correcto es similar a 15/03/1980');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}
		}
		
		if(ipt.data('compair')){
			com = form.find(ipt.attr('data-compair'));
			if(ipt.val() != com.val() && ipt.val() != ""){
				label = ak_buscalabel(form, ipt);
				label2 = ak_buscalabel(form, com);
				ipt.addClass('error');
				com.addClass('error');
				ak_showtip( ipt, label+' y '+label2+' Estos campos no pueden ser diferenrtes.');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
				com.removeClass('error');
			}
		}
		
		if(ipt.is('[type=checkbox]') && ipt.hasClass('required')){			
			if(!ipt.is(':checked')){
				label = ak_buscalabel(form, ipt);
				ipt.addClass('error');
				ak_showtip( ipt, label+': Este campo es obligatorio.');
				return false;
			}else{
				tip.remove();
				ipt.removeClass('error');
			}

		}
	}
	
	if(btn.hasClass('deactive') === false){
		btn.addClass('deactive');
		var cortina = $('#cortina');
		var org = btn.html();
		btn.html(' Espere.. ');
		
		if(cortina.length <= 0){
			$('body').prepend('<div id="cortina">&nbsp;</div>');
			cortina = $('#cortina');
		}
		//

		if(options.ajax === false){
			var obj = serializeObject(form);
			btn.removeClass('deactive');
			btn.html(org);
			func = options.func;
			func(obj);
			return false;
		}else if( options.ajax != undefined && options.ajax != false){
			
			 $.ajax({
				type : 'POST',
				data : form.serialize(),
				url : options.ajax,
				success: function(data){
					cortina.remove();
					btn.removeClass('deactive');
					btn.html(org);
					var obj = jQuery.parseJSON(data);
					if(obj.success === false){
						//error al insertar el registro
						alert(obj.msj); 
					} else {
						//exito al insertar el registro
						if(typeof options.func == "function"){
							func = options.func;
							func(obj);	
						}
					}
				},
				error : function(xhr, ajaxOptions, thrownError){
					btn.removeClass('deactive');
					btn.html(org);
					cortina.remove();
					if(options.error != undefined){
						error = options.error;
						error();
					}
				}
			});
		}else{
			form.submit();
			return true;
		}
 	}
	return false;
}

function ak_showtip(ipt, msj){
	//
	$('.ak-tooltip').remove();
	if(ipt == 'remove'){
		return false;
	}
	//
	if(ipt.is(':visible')){
		
		ipt.focus();
		var tip = $('<div class="ak-tooltip">');
		var wid = (ipt.innerWidth() > 100)? ipt.innerWidth() : 100;
		tip.html('<div class="ak-tooltip-int" onclick="ak_showtip(\'remove\');">'+msj+'</div>');
		
		tip.css({
			width: wid
			,top: ipt.offset().top - 6
			,left: ipt.offset().left 
		});	
		
		$('body').prepend(tip);
	}else{
		alert(msj);
	}
}

function sendForm( UForm, div, url, adt, func){
	var params = '';
	var validar;
	var Elements = $(UForm).find('select, textarea, input');
	var total = Elements.length;
	var loadImage = '<div style="text-align:center"><img src="' + url + 'app/images/ajax-loader.gif" /> Cargando...</div>';
	
	for( i = 0; i < total; i++ ){
		var Element = Elements[i];

		validar = Element.id.split( '_' );
		validar[1] = parseInt( validar[1] );
		switch( validar[1] ){
			case 1:
				if( ! empty( Element.value ) ){
					Element.style.border = '1px solid #ccc';
				}else{
					Element.style.border = '1px solid #f00';
					Element.focus();
					alert( 'Verifique el Campo ' + validar[0] );
					return false;
				}
				break;
			
			case 2:
				var filter=/^[A-Za-z0-9_.][A-Za-z0-9_.]*@[A-Za-z0-9_.]+.[A-Za-z0-9_.]+[A-za-z]$/;
				if( filter.test( Element.value ) ){
					Element.style.border = '1px solid #ccc';
				}else{
					Element.style.border = '1px solid #f00';
					Element.focus();
					alert( "Coloca una direccion de correo valida" );
					return false;
				}
				break;
			
			case 3:
				if( Element.value.length < 6 ){
					Element.style.border = '1px solid #f00';
					Element.focus();
					alert('El campo ' + validar[0] + ' debe tener al menos 6 caracteres');
					return false;
				}else{
					Element.style.border = '1px solid #ccc';
				}
				break;
				
			case 4:
				if( Element.value.length > 0 ){
					if( Element.value.length < 6 ){
						Element.style.border = '1px solid #f00';
						Element.focus();
						alert('El campo ' + validar[0] + ' debe tener al menos 6 caracteres');
						return false;
					}else{
						Element.style.border = '1px solid #ccc';
					}
				}else{
					Element.style.border = '1px solid #ccc';
				}
				break;
			case 5:
				var cont = tinyMCE.get( Element.id ).getContent();
				Element.value = cont;
				break;
			case 6:
				var filter=/^([0-9])*$/;
				if( filter.test( Element.value ) ){
					Element.style.border = '1px solid #ccc';
				}else{
					Element.style.border = '1px solid #f00';
					Element.focus();
					alert( "Este campo solo admite números" );
					return false;
				}
				break;	
			case 7:
				var filter=/^[0-9]+(\.[0-9]+)?$/;
				if( filter.test( Element.value ) ){
					Element.style.border = '1px solid #ccc';
				}else{
					Element.style.border = '1px solid #f00';
					Element.focus();
					alert( "Se encontró un error en el campo "+validar[0]+", el formato permitido es numérico [0-9] y punto (.) para expresar decimales. \nEj: 10000.00" );
					return false;
				}
				break;	
		}
	}
	
	var ind = 1;
	var full = url + adt;
	params = $(UForm).serialize();
	$.ajax({ type: "POST", url: full, data: params,
		success: function( data ){
			var obj = jQuery.parseJSON(data);
			if(obj.success == false){
				//error al insertar el registro
                alert(obj.msj); 
            } else {
            	//exito al insertar el registro
               	LoadContent(div,url,obj.params, func);
            }
		}
	});
	
	return false;
}

function cleanSendForm( UForm ){
	var validar;
	var total = UForm.elements.length - 1;
	for(i = 0; i < total; i++){
		validar = UForm.elements[i].id.split('_');
		validar[1] = parseInt(validar[1]);
		switch(validar[1]){
			case 1:
				if(!empty(UForm.elements[i].value)){
					UForm.elements[i].style.border = '1px solid #ccc';
				}else{
					alert('Verifique el campo ' + validar[0]);
					UForm.elements[i].style.border = '1px solid #f00';
					UForm.elements[i].focus();
					return false;
				}
			break;
			case 2:
				var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+.[A-Za-z0-9_.]+[A-za-z]$/;
				if(filter.test(UForm.elements[i].value)){
					UForm.elements[i].style.border = '1px solid #ccc';
				}else{
					alert("Coloca una direccion de correo valida");
					UForm.elements[i].style.border = '1px solid #f00';
					UForm.elements[i].focus();
					return false;
				}
			break;
			case 3:
				if(UForm.elements[i].value.length < 6){
					alert('El campo ' + validar[0] + ' debe tener al menos 6 caracteres');
					UForm.elements[i].style.border = '1px solid #f00';
					UForm.elements[i].focus();
					return false;
				}else{
					UForm.elements[i].style.border = '1px solid #ccc';
				}
			break;
		}
	}
}

function LockAndUnlock( element, lock, unlock ){
	if( element.checked ){
		document.getElementById( lock ).disabled = true;
		document.getElementById( unlock ).disabled = false;
	}else{
		document.getElementById( unlock ).disabled = true;
		document.getElementById( lock ).disabled = false;
	}
}

// ---------------------------------------------------------------------------------------------

function getDocFrame( idFrame ){ 
   var myIFrame = document.getElementById(idFrame); 
   return  myIFrame.contentWindow.document;
}

function DupAndAssign( dup, assign, ind, func ){
	var elem		= $( '#'+ dup ).html();
	var new_elem	= $(elem).get(0);
	var container	= document.getElementById( assign );
	var name		= String( "clone_" + ind );
	var image_id	= String( "Imagen-" + ind + "_1" );
	var item_id	    = String( "Item-" + ind + "_1" );
	var desc_id		= String( "Descripcion-" + ind + "_a" );
	var desc_ob		= String( "Descripcion-" + ind + "_1" );
	var doc_id		= String( "Documento-" + ind + "_1" );
	var yout_id		= String( "Video-Youtube-" + ind + "_1" );
	var file_id		= String( "Archivo-Video-" + ind + "_1" );
	
	var url_a		= String( "url-" + ind + "_a" );
	var url_b		= String( "url-" + ind + "_b" );
		
	new_elem.id		= name;
	
	// Iframe Process
	
	var source	= String( $( new_elem ).find( "div.frame_input iframe" ).attr( "src" ) );
	
	lSt = source.lastIndexOf("/"); 
	tmp = source.substring(0, lSt);
	source	= tmp+'/'+image_id;
	
	var source2	= String( $( new_elem ).find( "div.frame_doc iframe" ).attr( "src" ) );
	
	lSt = source2.lastIndexOf("/"); 
	tmp = source2.substring(0, lSt);
	source2	= tmp+'/'+doc_id;
	
	//dup imput
	elementos = $( new_elem ).find( "input, textarea, select, div" );
	elementos.each(function(){
		element = $(this);
		id = element.attr('id');
		if(id != undefined){
		id = id.split('_');
		req = (id[1] != undefined)? '_'+id[1] :"";
		id = id[0]+'-'+ind+req;
		element.attr('id', id);
		}
	});
	
	// Iframe doc
	$( new_elem ).find( "div.frame_doc iframe" ).attr( "src", source2 );
	// Input Hidden Process
	$( new_elem ).find( "div.frame_doc input" ).attr( "id", doc_id );
	//Iframe image
	$( new_elem ).find( "div.frame_input iframe" ).attr( "src", source );
	// Input Hidden Process
	$( new_elem ).find( "div.frame_input input" ).attr( "id", image_id );	
	// Input Text Title Process
	$( new_elem ).find( "div.input_item input" ).attr( "id", item_id );
	// Input Text Title Process
	$( new_elem ).find( "div.input_link input" ).attr( "id", desc_id );
	$( new_elem ).find( "input.desc_ob" ).attr( "id", desc_ob );
	// Input Text Title Process
	$( new_elem ).find( "div.input_url input.edit_a" ).attr( "id", url_a );
	$( new_elem ).find( "div.input_url input.edit_b" ).attr( "id", url_b );	
	$( new_elem ).find( "div.input_url a" ).attr( "id", name + '.' );
	// Link Remover
	$( new_elem ).find( "div.input_link a" ).attr( "id", name + '.' );
	//	
	new_elem.style.display = "none";
	$( container ).append( new_elem );
	$( new_elem ).slideDown( "slow" );
	
	if( func != undefined && func != 'noctrl' ){
		global = func;
		func();
	}
}

function RemoveDup( elem, assign ){
	var container	= document.getElementById( assign );
	var remover_id	= elem.id.replace( '.', '' );
	var remover		= document.getElementById( remover_id );
	
	$( remover ).slideUp( "slow", function(){
		$( remover ).remove();
	});
	
	rem_bro	 = remover_id.split( '_' );
	delImage( rem_bro[1] );
	
}

function allowUpdate( elem, url, ext, name ){

	var numeral = elem.replace('#','');
	var ids = numeral.replace('_','');
	var urluno = url+'home_gestor/';	
	var fullUrl = url+ext;

	$('#description_banner').dialog({
		modal: true
		,width: 'auto'
		,height: 'auto'
		,resizable: true
		,open: function(){
			if(ids!=""){
				$.ajax({
					url: fullUrl
					, success: function(data){
					var obj = JSON.parse(data);
						var obj = JSON.parse(data);
						for(name in obj){
							$('#formDescription [name='+name+']').val(obj[name]);
						}
					}
				});
			}
		}
		,close: function(event, ui) {
			$(this).find('textarea').val('');
			$(this).dialog('destroy');			
		}
		,buttons:{
			'Guardar descripción': function(){
				var data_serializada = $('#formDescription').serialize();
				var element = data_serializada.split('=');
				var contenido = element[1].replace('+',' '); 
				
              $.ajax({
					  type: 'POST'
					, url: fullUrl
					, data: data_serializada
					, success: function(){
						$( elem+' .desc_it' ).html($('#formDescription textarea[name=description]').val());
						$('#description_banner').dialog('close');
					}
				});
				
			}
			,'Cancelar': function(){
				$(this).dialog('close');
			}
		}
	});
	
}

/*function updateDescription( elem, url, ext, name ){
	var params = "";
	var loadImage = '<div style="text-align:center;"><img src="' + url + 'app/images/ajax-loader-small.gif" /></div>';
	var valor = $( elem +' textarea' ).val();
	var save_btn = $( elem+' .save_it' ).html();
	
	fullUrl = url+ext;
	
	$( elem+' .desc_it textarea' ).attr( "disabled", true );
	$( elem+' .save_it' ).html( loadImage );
	name = (name == undefined)? 'description' : name;
	params += name+"=" + valor;
	
	$.ajax({ 
		type: "POST", 
		url: fullUrl, 
		data: params,
		success: function( html ){
			$( elem+' .desc_it' ).html(valor);
			$( elem+' .edit_it' ).css('display', 'block');
			$( elem+' .save_it' ).html(save_btn);
			$( elem+' .save_it' ).css('display', 'none');	
		}
	});
}*/

//tabs
function clone( elem, cont, pos, func ){	
	// Selectores de Idioma
	lev1 = "select.lev1 option[value=" + pos + "]";
	lev2 = "select.lev2 option[value=" + pos + "]";
	// Nombre del idioma
	lang = $( lev1 ).text();
	// Pasamos el idioma al segundo selector
	$( lev1 ).appendTo( "select.lev2" );
	// Si no quedan idiomas disponibles desactivamos el selector
	if( $( "select.lev1 option" ).length == 1 ) $( "select.lev1" ).attr( "disabled", true );
	// ID's del nuevo idioma	
	sid = "_" + pos; // ID Simple
	eid	= "#" + sid; // ID de Elemento para uso con jQuery
	// Generamos el nuevo idioma
	clon = $( elem ).html();
	$( cont ).html( clon );
	$( cont ).children( "div.clone_me" ).attr( "id", sid );
	$( cont ).children( "div.clone_me" ).children( "h3.title" ).text( lang );
	$( cont ).children( "div.clone_me" ).children( "input.lang" ).val( pos );
	$( cont +" .ndesc" ).attr( "name", "ndesc[" + pos + "][]" );
	$( cont +" .nfile" ).attr( "name", "nfile[" + pos + "][]" );	
	itm = eid + " *[id*='_']";
	// Seleccion de todos los campos validables
	// A cada campo de formulario del nuevo idioma le cambiamos el ID para que pueda ser validado
	$( itm ).each( function(){
		cid = $( this ).attr( "id" );
		$( this ).attr( "id", lang + '-' + cid );
	});
	//modificar los iframes
	iframes = $( cont+' .myframe' );
	//each 
	$(iframes).each(function(){
		src = $(this).attr('src');
		csrc = src.split("/");
		csrc[csrc.length - 1] = lang +'-'+csrc[csrc.length - 1];
		nsrc = csrc.join("/");
		$(this).attr('src', nsrc);	
	});
	// Mostramos los campos del idioma
	$( clon ).slideDown( "slow" );	
	rem = $( clon ).children( "div" ).children( "a.rem" );
	// Evento del Enlace que borra el idioma
	$( rem ).click( function(){
		$( eid ).slideUp( "slow", function(){
			$( eid ).remove();
			$( lev2 ).appendTo( "select.lev1" );
			$( "select.lev1" ).attr( "disabled", false );
			$( "select.lev1" ).val( "0" );
		});
	});
	// Eliminar Tab	
	tab = $( "#tabs ul li" ).get(next_tab);
	del = $( tab ).children( "span.ui-icon-close" );
	$( del ).live('click', function() {
		var index = $( 'li', $( '#tabs' ) ).index( $( this ).parent() );
		$( '#tabs' ).tabs( 'remove', index );
		$( lev2 ).appendTo( "select.lev1" );
		$( "select.lev1" ).attr( "disabled", false );
		$( "select.lev1" ).val( "0" );
	});
	if( func != undefined ){
		global = func;
		func();
	}
}

function addTab( obj, elem ){
	var i = obj.selectedIndex;
	next_tab = $( "#tabs ul li" ).length;
	tab_title	= obj.options[i].text;
	tab_counter = $( obj ).val();
	$( elem ).tabs('add', '#tabs-'+tab_counter, tab_title);
}

function msg( message ){
	return window.confirm( message );
}

function addImage( index ){
	delImage( index );
	if($( '#clone_' + index ).parent().attr('id') === 'images'){
		var clon = $( 'div.dup' ).clone();
		var elem = '_' + index;
		var file = $( '#clone_' + index + ' img.thumbnail' ).attr( 'src' );
		var img  = '.' + elem + ' img.thumbnail';
		var desc = '.' + elem + ' input.desc';
		
		$( clon ).removeClass( 'dup' );
		$( clon ).addClass( elem );
		$( clon ).show();
		$( 'div.images' ).append( clon );
		$( img ).attr( 'src', file );
		$( desc ).attr( 'id', 'Descripcion-' + index + '_1' );
	}
	refreshImages();
}

function delImage( index ){
	var img = 'div.images ._' + index;
	var gal = 'ul.gallery ._'+ index;
	var nim = 'div.nimgs ._'+ index;
	
	$( img ).remove();
	$( gal ).remove();
	$( nim ).remove();
}

var refreshImages = function(){
	var i = 0;
	var mov = 0;
	var lang = new Array();
	
	$( 'select.lev2 option' ).each( function(){
		if( mov > 0 ){
			lang[i] = $( this ).text();
			i++;
		}
		mov++;
	});
	
	k = 0;
	$( "div#tabs div.images" ).each(function(){
		$( "#"+ this.id +" *[id*='_']" ).each( function(){
			cid = $( this ).attr( "id" );
			if( cid.indexOf( lang[k] ) == -1 ){
				$( this ).attr( "id", lang[k] + '-' + cid );
			}
		});
	k++;
	});
}

function valNull(id){
//2011-06-13
	p = id.split('_');
	var kim = $("#"+id).val();
	if (kim != "" || kim != " "){
		$("#"+ p[0] +"_b").val(kim);
	}else{
		$("#"+ p[0] +"_b").val('NULL');
	}
}

function countThis(id){
//2012-01-21
	p = id.split('_');
	var kim = $("#"+id).val();
	if (kim != ""){
		//cuento los caracteres actuales
		numeroCaracteres = kim.length;
		//expresiones regulares de: si hay espacio en blanco al inicio, al final, dos espacios en blanco y los enter 
		primerBlanco = /^ /
		ultimoBlanco = / $/
		variosBlancos = /[ ]+/g
		lineBreaks = /(\r\n|\n|\r)/gm
		//remplazo segun las expresiones
		kim = kim.replace (variosBlancos," ");
		kim = kim.replace (primerBlanco,"");
		kim = kim.replace (ultimoBlanco,"");
		kim = kim.replace (lineBreaks," ");
		//creo el array que compone las palabras
		textoTroceado = kim.split(" ");
		numeroPalabras = textoTroceado.length;
		//
		$("#"+ p[0] +"_c").text( numeroPalabras +' palabras / '+ numeroCaracteres +' caracteres');
	}else{
		$("#"+ p[0] +"_c").text('0 palabras / 0 caracteres' );
		
		}
}

function showMsj(msj){
//2012-03-11
	$('#msj_box').html( msj );
	$('#lightbox').css( 'display','block' );
}

function reportThis(tipo, msj){
//2012-06-08
	padre = $('.reportes-content');
	ramd = Math.floor(Math.random()*1000);
	clas = (tipo === false)? 'error': 'exito';
	elm = 'rep-'+ramd;
	padre.prepend('<div href="#!" id="'+elm+'" class="reportes-item '+clas+'" onclick="$(this).remove();">'+msj+'</div>');
	$('#'+elm ).slideDown(600);
}

function listarImgs(imgs, url, dup, assing){
//2012-06-08 creada
//2015-09-30 se agregan parametros dup and assing
	var clonarDe = dup || 'image_clone';
	var clonarEn = assing || 'images';
	var nu = 1;
	var to = imgs.length;
	$(imgs).each(function(i){
		img = this;
		if(img.status == 1){
			cont++;
			DupAndAssign( clonarDe, clonarEn, cont, function(){	
				if(i <= 0){
					var iptUno  = $('#clone_'+cont).find('input').not('input:hidden').eq(0);
					iptUno.focus();
				}
				var timestamp = (new Date().getTime() / 1000).toFixed(0);
				$('#clone_'+cont).find('.thumbnail').attr('src', url+img.archivo+'?t='+timestamp);
				$('#clone_'+cont).find('#Imagen-'+cont+'_1').val(img.archivo);			
			//	$('#clone_'+cont).find('#Descripcion-'+cont+'_1').val(img.archivo);
				reportThis(true, '<b>'+img.archivo+'</b> cargado con &eacute;xito.');
				addImage(cont);		
			});
		}else{
			reportThis(false, '<b>'+img.archivo+'</b> no se ha podido cargar. <br/><b>Notificación</b>:'+img.reporte);
		}
		nu++;
	});
	if(nu >= to){ setTimeout(function(){
		$('.reportes-content').slideUp(600, function(){
			$('.reportes-content').html("");
			$('.reportes-content').css('display','block');
		});
	}, 2500*to); }	
}

function getDataTable(url){
//2012-07-15
	ths = $('#table thead tr th');
	nu = 0;
	optColums = 'ui-widget-content ui-corner-all" style="position:absolute; z-index:9999; padding:2px;';
	if(ths.length != 0){
		filter = $('<div style="float:left; margin:0 8px;"><img src="./app/assets/images/select_column.png" alt="Ocultar"/> Columnas <div class="opt-colums '+optColums+'"></div></div>');
		ths.each(function(){
			obj = $(this);
			it = '<div style="margin:1px 3px;"><label><input onchange="fnShowHide('+nu+')" checked type="checkbox"/> '+obj.find('.DataTables_sort_wrapper').text()+'</label></div>';
			filter.find('.opt-colums').append(it);
			nu++;
		});
		filter.find('.opt-colums').css('display','none');
		$('#table_length').find('label').css('float','left');
		$('#table_length').append(filter);
		filter.bind({
			mouseenter:function(){ filter.find('.opt-colums').css('display','block'); },
			mouseleave:function(){ filter.find('.opt-colums').css('display','none'); }
		});
	}
}
function fnShowHide(iCol){
//2012-07-15
    /* Get the DataTables object again - this is not a recreation, just a get of the object */
    var oTable = $('#table').dataTable();    
    var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
    oTable.fnSetColumnVis( iCol, bVis ? false : true );
}

function removeHttp(esto){
//2012-11-12
	el = $(esto);
	if(el.val().indexOf('http://') != '-1'){
		el.val(el.val().replace('http://',""));
	}
	if( el.val().indexOf('https://') != '-1'){
		el.val(el.val().replace('https://',""));
	}
}

function transformCur(input){
//2012-11-23
	filter = /^([0-9.]+)*$/;
	if(filter.test(input.value)){
		val = input.value.split('.');
		while(val[0].length > 3 ){
			valor = val[0];
			val.unshift(valor.substring(0, (valor.length-3)));
			val[1] = valor.substring((valor.length-3), valor.length);
		}
		if(val[(val.length - 1)].length > 2){
			val[val.length] = '00';
		}else if(val.length <= 1){
			val[val.length] = '00';
		}
		input.value = val.join('.');
		$(input).css('border-color', '#ccc');
	}else{
		$(input).css('border-color', '#f00');
		alert('Este campo solo puede tener números y puntos (.)');
		return false;
	}
}

function borraImg(a){
//2012-11-23
	$(a).parent().find('input').val('NULL');
	$(a).parent().parent().find('.thumbnail').attr('src', 'images/no_image.gif');
}

function dupAssignVideos(elm){
//2013-02-20
	elm = $(elm);
	id = elm.parents('div[id^=tabs-]').find('.videos').attr('id');
	cont++;
	DupAndAssign( 'video_clone', id, cont, function(){
		clon = $('#clone_'+cont);
		lang = clon.parents('div[id^=tabs-]').find('input[name^=idioma]').val();
		tipovideo = clon.find('input[name^=tipo_video]');
		tipovideo.attr('name','tipo_video['+lang+'][]');	
	});
}

function getVideoLang(esto, url, controller, func){
//antes miSelect
//2013-02-20
	div = esto.id.split('_');
	ide = div[0].split('-');
	lang = $(esto).parents('div[id^=tabs-]').find('input[name^=idioma]').val();
	itemid = (ide[1] != undefined)? '/'+ide[1]: "";

	if(esto.value != ''){
		LoadContent( '#'+ div[0] +'_div', url, controller+'/getvideos/'+ esto.value +'/'+ lang + itemid, 'noctrl');
	}else{
		$('#'+ div[0] +'_div').html('<input name="video[]" type="hidden" value="NULL" /><input name="descripcion_video[]" type="hidden" value="NULL" />');
	}
}


