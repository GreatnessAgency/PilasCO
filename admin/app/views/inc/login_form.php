<form id="web_form" onsubmit="return login(this);" method="post">
	<?php if( isset( $msj ) ){echo $msj; }?>	
	<div class="zav-content" style="margin:7px 0;">
		<div class="zav-int-content" style="width:220px;">
            <div class="txt-content">Usuario:</div>
            <input name="username" id="Nombre-usuario_1" type="text" class="ipt-log" value="" />
        </div>
	</div>
	<div class="zav-content" style="margin:7px 0;">
		<div class="zav-int-content"  style="width:220px;">
            <div class="txt-content">Clave:</div>
            <input name="password" id="Clave_1" type="password" class="ipt-log" value="" />
        </div>
	</div>
	<div class="zav-content" style="margin:15px 0;">
		<div class="zav-int-content" style="width:220px;">
			<div style="float:left;">
				<label style="cursor:pointer;">
				<input name="recordarme" type="checkbox" value="f" onclick="($(this).is(':checked'))? this.value='t':this.value='f'"/>
				No cerrar sesi&oacute;n
				</label>
			</div>
			<div style="float:right;">
				<input type="submit" value="Ingresar" class="btn-red">
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">

RAND = <?php echo  $RAND; ?>;

function login(form){
	var user = $('input[name=username]');
	var pass = $('input[name=password]');
	
	if(user.val() == "" || pass.val() ==""){
		alert('Algunos campos obligatorios estan vacios, verifiquelos e intenten nuevamente.');
		return false;
	}
	
	if(RAND.length <= 0){
		alert('Imposible iniciar sesion, refresca esta ventana e intenta nuevamente.');
		return false;
	}
	var norm = pass.val();
	if(norm.length != 32){
		var alpha = ["0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];
		var org = MD5(pass.val());
		var str = new Array();

		for(var i=0, tot=org.length; i<tot; i++ ){
			var c = org.charAt(i);
			str[i] = c;
			for(k in  alpha){
				var letra = alpha[k];
				if(c == letra){
					str[i] = RAND[k];
				}
			}
		}
		
		pass.val(str.join(""));
		
		return sendForm( form, '#login_content', '<?php echo $site_url?>', 'home/login/');
	}

	return false;
}
</script>