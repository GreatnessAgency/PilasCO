<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends Ext_Controller {
	public $user;
	public function __construct(){
		parent::__construct(); 
		//verifica si la session no ha expirado y si hay un usuario activo               
		$this->isLoggedIn();
		//si hay un usuario activo trae los datos de este en this->tp['user']
		$this->setCurrentUser();
		$this->tp['controller'] = 'roles';
		$this->tp['contenido'] = 'Rol';
		$this->tablecore = 'roles';
		$this->tabletype = 'type';
		$this->tableSpecs = 'rol_specs';
	}
	
	public function index($alert = 0){
		if($alert == 1){$this->tp['alert']= 'Rol Creado con &eacute;xito';}
		if($alert == 2){$this->tp['alert']= 'Rol Actualizado con &eacute;xito';}
		if($alert == 3){$this->tp['alert']= 'El rol ha sido borrado';}
		
		if($this->user->rol_id > 0){ 
			$this->db->where('rol_id >', '0'); 
		}
		$items = $this->db->get_where($this->tabletype, array('type_id' => 2 ))->result();

		$this->tp['items'] = $items; 
		
		$this->load->view('list', $this->tp);
	}
	
	public function create(){
		if($_POST){			
			$this->db->where('type_id',2 );
			$this->db->where('name', $_POST['rol'] );
			$query = $this->db->get($this->tabletype);			
			if( $query->num_rows > 0 ){
				//error el rol existe
				$json = array('success' => false, 'msj' => 'El rol ya existe.');
				exit(json_encode($json));
			}else{				
				
				$this->db->where('type_id',2 );
				$this->db->where('status_id', 't' );
				$this->db->order_by('value', 'DESC' );
				$this->db->limit(1);
				
				$lastRol = $this->db->get($this->tabletype)->row();
				
				$newRol["value"] = $lastRol->value + 1;
				$newRol["type_id"] =2; //rol
				$newRol["name"] =$_POST['rol'];
				$newRol["description"] =$_POST['description']; 
				$newRol["status_id"] = 't'; 
				
				if(isset($_POST['obj'])){
					$dataS['specs'] = json_encode($_POST['obj']);
				}			
				unset($_POST['obj']);
				if( ! $this->db->insert($this->tabletype, $newRol) ){
					//error al insetar 
					$json = array('success' => false, 'msj' => 'Hubo un error al intentar crear el rol.');
					exit(json_encode($json));
				}else{
					
					//guardar permisos
					$this->db->where('type_id',2 );
					$this->db->where('status_id', 't' );
					$this->db->order_by('value', 'DESC' );
					$this->db->limit(1);
					
					$lastRol = $this->db->get($this->tabletype)->row();					
					
					$dataS["specs_id"] = $lastRol->id;
					
					if( ! $this->db->insert($this->tableSpecs, $dataS) ){
						//error al insetar 
						$json = array('success' => false, 'msj' => 'Hubo un error al intentar guardar permisos del rol.');
						exit(json_encode($json));
					}else{
					
						//todo okey 					
						
						$json = array('success' => true, 'msj' => '', 'params' => 'roles/index/1/');
						exit(json_encode($json));
					}
				}//fin else inserto dato
			}//fin else existe
		}
		//MODULOS A ASIGNAR PERMISOS
		$this->tp['modules'] = $this->getModules();
		$this->load->view('new', $this->tp);
	}
	
	
	public function edit( $id ){
		if( $_POST ){
			
			if(isset($_POST['obj'])){
				
			}	
				
			$id = $_POST["id"];
			
			$data["name"] = $_POST["rol"];
			$data["description"] = $_POST["description"];
			$this->db->update($this->tabletype, $data, array( 'id' => $id ) );
			
			$dataS["specs"] = json_encode($_POST['obj']);
			unset($_POST['obj']);
			
			$specs = $this->db->get_where($this->tableSpecs, array('specs_id' => $id));
			if($specs->num_rows > 0)	{
				
				$this->db->update($this->tableSpecs, $dataS, array( 'specs_id' => $id ) );
			}else{
				
				$dataS["specs_id"] = $id;
				$this->db->insert($this->tableSpecs,$dataS );
			}
			
			
			$json = array('success' => true, 'params' => 'roles/index/2/');
			exit(json_encode($json));			
		}
		
		
		$item = $this->db->get_where($this->tabletype, array('id' => $id))->row();
		
		$specs = $this->db->get_where($this->tableSpecs, array('specs_id' => $id))->row();
		
		
		$obj = @json_decode($specs->specs);
		$item->permisos = (array)@$obj->permisos;
		
		$this->tp['item'] = $item;
		$this->tp['detetc'] = $this->db->get_where($this->tabletype, array('type_id' => 2))->result();

		//bajar el listado de modulos
		$this->db->select('value,name,description');
		$this->db->order_by('value', 'asc');
		//MODULOS A ASIGNAR PERMISOS
		$this->tp['modules'] = $this->getModules();
		//
        $this->load->view('edit', $this->tp);
	}
	
	public function getModules(){
		//BUSCA EN LA TABLA DE TIPOS LOS MODULOS QUE EXISTEN EN LA CARPETA MODULES (modulos manuales)
		//bajar el listado de modulos
		$this->db->select('description, name');
		$this->db->order_by('value', 'asc');
		$mods1 = $this->db->get_where($this->tabletype, array('type_id' => 4, 'status_id' => 't'))->result();
		//BUSCAR EN LA TABLA DE MODULES LOS MODULOS DINAMICOS
		$this->db->select('title, friendly AS name, description');
		$this->db->order_by('position', 'asc');
		$mods2 = $this->db->get_where('modules', array('status_id' => 'publico'))->result();
		
		foreach($mods2 as $mod){
			$mod->description = $mod->title.' <br/><span class="c_gray">'.$mod->description.'</span>';
			$mods1[] = $mod;
		}

		return $mods1;
	}
	
	public function delete( $id ){
		$this->db->delete($this->tabletype, array('id' => $id)); 
		header('Location:'.$this->config->site_url().'roles/index/3');
	}
	
	public function publish($val, $id){
		//si esta definido padre_shared entonces muestra a los hijos
		$this->db->update($this->tabletype, array('status_id' => $val), array('id' => $id));
		header('Location:'.$this->tp['site_url'].$this->tp['controller'].'/index/2');
	}

}

?>