<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generador extends Ext_Controller {
	public $user;
	public function __construct(){
		parent::__construct();
		//verifica si la session no ha expirado y si hay un usuario activo
		$this->isLoggedIn();
		//si hay un usuario activo trae los datos de este en this->tp['user']
		$this->setCurrentUser();
		
		$this->tablecore = 'modules';
		$this->tabletags = 'module_fields';
	
		$this->tp['titulo'] = 'Generador Modulos';
		$this->tp['controller'] = 'generador';
		$this->tp['contenido'] = 'modulo';
		
		$this->compOptions = array(
			"required"
			, "length"
			, "widget"
			, "validation"
			, "from"
			, "source"
			, "width"
			, "height"
			, "thumb"
			, "formats"
			, "publish"
			, "delete"
			, "tot"
			, "order"
		);
		
		//dependiendo del tipo de base de datos se podrian generar modelos diferentes
		//por defecto actulmente esta mysql
		$this->load->model('generadormysql_model', 'gm');
	}
	
	public function index($alert=0, $lang=1, $borrar=""){
		//
		$this->db->select('id, shared, title, friendly, description, content, status_id');
		$this->db->where_not_in('status_id', array( "borrador", "papelera" ));
		$this->db->where( array('lang_id' => (string)$lang ));
		$this->db->order_by('modify', 'desc');
		$items = $this->db->get($this->tablecore)->result();
		//
		if($borrar != ""){
			//
			$this->db->delete($this->tablecore, array('shared' => $borrar, 'type' => 'module'));
		}
		//
		$this->tp['lang'] = $lang;
		$this->tp['items'] = $items;
		//
		$this->load->view('list', $this->tp);
	}
	
	public function create( $lang = 1 ){
		//
		$shared = time();
		
		$datos	= array(
			'lang_id' => 1,
			'shared' => $shared,
			'title' => '',
			'status_id' => 'borrador', // borrador | papelera | publico | oculto
			'created' => date('Y-m-d H:i:s'),
			'father_id' => 0
		);
		/*
		* realizo el insert en la tabla correspondiente
		*/
		$this->db->insert($this->tablecore, $datos);
		//
		header('location:'.$this->tp['site_url'].$this->tp['controller'].'/edit/'. $shared. '/1/crear' );
	}
	
	public function edit($shared="", $lang=1, $accion="editar"){
		
		if($_POST){
			$post = $this->input->post(null, true);
			
			//valido que no haya un item con el mismo nombre amigable
			//si no lo hay le creo el hash
			if($accion == "Crear"){
				
				if(!ctype_lower($post['friendly'])) { 
					exit(json_encode(array('success' => false, 'msj' => 'El identificador del modulo solo apcepta minuscula sin caracteres especiales.' )));
				}
				
				$Where = array('friendly' => $post['friendly']);
				
				$existe = $this->db->get_where($this->tablecore, $Where);
				
				if($existe->num_rows() > 0){
					exit(json_encode(array('success' => false, 'msj' => 'Ya existe un modulo con el nombre: '.$post['title'].'. Intentelo con uno diferente.' )));
				}
			}

			$this->db->update($this->tablecore, $post, array('shared' => $shared));
			
			$modulo = $this->db->get_where($this->tablecore, array('shared' => $shared))->row();
			//
			exit(json_encode(array('params' => $this->tp['controller'].'/verifydb/'.$modulo->friendly)));
		}
		
		$color = 'e7f7d0';
		$acto = 'Editando';
		$modo = 'Editar';
		$boton = 'Actualizar';

		if($accion=='crear'){
			$color="d3e9f2";
			$acto = 'Creando';
			$modo = 'Crear';
			$boton = 'Insertar';
		}
		$this->tp['color'] = $color;
		$this->tp['acto'] = $acto;
		$this->tp['modo'] = $modo;
		$this->tp['boton'] = $boton;
		//
		$this->tp['shared'] = $shared;
		$this->tp['lang'] = $lang;
		
		$item = $this->db->get_where($this->tablecore, array('shared' => $shared))->row();
		//traer todos los componentes pertenecientes a este modulo
		$this->db->order_by('position', 'asc');
	//	$this->db->select('id, content_id, title, type');
		$item->components = $this->db->get_where($this->tabletags, array('content_id' => $item->id))->result(); 
		
		$this->tp['item'] = $item;
		
		$this->load->view('edit', $this->tp);
	}
	
	public function verifydb($table=""){
		//este metodo se encaga de crear la base de datos si no existe
		//en la que se almacenaran los datos del nuevo modulo a crear / editar
		//si la tabla ya existe verifica que existan las columnas correspondientes
		
		if($table==""){
			exit(json_encode(array('params' => $this->tp['controller'].'/index/')));
		}
		//verificar que exista el modulo 
		$query =  $this->db->get_where($this->tablecore, array('friendly' => $table));
		if($query->num_rows <= 0){
			exit(json_encode(array('params' => $this->tp['controller'].'/index/')));
		}
		
		$module = $query->row();
		
		$table =  $module->friendly;

		if(!$this->db->table_exists( $module->friendly )){
			$this->gm->createTable($table);
		}
		//consular los componentes y si existen y iterar en ellos
		$this->verifyComponents($table, false, $module->id);
	}
	
	public function verifyComponents($table, $isdup, $id){
		//si is dup es true entonces
		//es un componente interno se traen a los hijos
		$components = array();
		
		if($isdup){
			$components = $this->db->get_where($this->tabletags, array('father_id' => $id, 'content_id' => null))->result();
		}else{
			$components = $this->db->get_where($this->tabletags, array('content_id' => $id))->result();
		}
		
		$after = ($isdup)? 'content_id' : 'lang_id';
		
		foreach($components as $component){
			//
			if($component->type != 'separator'){

				if($component->type == 'duplicator'){
					//el duplicador creara u
					$tabledup = $table.'_'.$component->name;
					if(!$this->db->table_exists( $tabledup )){
						$this->gm->createTableDuplicator($tabledup);
					}
					
					$this->verifyComponents($tabledup, true, $component->id);
					
				}elseif($component->type == 'gallery'){
					
					$tablegallery = $table.'_'.$component->name.'_gallery';
					if(!$this->db->table_exists( $tablegallery )){
						$this->gm->createTableDuplicator($tablegallery);
						$this->gm->createField($tablegallery, 'value', 'content_id');
						$this->gm->createField($tablegallery, 'description', 'value');
					}
					
				}elseif($component->type == 'select'){
					
					$attributes = json_decode($component->attributes);
					
					if($attributes->from == 'string'){
						//crear campo tipo int
						$exist = $this->gm->columExist($table, $component->name);
						if($exist < 1){
							$this->gm->createIntField($table, $component->name, $after);
						}
						
					}elseif($attributes->from == 'module'){
						//si el componente es tipo modulo y es multiple crea tabla de relacion
						if($attributes->selectable == 'multiple'){
							
							$tablerelation = $table.'_has_'.$component->name;
							
							if(!$this->db->table_exists( $tablerelation )){
								$this->gm->createTableRelation($tablerelation);
								
								
								$this->gm->createIntField($tablerelation, $table.'_id', 'id');
								$this->gm->createIntField($tablerelation, $component->name.'_id', $table.'_id');
							
							}
							
						}else{
							//crear campo tipo int
							$exist = $this->gm->columExist($table, $component->name);
							if($exist < 1){
								$this->gm->createIntField($table, $component->name, $after);
							}
						}
					
					}else{
						//campo tipo texto
						$exist = $this->gm->columExist($table, $component->name);
						if($exist < 1){
							$this->gm->createField($table, $component->name, $after);
						}
					}

				}else{
					//crear un campo dentro de la tabla con las caracteristicas requeridad
					//si no existe
					$attributes = json_decode($component->attributes);
					$field = $component->name;
					$elAnterior = "";
					
					if(@$attributes->widget == "lanlong"){
						//el campo tipo latlong en realidad son 2 campos tipo double
						//llevan el prefijo lat_ y lng_
						$field = 'lat_'.$component->name;
						$elAnterior = 'lng_'.$component->name;
					}
					$exist = $this->gm->columExist($table, $field);

					if($exist < 1){
						//al crear el campo, el tipo de campo dependera de estos tipos de contenido
						//widget:datepick
						//widget:preciopick
						//widget:lanlong
						//widget:int
						if(@$attributes->widget == "datepick"){
							//crear campo tipo fecha
							$this->gm->createDateField($table, $component->name, $after);
						}else if(@$attributes->widget == "preciopick"){
							//crear campo tipo double
							$this->gm->createDoubleField($table, $component->name, $after);
						}else if(@$attributes->widget == "int"){
							//crear campo tipo int
							$this->gm->createIntField($table, $component->name, $after);
						}else if(@$attributes->widget == "lanlong"){
							//crear 2 campos tipo double
							$this->gm->createDoubleField($table, 'lat_'.$component->name, $after);
							$this->gm->createDoubleField($table, 'lng_'.$component->name, 'lat_'.$component->name);
						}else{
							$this->gm->createField($table, $component->name, $after);
						}
					}
					
					$after = ($elAnterior != "")? $elAnterior : $component->name;
				}
				
			}
		}
		
		if(!$isdup){
			header('location:' .$this->tp['site_url'].$this->tp['controller'].'/index/');
		}
	}
	
	public function getAmigable(){
		$get = $this->input->get(null, true);
		$amigable = $this->miCambio(@$get['string'], "");
		exit($amigable);
	}
	
	public function getModulesExcept($moduleId=0, $dupId=0){
		if($moduleId==0 && $dupId != 0){
			$this->db->select('content_id');
			$component = $this->db->get_where($this->tabletags, array('id' => $dupId))->row();
			$moduleId = $component->content_id;
		}
		$this->db->select('id, title');
		return $this->db->get_where($this->tablecore, array('id !=' => $moduleId, 'lang_id' => 1))->result();
	}
	
	public function get_dups($ide){
		$this->db->order_by('position', 'asc');
		$items = $this->db->get_where($this->tabletags, array('content_id' => null, 'father_id' => $ide))->result();
		exit(json_encode($items));
	}
	
	public function get_item($id=0, $moduleId=0, $dupId=0){
		$item = new stdClass();
		$this->tp['dupId'] = $dupId;
		$this->tp['moduleId'] = $moduleId;
		$this->tp['opciones'] = array();
		
		if($id != 0){
			$item = $this->db->get_where($this->tabletags, array('id' => $id))->row();
			//opciones registradas del componente
			$this->tp['opt'] = json_decode($item->attributes);
			
			$this->tp['opciones'] = $this->get_opts($item->type, true);
			//obtener listado de modulos si 
			//componente es tipo select.
			if($item->type == 'select'){
				$this->tp['modules'] = $this->getModulesExcept($moduleId, $dupId);
			}
			
		}
		$this->tp['item'] = $item;
		//
		$this->load->view('componente', $this->tp);
	}
	
	public function set_item($id=0, $moduleId=0, $dupId=0){
		if($_POST){
		    $post = $this->input->post(null, true);
			$data = array();
			$description = $post['description'];
			$data['content_id'] = ($dupId == 0)? $moduleId : null;
			$data['father_id'] = ($dupId != 0)? $dupId : null;
			$data['description'] = $post['description'];
			$data['type'] = $post['type'];
			$data['size'] = $post['size'];
			$data['status_id'] = $post['status_id'];
			$amigable = @$post['friendly'];
			
			unset($post['friendly'], $post['description'], $post['type'], $post['size'], $post['status_id']);
		
			$data['attributes'] = json_encode( $post );

			if($id==0){
				//validar que no exista otro componente con el mismo name
				
				if(!ctype_lower($amigable)) {
				  exit(json_encode(array('success' => false, 'msj' => 'El identificador del campo solo acepta minúscula sin caracteres especiales.' )));
				}
				
				$Where = ($dupId == 0)? array('content_id' => $moduleId, 'name' => $amigable) : array('father_id' => $dupId, 'name' => $amigable);
				
				$existe = $this->db->get_where($this->tabletags, $Where);
				
				if($existe->num_rows() > 0){
					exit(json_encode(array('success' => false, 'msj' => 'Ya existe un campo con el nombre: '.$description.'. Intentelo con uno diferente.' )));
				}
				
				$data['name'] = $amigable;
				
				$this->db->insert($this->tabletags, $data);
				
				$data['id'] = $this->db->insert_id();
			}else{
				$data['id'] = $id;
				
				$this->db->update($this->tabletags, $data, array('id' => $id));
			}
			
			exit(json_encode(array('success' => true, 'obj' => $data )));
			
		}
	}
	
	public function get_opts($type="", $return=false){
		
		switch($type){
			case 'input': 
				$arr = array("required", "length", "widget", "validation");
			break;
			case 'select': 
				$arr = array("required", "from");
			break;
			case 'textarea': 
				$arr = array("required", "length", "height");
			break;
			case 'editor': 
				$arr = array("required", "height");
			break;
			case 'image': 
				$arr = array("required", "width", "height", "thumb");
			break;
			case 'document': 
				$arr = array("required", "formats", "thumb");
			break;
			case 'gallery': 
				$arr = array("required", "width", "height", "thumb", "publish", "delete");
			break;
			case 'duplicator': 
				$arr = array("tot", "publish", "delete", "order");
			break;
			default:
				$arr = array();
		}
		
		if( $return ) return $arr;
		
		$this->tp['opciones'] = $arr;
		
		//obtener listado de modulos si 
		//componente es tipo select.
		
		if($type == 'select'){
			$get = $this->input->get(null, true);
			$this->tp['modules'] = $this->getModulesExcept($get['moduleId'], $get['dupId']);
		}
		$this->tp['dupId'] = $get['dupId'];
		$this->load->view('componente', $this->tp);
	}
	
	public function update_positions($items){
		$items = substr($items, 0, -1);
		$items = explode("_", $items);
		$update = array();
		$pos = 1;

		foreach ($items as $id) {
			$update['position'] = $pos;
			$this->db->update($this->tabletags, $update, array('id' => $id));
			$pos++;
		}
	}
	
	public function publish($val, $shared){
		$this->db->update($this->tablecore, array('status_id' => $val), array('shared' => $shared));
		header('Location:' . $this->config->site_url() . $this->tp['controller'].'/index/2/1/');
	}
	
	public function delete( $shared ){
		$this->db->update($this->tablecore, array('status_id' => 'papelera'), array('shared' => $shared));
		header('Location:'.$this->config->site_url().$this->tp['controller'].'/index/3/1/' );
	}
}