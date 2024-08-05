<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias_gestor extends Ext_Controller {
	public function __construct(){
		parent::__construct();
		//verifica si la session no ha expirado y si hay un usuario activo
		$this->isLoggedIn();
		//si hay un usuario activo trae los datos de este en this->tp['user']
		$this->setCurrentUser('noticias_gestor');

		$this->tablecore = 'noticias';
	//	$this->tablemedia = 'noticias_gallery';
		$this->tabletype = 'type';

		$this->tp['controller'] = '';
		$this->tp['titulo'] = 'Noticias';
		$this->tp['contenido'] = 'Noticia';
		
		$this->tp['icon'] = (object)array('desc' => '(Escala * 300px )', 'width' => 'scale', 'height' => 300 );
		
		
		if($this->user->rol_id != 0 && count( @$this->permisos ) <= 0 ){
			exit();
		}
	}
	
	
	

	public function index( $alert = 0, $lang = 1, $borrar="" ){
		if($alert == 1){$this->tp['alert']= $this->tp['contenido'].' creado con &eacute;xito';}
		if($alert == 2){$this->tp['alert']= $this->tp['contenido'].' actualizado con &eacute;xito';}
		if($alert == 3){$this->tp['alert']= 'El '.$this->tp['contenido'].' ha sido borrado';}
		//id del lenguaje actual
		$this->tp['lang'] = $lang;
		//obtengo los lenguajes
		$this->tp['languages'] = $this->db->get_where($this->tabletype, array('type_id' => 3, 'status_id' => 't'))->result();
		
		//si borrar es diferente de vacio
		if(!empty($borrar)){
			$this->db->delete($this->tablecore, array('shared' => $borrar));
		}

		//items de pages
		$this->db->where( array('lang_id' => $lang,  'status_id !=' => "borrador" ));
		$this->db->order_by('modify', 'desc');
		$items = $this->db->get($this->tablecore)->result();
		//primera imagen de cada item
	//	foreach ($items as $it) {
	//		$this->db->order_by('position', 'asc');
	//		$query = $this->db->get_where($this->tablemedia, array('content_id' => $it->id, 'typefile_id' => 4));
	//		$this->db->limit(1);
	//		if ($query->num_rows != 0) {
	//			$img = $query->row();
	//			$it->image = $img->value;
	//		}
	//	}
		$this->tp['items'] = $items;
		$this->load->view('list', $this->tp);
	}
	
	public function create($lang = 1){
		
		if($this->user->rol_id != 0 && @$this->permisos->edi != 't' ){
			exit();
		}
		
		$shared = time();
		$datos	= array(
			'lang_id'  => 1,
			'shared'   => 	$shared,
			'created'   => 	date('Y-m-d H:i:s'),
			'status_id'  => 'borrador' // borrador | papelera | publico | oculto
		);
		/*
		* realizo el insert en la tabla correspondiente
		*/
		$this->db->insert($this->tablecore, $datos);
		//
		$accion="crear";
		header('location:'.$this->tp['site_url'].$this->tp['controller'].'/edit/'. $shared. '/1/'.$accion );

	}

	public function edit( $shared, $lang=1, $accion="editar" ){
		
		if ($_POST) {
			//xss post clean
			$post = $this->input->post(null,true);
			
			//SI SE RECIBE IMAGEN EN EL POST
			
			$imagen = $post['imagen'];
			
			if($post['imagen'] != "" && file_exists($this->tmp_dir.$post['imagen'])){
				$file = $post['imagen'];
				$img_tmp = $this->tmp_dir . $file;
				$inf = pathinfo($img_tmp);
				$img_name = $this->tp['controller'].'-imagen-' . md5($shared) .'.'.$inf['extension'];
				$img_new = $this->img_dir . $img_name;
				rename($img_tmp, $img_new);
        
				$imagen = $img_name;
			}
			
			foreach ($post['idioma'] as $k => $i) {

				$datos	= array(
					'lang_id'  => $i,
					'shared'   => $shared,
					'titulo'  => $post['titulo'][$k],
					'contenido'  => $post['contenido'][$k],
					'imagen'  => $imagen
				);
				
				if($this->user->rol_id == 0 || @$this->permisos->pub == 't' ){
					$status = (@$post['status_id'] != "")? $post['status_id'] : 'oculto';
					$datos['status_id'] = $status;
				}

				if($post['id_item'][$k] == 0){
					/*
					 * realizo el insert en la tabla correspondiente
					 */
					$this->db->insert($this->tablecore, $datos);
					//obtengo el id del idioma insertado
					$id = $this->db->insert_id();
					//inserto las imagenes antiguas en el nuevo idioma
				}else{
					/*
					 * realizo el insert en la tabla correspondiente
					 */
					$this->db->update($this->tablecore, $datos, array('id' => $post['id_item'][$k]));
					//obtengo el id del idioma insertado
					$id = $post['id_item'][$k];
				}

			}//end foreach idioma

			$json = array('success' => true, 'params' => $this->tp['controller'].'/index/2/'.$lang );
			exit(json_encode($json));
		}//end if post

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

		/*
		* proceso consulta items segun idioma..
		* recibo el shared del item selecionado
		* ya que puede estar en varios idiomas
		*/
		//$this->db->join('languages', 'languages.lang_id = projects_categories.lang_id');

		$iQuery = $this->db->get_where($this->tablecore, array('shared' => $shared));
		$items = array();
		$langs = array();
		/*
		 * inicio el foreach de $items para bajar los
		 * language_id (lenguajes), las imagenes y descriciones de cada idioma
		 */
		if($iQuery->num_rows() > 0){
			$items = $iQuery->result();
		}


		foreach($items as $it){
			$query = $this->db->get_where($this->tabletype, array('type_id'=> 3, 'value'=> $it->lang_id))->row();
			$it->lang_name = $query->name;
			$langs[] = $it->lang_id;
			$it->lang = $this->miCambio($it->lang_name);
		}
		/*
		* con el array $langs consultar todos los idiomas exepto los que estan en el array
		*/
		if(count($langs) > 0){ $this->db->where_not_in('value', $langs); }
		$this->tp['langs']= $this->db->get_where($this->tabletype, array('type_id' => 3, 'status_id' => 't'))->result();
		/*
		 * genrero las demas variables $this->tp para enviarlas a la vista
		*/
		/*
			* validar que el sistema deba mostrar pestañas, para eso debe haber mas de dos resultados validos en este quiery
		*/
		$this->tp['all_langs']= $this->db->get_where($this->tabletype, array('type_id' => 3, 'status_id' => 't'))->num_rows();

		$this->tp['items'] = $items;
		$this->tp['shared'] = $shared;
		$this->tp['lang'] = $lang;

		$this->load->view('edit', $this->tp);
	}
	
	/*
	 * Metodo basicos para todos los formularios con gallery
	 */
	public function publish($val, $shared){
		if($this->user->rol_id == 0 || @$this->permisos->pub == 't'){
			$this->db->update($this->tablecore, array('status_id' => $val), array('shared' => $shared));
			header('Location:' . $this->config->site_url() . $this->tp['controller'].'/index/2/1/');
		}
	}

	/*
	 * Metodo basicos para todos los controladores
	 */
	public function delete( $shared, $lang){
		if($this->user->rol_id == 0 || @$this->permisos->del == 't'){
			$this->db->delete($this->tablecore, array('shared' => $shared));
			header('Location:'.$this->config->site_url().$this->tp['controller'].'/index/3/'.$lang.'/' );
		}
	}

	public function simple_delete( $id ){
		if($this->user->rol_id == 0 || @$this->permisos->del == 't'){
			$this->db->delete($this->tablecore, array('id' => $id));
		}
	}

	
}