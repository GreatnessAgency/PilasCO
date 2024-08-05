<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Ext_Controller {

	public function __construct(){
		parent::__construct();
		$this->setCurrentUser();
		$str = $_SERVER['HTTP_HOST'];
		$uri = $_SERVER['REQUEST_URI'];
		if(preg_match("/www./i",$str)) { 
		   header('location:http://'.str_replace('www.',"", $str).$uri);
		}
		
		$this->alphabet = array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
		$this->tablecore = 'users';
	}
	
	public function index($msj = 0){
		if($msj == 1){
			$this->session->sess_destroy();
			delete_cookie("zav_user");
			$this->tp['msj'] = $this->set_msj('ok', 'Session cerrada correctamente.');
		}
			
		if(!isset($this->user)){
			$this->tp['RAND'] = json_encode($this->set_hash(true));	
		}else{
			//consulta los modulos disponibles, los modulos son items de la base de datos del tipo 'module'
			//se listan en la vista de inicio del usuario
			$this->db->select('id, shared, title, friendly');
			$this->db->order_by('position', 'ASC');
			$modulos = $this->db->get_where('modules', array('status_id' => 'publico'))->result();	
			$mods = array();
			//validar que el usuario actual tenga acceso al modulo para mostrar boton
			foreach($modulos as $mod){
				$name = $mod->friendly;
				$permiso = @$this->user->permisos->$name;
				if($this->user->rol_id == 0 || count($permiso) > 0){
					$mods[] = $mod;
				}
			}
			
			$this->tp['mods'] = $mods;
		}
		
		$this->load->view('inicio_vista', $this->tp);

	}

	public function login($msg = 0){
		if($msg == 1){ $this->tp['msj'] = $this->set_msj('ok', 'Ingreso Exitoso <script type="text/javascript">$(function(){location.href="'.$this->tp['site_url'].'";});</script>'); }
		if($msg == 2){ $this->tp['msj'] = $this->set_msj('alert', 'Usuario &oacute; Clave Incorrectos'); }
		if($msg == 3){ $this->tp['msj'] = $this->set_msj('ok', 'Contraseña actualizada con éxito.'); }
		if($_POST){
			
			if(!$this->session->userdata('hash') || strlen($this->input->post('password')) != 32 ){
				$json = array('success' => true, 'msj' => '', 'params' => 'home/login/2');
				exit(json_encode($json));
			}
			
			//
			
			$str = array();
			$recibe = $this->input->post('password');
			$tot = strlen($recibe);
			
            for($i=0; $i<$tot; $i++){
                $str[$i] = $recibe[$i];
                foreach($this->session->userdata('hash') as $k => $letra){
                    if($recibe[$i] == $letra){
                        $str[$i] = $this->alphabet[$k];
                    }
                }
            }
			
			$this->db->from( $this->tablecore );
			$this->db->where('username', $this->input->post('username'));
			$this->db->where('password', implode('', $str));
			$this->db->where('status_id', 't');
			$this->db->where('rol_id !=', '4');
			
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$query->num_rows();
				$user = $query->row();
				$this->session->set_userdata('uid', $user->id);
				$this->session->set_userdata('username', $user->username);
				$this->session->set_userdata('last_activity', time() );//
				
				//si el usuario puso no cerrar sesion se crea una cookie que dura 1 año 
			//	if(@$_POST['recordarme'] == 't' ){
			//		//un año
			//		$tiempo = 60*60*12*30*12; 
			//		//creo un array con los datos del usuario
			//		$cookie = array('name' => $user->username, 'pass' => $user->password);
			//		//convierto el array al lenguaje json	
			//		$cookie = json_encode($cookie);
			//		//codifico el array json con la libreria de codeigniter
			//		$cookie = $this->encrypt->encode( $cookie );
			//		//creo la nueva cookie
			//		$this->input->set_cookie('zav_user', $cookie, $tiempo );
			//	}
				
				$json = array('success' => true, 'msj' => '', 'params' => 'home/login/1');
				exit(json_encode($json));
				
			}else{
				
				$json = array('success' => true, 'msj' => '', 'params' => 'home/login/2');
				exit(json_encode($json));
			}
		}
		
		$this->tp['RAND'] = json_encode($this->set_hash(true));
		
		$this->load->view('inc/login_form', $this->tp);
		
	}
	
	public function set_hash($return = false){
        $reorder = $this->alphabet;
        shuffle($reorder);
        $this->session->set_userdata('hash', $reorder);
        //
        if($return){
            return $reorder;
        }else{
            exit(json_encode($reorder)); 
        }
    }

	public function logout(){
		$this->session->sess_destroy();
	//	delete_cookie("zav_user");
		header('Location:'.$this->config->site_url().'home/index/1');	
	}
	
	public function restore_data($msj = 0){
		if($msj == 1){ $this->tp['msj'] = $this->set_msj('alert', 'Correo no encontrado.'); }
		if($msj == 2){ $this->tp['msj'] = $this->set_msj('ok', 'Correo enviado con &eacute;xito.'); }
		if($msj == 3){ $this->tp['msj'] = $this->set_msj('ok', 'No se pudo enviar el mensaje.'); }
		
		if($_POST){
			
			$this->db->where('email', $_POST['email']);
			$query = $this->db->get( $this->tablecore );
			if($query->num_rows() == 0){
				$json = array('success' => true, 'msj' => '', 'params' => 'home/restore_data/1');
				exit(json_encode($json));
			}else{
			//	$this->load->library('email');				
				$usuario = $query->row();

				$this->load->library('encrypt');
				$encrypted_string = $this->encrypt->encode(md5($usuario->email));
				
				$to	= $usuario->email;
				$subject = 'Recuperar datos :: Zav Admin';	
				$message =
				'<html>
				<head>
					<title>Recuperar datos :: Zav Admin</title>
				</head>
				<body style="font-family:Verdana, Arial, Helvetica;font-size:12px">
					<p>Buen d&iacute;a. '. $usuario->first_name .'</p>
					<p>Se ha enviado este mensaje de restablecimiento de datos del Sistema de Administración de Contenidos Zav Admin de el sitio: '. str_replace("zav_admin/","", $this->tp["site_url"]) .'.<br/>
					Para recuperar sus datos, haga <a href="'.$this->tp["site_url"].'home/restore_pass/'.md5(date('ymd')).'?key='.urlencode($encrypted_string).'" target="_blank">clik aqu&iacute;</a> ó copie el siguiente link en la barra de exploraci&oacute;n de su navegador</p>
					<p>'.$this->tp["site_url"].'home/restore_pass/'.md5(date('ymd')).'?key='. urlencode($encrypted_string).'</p>
					<p>Le recordamos, que su nombre de usuario dentro del sistema es: <strong>'.@$usuario->username.'</strong></p>
					<p>Por razones de seguridad &eacute;ste correo electr&oacute;nico ser&aacute; v&aacute;lido por 1 d&iacute;a.</p>
					<p>&nbsp;</p>
					<p><img src="'.$this->tp["template"].'images/zav_admin.png" alt="Zav Admin" border="0" /></p>
				</body>
				</html>';
				//
				if($this->smtpMail($to, $subject, $message)){
					$json = array('success' => true, 'msj' => '', 'params' => 'home/restore_data/2');
					exit(json_encode($json));	
				}else{
					$json = array('success' => true, 'msj' => '', 'params' => 'home/restore_data/3');
					exit(json_encode($json));	
				}
			}//fin else si existe el usuario
		}//fin if post

		$this->load->view('inc/restore_form', $this->tp);	
	}
	
	public function restore_pass($fecha = 0){
		if(md5(date('ymd')) != $fecha){
			$this->tp['msj'] = $this->set_msj('alert', 'Este link ha caducado.');
		}else{
			$get = $this->input->get(null, true);
			$key = $get['key'];
			
			$this->load->library('encrypt');
			$llave = $this->encrypt->decode($key);


			$usuario = $this->db->get_where($this->tablecore, array('md5(email)' => $llave ));
			if($usuario->num_rows  <= 0){			
				$this->tp['msj'] = $this->set_msj('error', 'Usuario no encontrado');
			}else{	
				$this->tp['msj'] = $this->set_msj('ok', 'Por favor espere...<script type="text/javascript">setTimeout(function(){LoadContent("#login_content", "'.$this->tp['site_url'].'", "home/change_pass?key='.urlencode($key).'")}, 4000);</script>');
			}
		}
		$this->load->view('inicio_vista', $this->tp);
	}

	public function change_pass(){
		$get = $this->input->get(null, true);
		$llave = $get['key'];

		if($_POST){
			//si el email insertado y la llave no coninciden genero la alerta
			$this->load->library('encrypt');
			$llave = $this->encrypt->decode( $llave );


			if(md5($_POST['email']) != $llave){
				$this->tp['msj'] = $this->set_msj('error', 'El email no coincide.');
			}else{
				//seleciono al usuario y actualizo el password del usuario
				$this->db->update( $this->tablecore , array('password' => md5($_POST['password'])), array('email' => $_POST['email']));	
				$json = array('success' => true, 'msj' => '', 'params' => 'home/login/3');
				exit(json_encode($json));	
			}
		}
		$this->tp['llave'] = $llave;
		$this->load->view('inc/restore_form', $this->tp);
	}
}
?>