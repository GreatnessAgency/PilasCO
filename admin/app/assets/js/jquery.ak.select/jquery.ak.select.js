jQuery.fn.akselect = function(opts) {
    var obj = {
		placeholder: "-- Select Option --"
		,text: ""
		,change: ""
    };
   
	jQuery.extend(obj, opts);
    
	var select = $(this);
	
    return select.each(function(){
		select.css('display','none');
		var	options = select.find('option');
		var	selected = select.find('option:selected');
		if(selected.length > 0){
			obj.text = selected.text();
		}
		var	custom = '<div class="ak-custom-select-cont">';
		custom+= '<div class="ak-custom-select">';
		custom+= '<div class="ak-custom-select-input">';
		custom+= '<input value="'+obj.text+'" placeholder="'+obj.placeholder+'" />';
		custom+= '</div><div class="ak-custom-select-boton"> &#x25BC;';
		custom+= '</div></div>';
		custom+= '<div class="ak-custom-select-items">';
		custom+= '<ul class="ak-custom-select-list">';
		for(i=0; i<options.length; i++){
			opt = $(options[i]);
			custom+= '<li data-value="'+opt.attr("value")+'" data-filter="'+opt.text()+' '+opt.text().toLowerCase()+'">'+opt.text()+'</li>';
		}
		custom+= '</ul></div></div>';
		select.after(custom);
		//
		var sel = select.next();
		var boton = sel.find('.ak-custom-select-boton');
		var input = sel.find('.ak-custom-select-input input');
		var scustom = sel.find('.ak-custom-select-list');
		var scustomli = sel.find('.ak-custom-select-list li');
		//
		boton.bind('click', function(e){
			scustom.slideToggle('fast');
		});
		
		input.bind('keyup', function(){
			var params = $(this).val().toLowerCase();
			var busqueda = scustom.find("li[data-filter*='"+params+"']");
			scustomli.css('display', 'none');
			scustom.slideDown('fast');
			if(params != "" && busqueda.length > 0){
				$(busqueda).each(function(){
					elm = $(this);
					elm.css('display', 'block');
				});
			}else{
				scustomli.css('display', 'block');
			}
		});
		
		scustomli.bind('click', function(e){
			var li = $(this);
			if(li.attr('data-value') ==""){
				select.val("");
				input.val("");
			}else{
				select.val(li.attr('data-value'));
				input.val(li.text());
			}
			
			select.change();
			scustom.slideUp('fast');
			scustomli.css('display', 'block');
		});
   });
};