<?php
class Ext_Controller extends MX_Controller{
	
	public $tp;
	
	public function __construct(){
		parent::__construct();
		// Inicio de Sesion
		$this->load->library('session');
		// Carga de BD
		$this->load->database(); 
		
		// Carga libreria de enciptacion
		$this->load->library('encrypt');
		// Carga libreria de cookie
		$this->load->helper('cookie');
		// Variables de Plantilla/Vista
		$this->tp = array();
		$this->tp['project'] = $this->config->item('project');
		$this->tp['site_url'] = $this->config->site_url();
		$this->tp['root_url'] = $this->config->item('pagina_url');
		$this->tp['template'] = $this->config->site_url().'app/assets/';		
		$this->tp['filepath'] = $this->config->item('pagina_url').'assets/files/';
		//carpetas de uploads
		$this->img_dir = $this->config->item('upload_path').'/images/';
		$this->doc_dir = $this->config->item('upload_path').'/docs/';
		$this->ruta_videos = $this->config->item('upload_path').'/videos/';
		$this->tmp_dir = APPPATH.'assets/tmp/';
	}	
	public function getTemplate($component, $k, $i){
		//si el tipo de componente es separador crea un nuevo row
		if($component->type == 'separator'){ 
			return '</div><div class="row">'; 
		} 
		//variables aplican a estos inputs
		$site_url = $this->tp['site_url'];
		$template = $this->tp['template'];
		$filepath = $this->tp['filepath'];
		$specs = json_decode(@$component->attributes);
		$requiredStr = (@$specs->required == "true")? '<span class="c_red">*</span>': "";
		$required = (@$specs->required == "true")? 'required': "";	
		$length = (@$specs->length && $specs->length != 0)? 'maxlength="'.$specs->length.'"': "";
		$height = (@$specs->height && $specs->height != 0)? 'min-height:'.$specs->height.'px;': "";
		//busca el valor del campo si existe en el objeto i y la asigna al valor
		$value = "";
		if(array_key_exists($component->name, $i )){
			$key = $component->name;
			$value = $i->$key;
		}
		if(@$specs->widget == 'lanlong'){
			$key = $component->name;
			$lat = 'lat_'.$key;
			$lng = 'lng_'.$key;
			$value = $i->$lat.', '.$i->$lng;
		}
		
		$tm = '<div class="col-sm-'.$component->size.'">';
		
		if($component->type == 'input' || $component->type == 'textarea' || $component->type == 'select'){
			
			$tm .= '<div class="form-content">';
				//label
				$tm .= '<div class="txt-content">'.$requiredStr.' <label for="'.$component->name.'">'.$component->description.'</label></div>';
				//
				if($component->type == 'input'){
					//input
					//widget (lanlong|datepick|colorpick|preciopick)
					if(@$specs->widget == 'lanlong'){
						
						$tm .= '<input name="_lanlong['.$k.']['.$component->name.']" class="input '.$required.' '.@$specs->widget.' '.@$specs->validations.'" '.$length.' type="text" value="'.$value.'" />';
						$tm .= '<a href="#!" onclick="openBox($(this).parent().find(\'input\'));" class="lanlong-trigger">
									<img src="'.$template.'images/search.png" alt="Buscar" title="Ubicar en el mapa" />
								</a>';
					}else{
						$tm .= '<input name="'.$component->name.'[]" class="input '.$required.' '.@$specs->widget.' '.@$specs->validations.'" '.$length.' type="text" value="'.$value.'" />';
					}
				}
				//
				if($component->type == 'textarea'){
					//textarea
					$tm .= '<textarea name="'.$component->name.'[]" class="input '.$required.'" '.$length.' style="'.$height.'">'.$value.'</textarea>';
				}
				//
				if($component->type == 'select'){
					//select
					// onchange="if(this.value == \'editaritems\'){ openBoxListadoItems('.$component->content_id.');}" //funcionalidad si se hace editor de relacion
					
					if(@$specs->selectable == 'multiple' && @$specs->from == 'module'){
						$tm .= '<select name="_multiSelect['.$k.']['.$component->name.'][]"  class="input '.$required.'" multiple="multiple">';
					}else{
						$tm .= '<select name="'.$component->name.'[]"  class="input '.$required.'">';
					}
					$tm .= '<option value="">-- Seleccione --</option>';
					

					if(@$specs->from == 'string'){
						$opts = explode(',', $specs->source);
						foreach($opts as $l => $op){
							$selected = ($value == ($l+1))? 'selected="selected"' : "";
							$tm .= '<option value="'.$op.'" '.$selected.'>'.$op.'</option>';
						}
					}
					if(@$specs->from == 'json'){
						$opts = json_decode($specs->source);
						foreach($opts as $l => $op){
							$selected = ($value == $l)? 'selected="selected"' : "";
							$tm .= '<option value="'.$l.'" '.$selected.'>'.$op.'</option>';
						}
					}
					
					if(@$specs->from == 'module'){
						//obener el listado de items validos del modulo seleccionado
						$moduleId = @$specs->module;
						//nombre de la tabla a consultar
						$this->db->select('friendly');
						$module = $this->db->get_where('modules', array('id' => $moduleId))->row();
						//nombre del campo a a mostrar al usuario
						$this->db->select('name');
						$this->db->order_by('position', 'ASC');
						$componente = $this->db->get_where('module_fields', array('content_id' => $moduleId, 'type' => 'input'))->row();
						//registros a consultar
						$name = $componente->name;
						$this->db->select('shared, '.$name);
						$this->db->order_by('position', 'ASC');
						$opts = $this->db->get_where($module->friendly, array('status_id' => 'publico'))->result();
						
						$itemsSelectIds = array();
						if(@$specs->selectable == 'multiple'){
							
							$this->db->select('friendly');
							$modulo = $this->db->get_where('modules', array('id' => $component->content_id))->row();
							
							$selectName = $component->name.'_id';
							$relation = $modulo->friendly.'_has_'.$component->name;
							
							
							$this->db->select($selectName);
							$this->db->where($modulo->friendly.'_id', $i->id);
							$itemsSelect = $this->db->get($relation)->result();
							
							foreach($itemsSelect as $iselect){
								$itemsSelectIds[] = $iselect->$selectName;
							}
							 
						}
						
						foreach($opts as $l => $op){
							if(@$specs->selectable == 'multiple'){
								$selected = (in_array( $op->shared, $itemsSelectIds))? 'selected="selected"' : "";
							}else{
								$selected = ($value == $op->shared)? 'selected="selected"' : "";
							}
							$option = @$op->$name;
							$tm .= '<option value="'.$op->shared.'" '.$selected.'>'.$option.'</option>';
						}
					//	$tm .= '<option value="editaritems">Agregar - Editar '.$component->description.'</option>';
					}
					
					$tm .= '</select>';
				}
			//	
			$tm .= '</div>';
		}
		if($component->type == 'editor'){
			//label
			$tm .= '<div class="txt-content">'.$requiredStr.' <label for="'.$component->name.'">'.$component->description.'</label></div>';
			$tm .= '<textarea name="'.$component->name.'[]" id="Editor'.@$i->id.'-'.$component->id.'" class="editor '.$required.'"  style="'.$height.'">'.$value.'</textarea>';
		}
		if($component->type == 'image'){
			//variables componente galeria
			$descAncho = (@$specs->width && $specs->width != 0)? $specs->width.'px' : 'Escala';
			$descAlto = (@$specs->height && $specs->width != 0)? $specs->height.'px' : 'Escala';
			$elAncho = (@$specs->width && $specs->width != 0)? $specs->width : 'scale';
			$elAlto = (@$specs->height && $specs->height != 0)? $specs->height : 'scale';
			
			$theImage = $template.'images/no_image.gif';
			
			if($value != "" && file_exists($this->img_dir.$value)){
				$theImage = $filepath.'images/'.$value;
			}
			
			
			$tm .= '<h5>'.$component->description.'</h5>';
			$tm .= '<div id="Imagen'.@$i->id.$component->id.'_div">
						<div>&nbsp;</div>
						<div class="thumb-content '.@$specs->thumb.'">
							<img class="thumbnail" src="'.$theImage.'" height="71" />
						</div>
						<div class="form-content frame_input">
							<div>&nbsp;</div>
							<div class="txt-content">'.$requiredStr.' Imagen: <span class="c_gray">('.$descAncho.' <sup>*</sup> '.$descAlto.')</span></div>
							<iframe src="'.$site_url.'upload/upload_img/'.$elAncho.'/'.$elAlto.'/Imagen'.@$i->id.$component->id.'_a" width="280" marginheight="0" height="25" frameborder="0" scrolling="no"/>
							<input name="_compImage['.$k.']['.$component->name.']" id="Imagen'.@$i->id.$component->id.'_a" class="'.$required.'" placeholder="'. $component->description.'" type="hidden" value="'.$value.'" />
						</div>
						<div>&nbsp;</div>
					</div>';
		}
		if($component->type == 'document'){
			$tm .= '<h5>'. $component->description.'</h5>';
			
			$docActual = "";
			$theImage = "images/filetypes/no-file.png";
			//
			if($value != "" && file_exists($this->doc_dir.$value)){
				$inf = pathinfo($this->doc_dir.$value);
				$docActual = '<br/><strong>Archivo actual: <a href="'.$filepath.'docs/'.@$value.'" target="_blank" style="color:#A41010;"> Descargar </a></strong>';
				$theImage = "images/filetypes/file.".$inf['extension'].".png";
				$theDocument = $filepath.'docs/'.$value;
			}
			
			$formatStr = (@$specs->formats)? strtoupper($specs->formats) : 'PDF';
			$formats = (@$specs->formats)? str_replace(",","-", $specs->formats) : 'pdf';
			
			$tm .= '<div style="text-align:center">
						Los nombres de los archivos NO pueden contener caracteres especiales ni acentos. formato: <strong>'.$formatStr.'</strong>'.$docActual.'
					</div>
					<div id="Document'.@$i->id.$component->id.'_div">
						<div>&nbsp;</div>
						<div class="thumb-content '.@$specs->thumb.'">
							<img class="thumbnail" src="'.$template.$theImage.'" height="71" />
						</div>
						<div class="form-content">
							<div>&nbsp;</div>
							<div class="txt-content">'.$requiredStr.' Documento: <span class="c_gray">'.$formatStr.'</span></div>
							<iframe src="'.$site_url.'upload/upload_file/'.$formats.'/Document'.@$i->id.$component->id.'_a" width="280" marginheight="0" height="25" frameborder="0" scrolling="no" />
							<input name="_compDocument['.$k.']['.$component->name.']" id="Document'.@$i->id.$component->id.'_a" class="'.$required.'" placeholder="'. $component->description.'" type="hidden" value="'.$value.'" />
						</div>
						<div>&nbsp;</div>
					</div>';
		}
		if($component->type == 'gallery'){
			//variables componente galeria
			$descAncho = (@$specs->width && $specs->width != 0)? $specs->width.'px' : 'Escala';
			$descAlto = (@$specs->height && $specs->width != 0)? $specs->height.'px' : 'Escala';
			$elAncho = (@$specs->width && $specs->width != 0)? $specs->width : 'scale';
			$elAlto = (@$specs->height && $specs->height != 0)? $specs->height : 'scale';
			//traer gallery view
			$gallery = "";
			if(count($value) > 0){
				$this->tp['imgs'] = $value;
				$this->tp['component'] = $component;
				$this->tp['specs'] = $specs;
				$gallery = $this->load->view('gallery', $this->tp, true);
			}
			//
			$tm .= '<h4>'. $component->description.'</h4>';
			$tm .= '<div><ul id="g_'.@$i->id.'-'.$component->id.'" class="gallery">'.$gallery.'</ul></h4>';
			$tm .= '<div style="text-align:center">
						Al agregar una imagen debe tener en cuenta que tenga alguno de los siguientes formatos: <strong>JPG, GIF, PNG</strong><br />
						Los nombres de los archivos no pueden contener caracteres especiales ni acentos, Maximo peso de carga: <strong>2Mb</strong>.
					</div><div>&nbsp;</div>
					<div id="images'.@$i->id.'-'.$component->id.'" class="border-bottom"></div>
					</div><div>&nbsp;</div>
					<!--[if (gte IE 9)|!(IE)]><!--> 
					<div class="row">
						<div class="form-content">
							<div class="txt-content">Imagenes: <span class="c_gray">('.$descAncho.' <sup>*</sup> '.$descAlto.')</span></div>
							<iframe src="'.$site_url.'upload/upload_multiple_imgs/'.$elAncho.'/'.$elAlto.'/dup'.@$i->id.'-'.$component->id.'/images'.@$i->id.'-'.$component->id.'" width="280" marginheight="0" height="25" frameborder="0" scrolling="no"/>
						</div>			
					</div><!--<![endif]-->
					<!--<![endif]-->
					<!--[if lt IE 9 ]> 
					<div style="text-align:center;">
						<a href="#!" onclick="cont++; DupAndAssign( \'dup'.@$i->id.'-'.$component->id.'\', \'images'.@$i->id.'-'.$component->id.'\', cont );">
							<img src="'.$template.'images/add.png" alt="Agregar" title="Agregar imagen a la Galer&iacute;a" />
							<span>Agregar imagen a la Galer&iacute;a</span>
						</a>
					</div>
					<![endif]-->
					<script id="dup'.@$i->id.'-'.$component->id.'" type="text/template">
						<div class="border-top">
							<div>&nbsp;</div>
							<div class="thumb-content '.@$specs->thumb.'">
								<img class="thumbnail" src="'.$template.'images/no_image.gif" height="71" />
							</div>
							<div class="form-content frame_input">
								<div class="txt-content">Imagen: <span class="c_gray">('.$descAncho.' <sup>*</sup> '.$descAlto.')</span></div>
								<iframe src="'.$site_url.'upload/upload_img/'.$specs->width.'/'.$specs->height.'/Imagen" width="280" marginheight="0" height="25" frameborder="0" scrolling="no"/>
								<input name="_compGallery['.$k.']['.$component->name.'][image][]" id="Imagen" type="hidden" value="" />
							</div>
							<div class="form-content input_link">
								<div class="txt-content">'.$requiredStr.' Descripci&oacute;n:</div>
								<input name="_compGallery['.$k.']['.$component->name.'][desc][]" class="input '.$required.' desc_ob" type="text" '.$length.' />
								<a id="" href="#!" onclick="RemoveDup( this, \'images\' );" style="display:block; text-align:center; margin-top:5px;">
									<img src="'.$template.'images/delete.png" alt="Borrar" title="Eliminar esta imagen" />
									<span>Eliminar esta imagen</span>
								</a>
							</div>
							<div>&nbsp;</div>
						</div> 
					</script>';
		}
		if($component->type == 'duplicator'){
			//
			$controller = $this->tp['controller'];
			
			$tm .= '<h4>'. $component->description.'</h4>';
			$tm .= '<div id="ListadoItemsDe'.@$i->id.'-'.$component->id.'"></div>
				<script>
					$(function(){
						LoadContent("#ListadoItemsDe'.@$i->id.'-'.$component->id.'", "'.$site_url.'", "'. $controller.'/get_items_duplicator/1/'.@$i->id.'/'.$component->id.'", "noctrl");
					});
				</script>
				<div>&nbsp;</div>
				<div class="row" style="text-align:center">
					<a href="#!" onclick="agregarEditarItem( 0, '. @$i->id.', '.$component->id.');">
						<img src="'.$template.'images/add.png" alt="Agregar" title="Agregar '.$component->description.'" />
						<span>Agregar '.$component->description.'</span>
					</a>
				</div>';
		}
		$tm .= '<div>&nbsp;</div>';
		$tm .= '</div>';
		
		return $tm;
	}
	
	function debug($arr=array(), $exit=false ){
		echo '<pre>';
			print_r($arr);
		echo '</pre>';
		
		if($exit){
		exit();
		}
	}

	public function formatSizeUnits($bytes){
		if ($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' Gb';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' Mb';
		}
		elseif ($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' Kb';
		}
		elseif ($bytes > 1)
		{
			$bytes = $bytes . ' bytes';
		}
		elseif ($bytes == 1)
		{
			$bytes = $bytes . ' byte';
		}
		else
		{
			$bytes = '0 bytes';
		}
		return $bytes;
	}
	
	public function miPaginador($cont, $page, $div, $padreId, $componentId){
		$paginacion = "";
        $div = "'".$div."'";
		if($cont > 1){
			for($i=1; $i< $cont+1; $i++) {
				if($i==$page){ 
					$paginacion .= '<span>'.$i.'</span>';
				}else{ 
					$paginacion .= '<a href="javascript:void(0)" onclick="PaginationItems('.$i.', '.$div.', '.$padreId.', '.$componentId.');">'.$i.'</a>';
				}
			}
		}
		return $paginacion;
	}
	
	public function smtpMail($to="", $subject="", $message="", $replyto="" ){
		include(APPPATH."libraries/phpmailer/class.phpmailer.php"); 
		include(APPPATH."libraries/phpmailer/class.smtp.php"); 
		//variables previas al envio
		$this->mail = new PHPMailer(); 
		$this->mail->IsSMTP(); 
		$this->mail->SMTPAuth = true; 
		$this->mail->SMTPSecure = "ssl"; 
		$this->mail->Host = "smtp.gmail.com"; 
		$this->mail->Port = 465; 
		$this->mail->Username = "alejandro.santos@zavgroup.com"; 
		$this->mail->Password = "zaV_0147@!-";
		
		//funciones de envio
		$this->mail->ClearAllRecipients(); 
		$this->mail->From = "no-contestar@zavgroup.com"; 
		$this->mail->FromName = "Soporte Zav Group"; 
		$this->mail->Subject = utf8_decode( @$subject ); 
	//	$this->mail->AltBody = "E"; 
		$this->mail->MsgHTML(utf8_decode($message)); 
	//	$this->mail->AddAttachment("files/files.zip"; 
		$this->mail->AddAddress($to); 
	//	$this->mail->AddBCC("aker@zavgroup.com"); 
	//	$this->mail->AddBCC("alejandro.santos@zavgroup.com"); 
		$this->mail->AddReplyTo($replyto); 
		$this->mail->IsHTML(true); 	
		
		if($this->mail->Send()){
			return true;
		}else{
			return false;	
		}
	}
	
	public function isLoggedIn(){
		//tiempo ultima actividad
		$last_activity = $this->session->userdata('last_activity');
		//si ha pasado mas de 1 hora cierra la session
		if( $last_activity + 3600 <= time() || !$this->session->userdata('uid')){
			$mensaje = '<div style="font-family:verdana; font-size:12px;">
			<div style="font-size:18px; color:#ccc;">Su sesi&oacute;n ha expirado.</div>
			<div>Usted debera volver a iniciar sesi&oacute;n nuevamente.</div></div>
			<script>setTimeout(function(){document.location.href="'.$this->config->site_url().'"},2000)</script>';
			$this->session->sess_destroy();
			exit($mensaje);
		}else{
			//si no ha pasado 1 hora actualiza last_activity al tiempo actual
			$this->session->set_userdata( 'last_activity', time() );
		}
	}
	
	public function setCurrentUser($modulo=""){	
		$recordar = get_cookie('zav_user');
		//si existe la cookie zav_user resulta el value si no es vacio

		if($recordar != "" ){
		//decodifica el value con el helper de codeigniter el resultado es un json
			$decode = $this->encrypt->decode( $recordar );
		//decodifico el json y lo convierto en array
			$usuario = json_decode( $decode );
		//busco el usuario con los datos del array
			if (!$usuario == '') {
				/*$zav = $this->db->get_where('users', array('username' => $usuario->name, 'password' => $usuario->pass ), 1)->row();
			//inserto en la sesion el id del usuario y actualizo last_activity 
				$this->session->set_userdata( 'uid', $zav->id );
				$this->session->set_userdata( 'last_activity', time() );*/
			}
		}
		
		if($this->session->userdata('uid')){
			$this->uid = $this->session->userdata('uid');
			$query = $this->db->get_where('users', array('id' => $this->uid), 1);
			$this->user = $query->row();
			
			//obtener permisos del rol al que pertenece
			//echo "<pre/>"; print_r($this->user->rol_id); 
			$tableUser = $this->db->dbprefix."users";
			$tableRoles = $this->db->dbprefix."type";
			$tableSpecs = $this->db->dbprefix."rol_specs";
			
			$queryR = "SELECT s.specs as sp
						FROM $tableUser AS u
						INNER JOIN $tableRoles AS r ON (r.value = IF(u.rol_id = 0,1,u.rol_id))
						INNER JOIN $tableSpecs AS s ON (r.id = s.specs_id)
						WHERE r.type_id = 2 
						AND u.id = ".$this->user->id;
						
			$row = $this->db->query($queryR)->row();
			if(isset($row->sp)){
				$obj = json_decode($row->sp);
				$this->user->permisos = @$obj->permisos;
			}
			else{//original
				$this->user->permisos = array();
				//extrer el json de specs
				if($this->user->specs != ""){
					$obj = json_decode($this->user->specs);
					$this->user->permisos = @$obj->permisos;
				}
			}
			
			$this->permisos = array();
			$this->tp['permisos'] = array();
			
			if($modulo != ""){
				foreach($this->user->permisos as $k => $per){
					if($k == $modulo){
						$this->permisos = $per;
						$this->tp['permisos'] = $per;
					}
				}
			}
			
			$this->tp['user'] = $this->user;
		}
	}
	
	public function _empty_dir( $dir ){
		$archivos = array();
		$cdir = opendir( $dir );
		while( $archivo = readdir( $cdir ) ){
			if( $archivo != '..' && $archivo != '.' ){
				$archivos[count( $archivos )] = $dir . $archivo;
			}
		}
		foreach( $archivos as $borrar ){
			if(is_dir($borrar)){
				$this->_empty_dir($borrar.'/');
				rmdir( $borrar );
			}else{
				unlink( $borrar );
			}
		}
	}

	
	public function miCambio($string, $space="_", $dot = null) {
        $this->load->helper('text');
		$string = convert_accented_characters($string);
        if (!$dot) {
            $string = preg_replace("/[^a-zA-Z0-9 \-]/", "", $string);
        } else {
            $string = preg_replace("/[^a-zA-Z0-9 \-\.]/", "", $string);
        }
        $string = trim(preg_replace("/\\s+/", " ", $string));
        $string = strtolower($string);
        $string = str_replace(" ", $space, $string);
        return $string;
    }
	
	function miFecha($fecha){
			if($fecha != '0000-00-00'){
				$fechac = explode("-", $fecha);  // declaro el array
				$mes= $fechac[1];
				$dia = substr($fechac[2], 0, 2);
				$año = $fechac[0];
				$m1     = array("01","02","03","04","05","06","07","08","09");
				$m2     = array("1","2","3","4","5","6","7","8","9");
				$mes= str_replace($m1,$m2,$mes);
				$mesArray = array( 
				1 => "Enero",
				2 => "Febrero",
				3 => "Marzo",
				4 => "Abril",
				5 => "Mayo",
				6 => "Junio",
				7 => "Julio",
				8 => "Agosto",
				9 => "Septiembre",
				10 => "Octubre",
				11 => "Noviembre",
				12 => "Diciembre" 
				);
				$mesReturn = $mesArray[$mes];
				return $mesReturn." ".$dia." de ".$año;
			}
			else{
				return '0000-00-00';
			}
	}

	public function lowText($content, $char){
    	$content = htmlspecialchars_decode( $content );
		$content = strip_tags( $content );
		if( str_word_count( $content ) > $char ){
			$oper = explode( ' ', $content );
			$deduc = array_chunk( $oper, $char );
			$content = implode( ' ', $deduc[0] ) . '...';
		}
    	return $content;
    } 
	
	public function set_msj($type, $msj){
		$message = '<div id="message" class="msj-'.$type.' zav-corner-all-6">
			<div class="message">'.$msj.'</div>
		</div>
		<script type="text/javascript"> 
		$(document).ready(function(){
			 $("#message").slideDown(400); 
			 setTimeout( function(){ $( "#message" ).slideUp( 400 ); }, 4000 );
		});
		</script>';
		
		return $message;
	}
}
?>