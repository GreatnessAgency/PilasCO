<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Ext_Controller {

	public $user;

	public function __construct(){
		parent::__construct(); 
		//verifica si la session no ha expirado y si hay un usuario activo               
		$this->isLoggedIn();
		//si hay un usuario activo trae los datos de este en this->tp['user']
		$this->setCurrentUser();
		$this->tp['controller'] = 'users';
		$this->tp['contenido'] = 'Usuario';
		$this->tablecore = 'users';
		$this->tabletype = 'type';
		$this->tablecontent = 'contents';
	}

	

	public function index($alert = 0){
		if($alert == 1){$this->tp['alert']= 'Usuario Creado con &eacute;xito';}
		if($alert == 2){$this->tp['alert']= 'Usuario Actualizado con &eacute;xito';}
		if($alert == 3){$this->tp['alert']= 'El usuario ha sido borrado';}
		if($this->user->rol_id > 0){ $this->db->where('rol_id >', '0'); }
		$items = $this->db->get($this->tablecore)->result();
		foreach($items as $it){
			$it->rol = 'Super Administrador';
			if($it->rol_id != 0){
				$it->rol = $this->db->get_where($this->tabletype, array('type_id' => 2, 'value' => $it->rol_id ))->row()->name;
			}
		}
		$this->tp['items'] = $items; 
		$this->load->view('list', $this->tp);
	}

	

	public function create(){
		if($_POST){
			if($this->user->rol_id != 0){
				if($_POST['rol_id'] == 0){
					$json = array('success' => false, 'msj' => 'El formulario contiene valores no admitidos, intententelo nuevamente');
					exit(json_encode($json));
				}
			}	

			$_POST['password'] = md5( $_POST['password'] );
			$this->db->where('username', $_POST['username'] );
			$query = $this->db->get('users');
			//echo '<pre>'.print_r($_POST,true).'</pre>';exit;
			if( $query->num_rows > 0 ){
				//error el username existe
				$json = array('success' => false, 'msj' => 'El Nombre de Usuario ya existe.');
				exit(json_encode($json));
			}else{
				if(isset($_POST['obj'])){
					$_POST['specs'] = json_encode($_POST['obj']);
				}/*else{
					$rol = $this->db->get_where($this->tabletype,array('type_id'=>2,'value'=>$this->input->post('rol_id')));
					$rol_info = $rol->result();
					$specs = $this->db->get_where('rol_specs',array('specs_id'=>$rol_info[0]->id))->result();
					$_POST['specs'] = $specs[0]->specs;
				}*/
				unset($_POST['obj']);
				if( ! $this->db->insert('users', $_POST) ){
					//error al insetar 
					$json = array('success' => false, 'msj' => 'Hubo un error al intentar crear al usuario.');
					exit(json_encode($json));
				}else{
					//todo okey 
					$json = array('success' => true, 'msj' => '', 'params' => 'users/index/1/');
					exit(json_encode($json));

				}//fin else inserto dato

			}//fin else existe

		}

		$this->tp['detetc'] = $this->db->get_where($this->tabletype, array('type_id' => 2))->result();
		//bajar el listado de modulos
		$this->db->select('value,name,description');
		$this->db->order_by('value', 'asc');
		$this->tp['modules'] = $this->db->get_where($this->tabletype, array('type_id' => 4, 'status_id' => 't'))->result();
		//
		$this->load->view('new', $this->tp);

	}

	public function edit( $id ){
		if( $_POST ){
			if($this->user->rol_id != 0){
				if($_POST['rol_id'] == 0){
					$json = array('success' => false, 'msj' => 'El formulario contiene valores no admitidos, intententelo nuevamente');
					exit(json_encode($json));
				}
			}

			if( isset( $_POST['password'] ) && $_POST['password'] != ""){
				$_POST['password'] = md5( $_POST['password'] );
			}else{
				unset( $_POST['password'] );
			}

			if(isset($_POST['obj'])){
				$_POST['specs'] = json_encode($_POST['obj']);

			}/*else{
					$rol = $this->db->get_where($this->tabletype,array('type_id'=>2,'value'=>$this->input->post('rol_id')));
					$rol_info = $rol->result();
					$specs = $this->db->get_where('rol_specs',array('specs_id'=>$rol_info[0]->id))->result();
					$_POST['specs'] = $specs[0]->specs;
			}*/
			unset($_POST['obj']);
			
			if( ( $id == $this->session->userdata('uid') ) && ( $this->input->post('username') == $this->session->userdata('username') ) ){
				$this->db->update('users', $_POST, array( 'id' => $id ) );
				$json = array('success' => true, 'params' => 'users/index/2/');
				exit(json_encode($json));
			}

			if($id == $this->session->userdata('uid') && $this->input->post('username') != $this->session->userdata('username')){
				$this->db->select('username');
				$this->db->from('users');
				$this->db->where('username', $this->input->post('username'));
				$check_user = $this->db->get();

				if($check_user->num_rows == 0){
					$this->db->update( 'users', $_POST, array( 'id' => $id ));
					$this->session->set_userdata('username',$this->input->post('username'));					
					$json = array('success' => true, 'params' => 'users/index/2/');
					exit(json_encode($json));

				}else{
					$json = array('success' => false, 'msj' => 'El Nombre de Usuario ya existe.');
					exit(json_encode($json));
				} 
			}

			
			if($id != $this->session->userdata('uid') && $this->input->post('username') == $this->session->userdata('username')){	
					$json = array('success' => false, 'msj' => 'El Nombre de Usuario ya existe.');
					exit(json_encode($json));
			}

			

			if($id != $this->session->userdata('uid')){  
				$this->db->select('username');
				$this->db->from('users');
				$this->db->where('username', $this->input->post('username'));
				$this->db->where('id !=', $id);
				$check_user = $this->db->get();

				if($check_user->num_rows == 0){
					$this->db->update( 'users', $_POST, array( 'id' => $id ) );
					$json = array('success' => true, 'params' => 'users/index/2/');
					exit(json_encode($json));
				} else {
					$json = array('success' => false, 'msj' => 'El Nombre de Usuario ya existe.');
					exit(json_encode($json));
				}
			}
		}

		$item = $this->db->get_where('users', array('id' => $id))->row();
		$obj = json_decode($item->specs);
		$item->permisos = (array)@$obj->permisos;		

		$this->tp['item'] = $item;
		$this->tp['detetc'] = $this->db->get_where($this->tabletype, array('type_id' => 2))->result();

		//bajar el listado de modulos
		$this->db->select('value,name,description');
		$this->db->order_by('value', 'asc');
		$this->tp['modules'] = $this->db->get_where($this->tabletype, array('type_id' => 4, 'status_id' => 't'))->result();
		//
        $this->load->view('edit', $this->tp);
	}

	public function delete( $id ){
		$this->db->delete('users', array('id' => $id)); 
		header('Location:'.$this->config->site_url().'users/index/3');
	}

	public function publish($val, $id){
		//si esta definido padre_shared entonces muestra a los hijos
		$this->db->update($this->tablecore, array('status_id' => $val), array('id' => $id));
		header('Location:'.$this->tp['site_url'].$this->tp['controller'].'/index/2');
	}
}
?>