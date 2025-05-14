<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author ZavGroup
 * @version 1.0
 * @
 */
class Main extends Ext_Controller {	
	public function __construct(){
		
		parent::__construct();
		$this->load->library('email');
		$this->tp['body_id'] = 'home';		
		$this->tp['title'] = 'Pilas con el ambiente - ANDI';           
		$this->tp['controller'] = 'main';
		date_default_timezone_set("America/Bogota");
		
		$this->diplomados = array(
			'1' => 'Pilas con el ambiente',
			'2' => 'Pilas con el ambiente'
		);
		$this->links = array(
				'1' => 'https://pilascolombia.com/landing/2?utm_source=referido&utm_medium=correo+electronico&utm_content=landing+1&utm_campaign=Linkedin',
				'2' => 'https://pilascolombia.com/landing/2?utm_source=referido&utm_medium=correo+electronico&utm_content=landing+2&utm_campaign=Linkedin',
		);
		
		//variables de conversion google una por carrera 
		$this->conversion = array(
		'1' => '
				<!-- Google Code para blanqueamiento -->
				<script type="text/javascript">
				/* <![CDATA[ */
				/*
				var google_conversion_id = 995568818;
				var google_conversion_language = "es";
				var google_conversion_format = "1";
				var google_conversion_color = "ffffff";
				var google_conversion_label = "32diCOaFlwQQstnc2gM"; var google_conversion_value = 10000;
				*/
				/* ]]> */
				</script>
				<!--script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js"></script-->
				<noscript>
				<div style="display:inline;">
				<!--img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/995568818/?value=10000&amp;label=32diCOaFlwQQstnc2gM&amp;guid=ON&amp;script=0"/-->
				</div>
				</noscript>',
		'2' => '
				<!-- Google Code para blanqueamiento -->
				<script type="text/javascript">
				/* <![CDATA[ */
				/*
				var google_conversion_id = 995568818;
				var google_conversion_language = "es";
				var google_conversion_format = "1";
				var google_conversion_color = "ffffff";
				var google_conversion_label = "32diCOaFlwQQstnc2gM"; var google_conversion_value = 10000;
				*/
				/* ]]> */
				</script>
				<!--script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js"></script-->
				<noscript>
				<div style="display:inline;">
				<!--img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/995568818/?value=10000&amp;label=32diCOaFlwQQstnc2gM&amp;guid=ON&amp;script=0"/-->
				</div>
				</noscript>'
		);
		
	}
	
	/*
	* Si se modifican los cases (url's) se deben agregar o modificar tambien 
	* en el archivo config/routes.php 
	* publicidad-digital|publicaciones-digitales-interactivas|produccion-de-fotografia-digital|investigacion-de-mercados|arquitectura-efimera
	*
	*/
	public function index($url="1"){
		$this->tp['url'] = $url;   
  
		switch($url){
			case('2'):
				$this->tp['title'] = 'Pilas con el ambiente'; 
				$this->tp['imagen'] = 'banner-blanqueamiento.jpg'; 
				$this->tp['url'] = $url;	
				$this->load->view('main/landing2', $this->tp);
				break;
			case('1'):
			default:
				$this->tp['title'] = 'Pilas con el ambiente'; 
				$this->tp['imagen'] = 'banner-blanqueamiento.jpg'; 
				$this->tp['url'] = $url;	
				$this->load->view('main/landing1', $this->tp);	
		}
	}
	
	public function to_read_database($show='f'){
		$this->load->library('email');
		if(true){
			$pQuery = $this->db->get('prospectos')->result();
			echo '
			<style>
			table, table tr, table tr td{border-collapse:collapse; border:1px solid #ccc;}
			table tr.odd{background:#eee;}
			table tr td{padding:5px; text-aligc:center;}
			</style>
			<table>
			<tr class="odd">
				<td>id</td>
				<td>Nombre</td>
				<td>e-mail</td>
				<td>Tel&eacute;fono</td>
				<td>Interes</td>
				<td>Cargo</td>
				<td>Raz&oacute;n Social</td>
				<td>NIT</td>
				<td>Ciudad</td>
				<td>Fecha</td>
				<td>Terminos</td>                                
			</tr>';
			foreach($pQuery as $k => $r){
				$clase = ($k % 2 > 0)? 'odd': 'eve';
				echo utf8_decode('
				<tr class="'.$clase.'">
				<td>'.$r->id.'</td>
				<td>'.$r->nombre.'</td>
				<td>'.$r->email.'</td>
				<td>'.$r->telefono.'</td>
				<td>'.$r->interes.'</td>
				<td>'.$r->cargo.'</td>
				<td>'.$r->razonsocial.'</td>
				<td>'.$r->nit.'</td>
				<td>'.$r->ciudad.'</td>
				<td>'.$r->fecha.'</td>
				<td>'.$r->terminos.'</td></tr>');
			}
			echo '</table>';
		}else{
			//
			$hoy = date('Y-m-d H:i:s');
			$dia = date('Y-m-d H:i:s', strtotime('-1 days', strtotime($hoy)));
			$pQuery = $this->db->get_where('prospectos', array(
				'fecha <=' => $dia
				,'status_id' => null
				))->result();
			$this->load->helper('email');
			//
			foreach($pQuery as $p){
				if (valid_email($p->email)){
					
					$message =
					'<html>
					<head>
						<title>Contacto</title>
					</head>
					<body style="font-family:Verdana, Arial, Helvetica;font-size:12px">
						Hola '.$p->nombre.',
						<p>Agradecemos tu inter&eacute;s en el <strong>'.@$this->diplomados[$p->interes].'</strong>.<br/>
						Adjunto env&iacute;o link en donde podr&aacute;s descargar el programa completo 
						<a href="'.$this->tp['site_url'].'main/download/'.$p->interes.'">aqu&iacute;</a>.<br/>
						Comun&iacute;cate con nosotros al PBX 2427030 Ext 3954/58 para brindarte mayor informaci&oacute;n.</p>
						<p>Cordialmente</p><br/>
						<p>Bibiana Valenzuela</p>
						<p>EDUCACI&Oacute;N CONTINUADA</p>
						<p>Carrera 4 No 22-61 M&oacute;dulo 16 Of. 303</p>
						<p>PBX 2427030 Ext. 3954/58</p>
						<p>educacion.continuada@utadeo.edu.co</p>
						<img src="'.$this->tp['template'].'images/universidad-jorge-tadeo-lozano.jpg" alt="Universidad Jorge Tadeo Lozano" />
					</body>
					</html>';

					$subject = utf8_decode('Informaci�n '.@$this->diplomados[$p->interes]);
					$message = utf8_decode($message);
					$cc = 'aker@zavgroup.com,adriana.martin@zavgrup.com,alcides.rodriguez@zavgroup.com';
					$result = $this->sendSMTPEmailByMail($p->email, $message,$subject,$cc);
					if($result){
						$this->db->update('prospectos', array('status_id' => 't'), array('id' => $p->id));
					}
				}
			}
		}
	}
	
	public function enviar($url=1, $compartir = null){
		$this->load->library('email');
		if( $this->input->post() ) {
			$post = $this->input->post(null, true);
			$authmail = isset($post['aceptaterminos']) ? $post['aceptaterminos'] : 0;
			
			$data= array(
				'nombre' => $post['nombre']
				,'cargo' => $post['cargo']
				,'razonsocial' => $post['razon_social']
				,'nit' => $post['nit']
				,'ciudad' => $post['ciudad']
				,'email' => $post['email']
				,'telefono' => $post['telefono']
				,'interes' => $post['interes']
				,'terminos' => $authmail
			);

			$this->load->database();
			if($this->db->insert('prospectos', $data)){
					$response = array('code'=>200, 'description'=>'OK');
			}else{
					$response = array('code'=>500, 'description'=> 'Error al guardar los datos' );
			}
			
			$to	= 'info-digital@pilascolombia.com';
			$subject = 'Envio de informacion '.$post['nombre'].' ';
			$message ='<html>
			<head>
				<title>Contacto</title>
			</head>
			<body >
				<p>Ha recibido un mensaje de contacto, los datos del remitente son:</p>
				<ul style="list-style:none; padding:0; margin:0">
					<li><strong>Nombre Completo:</strong> '.$post['nombre'].'</li>
					<li><strong>Cargo:</strong> '.$post['cargo'].'</li>
					<li><strong>Raz&oacute;n Social:</strong> '.$post['razon_social'].'</li>
					<li><strong>NIT:</strong> '.$post['nit'].'</li>
					<li><strong>Ciudad:</strong> '.$post['ciudad'].'</li>   
					<li><strong>Tel&eacute;fono:</strong> '.$post['telefono'].'</li>
					<li><strong>Correo Electr&oacute;nico:</strong> '.$post['email'].'</li>
					<li><strong>Interesado en:</strong> '.$post['interes'].'</li>
					<li><strong>Acepta t&eacute;rminos :</strong> '.$authmail.'</li>
					<li><strong>Enviado :</strong> '.date('Y-m-d H:i:s').'</li>
				</ul>
			</body>
			</html>';
			try{
					/* enviar email */
					$subject = 'Contacto landing Pilas';
					$cc = 'aker@zavgroup.com,adriana.martin@zavgrup.com,alcides.rodriguez@zavgroup.com';
					$resultado = $this->sendSMTPEmailByMail($to, $message,$subject,$cc);
					if($resultado){
						if( $compartir ){
							$to	= 'info-digital@pilascolombia.com';
							$message =
							'<html>
							<head>
											<title>Contacto</title>
							</head>
							<body style="font-family:Verdana, Arial, Helvetica;font-size:12px">
											<p>Hola '.$post['nombre'].'</p>
											<p>Su empresa ha sido invitada a participar en el programa Pilas con el Ambiente de la ANDI</p>                                    
										<p>Su empresa ha sido invitada a participar en el programa Pilas con el Ambiente de la ANDI</p>                                    
											<p>Su empresa ha sido invitada a participar en el programa Pilas con el Ambiente de la ANDI</p>                                    
											<p>Para saber m&aacute;s ingresa <a href="'.$this->links[$url].'" target="_blank">aqu&iacute;</a></p>
							</body>
							</html>';

							/* enviar email */
							$this->sendSMTPEmailByMail($to, $message,$subject,$cc);

							$this->sendSMTPEmailByMail($post["email"],utf8_decode($message),utf8_decode($subject),$cc);
					}
				}else{
					$response = array('code'=>500, 'description'=>"Error al enviar el correo");	
				}
			} catch (phpmailerException $e) {
				$response = array('code'=>500, 'description'=>$e->errorMessage());
			} catch (Exception $e) {
				$response = array('code'=>500, 'description'=>$e->getMessage());
			}           
                        
			$this->output
				->set_content_type('application/json')
				->set_output(
						json_encode(                                    
								array('response' => $response, 'url'=>$this->tp['site_url'].'main/gracias/'.$url.'/'.urlencode($post['email']).'/'.$post['nombre'])
						)
				);
		}
	}
	
	public function gracias($file="", $emaile="f", $nombrep="f"){
		if($file == ""){
			header('location:'.$this->tp['site_url']);
		}
		$this->tp['body_id'] = 'gracias';
		$this->tp['correoe'] = $emaile;
		$this->tp['nombrep'] = $nombrep;
		$this->tp['file'] = $file;
		$this->tp['conversion'] = $this->conversion[$file];
		$this->tp['title'] = $this->diplomados[$file];
		$this->tp['ruta'] = $this->config->item("base_url");
		$this->load->view('main/gracias', $this->tp);	
	}
	
	public function recomendar($url, $mail, $name){
		$this->load->library('email');
		if(!$_POST){
			header('location:'.$this->tp['site_url']);
			exit();
		}else{
			$this->load->helper('email');
			$post = $this->input->post(null, true);
			$emails = str_replace(' ', "",  $post['sharemail']);
			$emails = explode(',', $emails);
			$mail = ($mail != 'f')? urldecode($mail): "";
			$desea = ($mail != 'f')? 'desea': "Deseamos";
			$name = ($name != 'f')? urldecode($name): "";
			$diplo = $this->diplomados[$url];
			//
			foreach($emails as $m){
				if (valid_email($m)){
					$message =
					'<html>
					<head>
						<title>Contacto</title>
					</head>
					<body style="font-family:Verdana, Arial, Helvetica;font-size:12px">
						<p>Hola, '.$name.' '.$desea .' compartir contigo la informaci&oacute;n del <strong>'.$diplo .'</strong>, puedes acceder a ella a trav&eacute;s del siguiente link:</p>
						<p><a href="'.$this->tp['site_url'].$url.'">'.$this->tp['site_url'].$url.'</a></p><br/>
						<p>Cordialmente</p><br/>
						<p>EDUCACIÓN CONTINUADA<br/>
						Carrera 4 No 22-61 Módulo 16 Of. 303<br/>
						PBX 2427030 Ext. 3954/58</p>
						<p>educacion.continuada@utadeo.edu.co</p>
						<img src="'.$this->tp['template'].'images/universidad-jorge-tadeo-lozano.jpg" alt="Universidad Jorge Tadeo Lozano" />
					</body>
					</html>';
					$this->sendSMTPEmailByMail($m,utf8_decode($message), utf8_decode($diplo),'aker@zavgroup.com,alejandro.santos@zavgroup.com,adriana.martin@zavgrup.com');

				}
			}
			
			header('location:'.$this->tp['site_url'].'main/gracias/'.$url.'/'.urlencode($mail).'/'.$name);
		}
	} 
	
	public function download($file=""){
		if($file == ""){
			header('location:'.$this->tp['site_url']);
		}
		
		$file_name = APPPATH."files/pdf/".$file.'.pdf';
		
		if(!file_exists($file_name)){
			header('location:'.$this->tp['site_url']);
		}else{
			$this->load->helper('download');
			$data = file_get_contents($file_name);
			$name = $file.'-'.date('Y-m-d').'.pdf';
			force_download($name, $data);
		}
	}
	
	function download5(){	
		
		$this->db->order_by("fecha", "DESC");
		$query = $this->db->get("prospectos");
		
		
		$fila = '';
		//separador delimitador, mac (;) windows (,)
		$sp = (isset($_GET['conf']) && $_GET['conf'] == '1')? ';' : ',';
		$intro = (isset($_GET['conf']) && $_GET['conf'] == '1')? "\n" : "\r\n";
		
		$fila .= "id";
		$fila .= $sp."Nombre";
		$fila .= $sp."Cargo";
		$fila .= $sp."Raz�n Social";
		$fila .= $sp."Nit";
		$fila .= $sp."Ciudad";
		$fila .= $sp."Email";
		$fila .= $sp."Tel�fono";
		$fila .= $sp."Landing";		
		$fila .= $sp."Acepta t�rminos";
		$fila .= $sp."Fecha registro";
		$fila .= $intro;
		
		foreach($query->result() as $row){
			
			$fila .= $row->id;
			$fila .= $sp.$this->clean_csv_string($row->nombre);		
			$fila .= $sp.$this->clean_csv_string($row->cargo);
			$fila .= $sp.$this->clean_csv_string($row->razonsocial);
			$fila .= $sp.$this->clean_csv_string($row->nit);
			$fila .= $sp.$this->clean_csv_string($row->ciudad);
			$fila .= $sp.$this->clean_csv_string($row->email);		
			$fila .= $sp.$this->clean_csv_string($row->telefono);
			$fila .= $sp.$this->clean_csv_string($row->interes);					
			$fila .= $sp.(($row->terminos == 1) ? "Si" : "No");			
			$fila .= $sp.$this->clean_csv_string($row->fecha);			
			
			$fila .= $intro;
		}	
		//
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=base-datos-landing-pilas".date('Ymd').".csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		//
		exit($fila);
	}
	
	function clean_csv_string($str){
		$str = utf8_decode($str);
		$str = str_replace("\r", " ", $str);
		$str = str_replace("\n", "*enter*", $str);
		$str = str_replace('""', "\rQ", $str);
		$str = str_replace(',', "*coma*", $str);
		$str = str_replace(';', "*punto-y-coma*", $str);
		$str = str_replace('ñ', "�", $str);
		$str = str_replace('á', "�", $str);
		return $str;
	}


	/**
	 * Envio de correo
	 * @param to Direccion de destino
	 * @param msg Mensaje a enviar en formato HTML
	 * @param subject Asunto del mensaje
	 * @param cc Direccion a la cual se va a enviar copia
	 */
	private function sendSMTPEmailByMail($to, $msg, $subject, $cc = '')
	{
			$this->load->library('email');
			$result = $this->email
					->from('norepply@pilascolombia.com')
					->cc($cc)   
					->to($to)
					->subject($subject)
					->message($msg)
					->send();
			return $result;
	}
	
	
}