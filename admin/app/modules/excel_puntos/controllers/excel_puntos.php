<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Excel_puntos extends Ext_Controller
{
	public function __construct()
	{
		parent::__construct();
		//verifica si la session no ha expirado y si hay un usuario activo
		$this->isLoggedIn();
		$this->tablecore = 'modules';
		$this->tabletags = 'module_fields';
		$this->tablemedia = 'multimedia';
		$this->tabletype = 'type';

		$this->load->library('excel');
		$this->tp['controller'] = 'excel_puntos';
		$this->tp['titulo'] = 'Excel Puntos de Recoleccion';
		$this->tp['contenido'] = 'Los Puntos de recoleccion';
		$this->tp['icon'] = (object) array('desc' => '(Escala * 90px )', 'width' => 'scale', 'height' => 90);
		$this->tp['imguno'] = (object) array('desc' => '(960px * Escala)', 'width' => 960, 'height' => 'scale');
	}

	public function index($alert = 0, $lang = 1, $borrar = "")
	{
		if ($alert == 1) {
			$this->tp['alert'] = $this->tp['contenido'] . ' fueron creados con &eacute;xito';
		}
		if ($alert == 2) {
			$this->tp['alert'] = $this->tp['contenido'] . ' no se han podido crear';
		}
		$module = $this->getModule(2, true);
		$this->setCurrentUser($module->friendly);
		if ($this->user->rol_id != 0 && count(@$this->permisos) <= 0) {
			exit('No tienes permisos');
		}
		$this->tp['titulo'] = $module->title;
		$this->tp['contenido'] = getcwd();
		$shared = $module->shared;

		if ($_POST) {
			$post = $this->input->post(null, true);

			$datos = $this->procesarData($module->friendly, $post['_idItem']);
			$datos['lang_id'] = 1;
			$datos['shared'] = $shared;
			$datos['modify'] = date('Y-m-d H:i:s');
			if ($this->user->rol_id == 0 || @$this->permisos->pub == 't') {
				$status = (@$post['status_id'] != "") ? $post['status_id'] : 'oculto';
				$datos['status_id'] = $status;
			}
			if ($this->user->rol_id != 0 && @$this->permisos->pub != 't') {
				$datos['status_id'] = 'oculto';
			}
			$alert = 1;
			if($datos['extract'] < 1){
				$alert = 2;
			}
			$json = array('success' => true, 'data' => $datos, 'params' => $this->tp['controller'] . '/index/' . $alert.'/' . $lang);
			exit(json_encode($json));
		}
		$color = 'e7f7d0';
		$acto = 'Editando';
		$modo = 'Editar';
		$boton = 'Actualizar';

		$this->tp['color'] = $color;
		$this->tp['acto'] = $acto;
		$this->tp['modo'] = $modo;
		$this->tp['boton'] = $boton;
		/*
         * proceso consulta items segun idioma..
         * recibo el shared del item selecionado
         * ya que puede estar en varios idiomas
         */
		$this->db->select('*');
		$iQuery = $this->db->get_where($module->friendly, array('shared' => $shared));
		$items = array();
		$langs = array();
		/*
         * inicio el foreach de $items para bajar los
         * language_id (lenguajes), las imagenes y descriciones de cada idioma
         */
		if ($iQuery->num_rows() > 0) {
			$items = $iQuery->result();
		}
		foreach ($items as $k => $it) {
			$langs[] = $it->lang_id;
			$it->imgs = array();
			$it->template = "";
			//bajar las columnas del item presente en el loop
			//hago un loop sobre los componentes para discriminar
			//aquellos que sean galery y decartar los que sean del tipo duplicador
			foreach ($module->components as $component) {
				if ($component->type != 'duplicator') {
					$name = $component->name;
					if ($component->type == 'gallery') {
						$this->db->order_by('position', 'ASC');
						$this->db->select('*');
						$where = array('content_id' => $it->id);
						$colQuery = $this->db->get_where($module->friendly . '_' . $component->name . '_gallery', $where);
						$column = $colQuery->result();
						$it->$name = $column;
					}
				}
			}
			foreach ($module->components as $component) {
				$it->template .= $this->getTemplate($component, $k, $it);
			}
		}
		$this->tp['items'] = $items;
		$this->tp['shared'] = $shared;
		$this->tp['lang'] = $lang;
		$this->tp['module'] = $module;
		$this->tp['website_url'] = $this->config->item('pagina_url');

		$this->load->view('edit', $this->tp);
	}

	private function getModule($moduleId, $components = false, $cantidadComponentes = 0)
	{
		if (!is_numeric($moduleId)) {
			exit('Modulo no especificado, consulte a su proveedor para temas de soporte.');
		}
		$this->db->select('id, title, friendly, description, content, shared');
		$module = $this->db->get_where($this->tablecore, array('id' => $moduleId));
		// if ($module->num_rows() <= 0) {
		// 	exit('Modulo no habilitado, consulte a su proveedor para temas de soporte.');
		// }
		$module = $module->row();
		if ($components) {
			if ($cantidadComponentes > 0) {
				$this->db->limit($cantidadComponentes);
			}
			$this->db->select('id, content_id, description, name, attributes, type, size');
			$this->db->order_by('position', 'ASC');
			$module->components = $this->db->get_where($this->tabletags, array('content_id' => $module->id, 'father_id' => null, 'status_id' => 'publico'))->result();
		}
		return $module;
	}

	private function procesarData($table = "", $id)
	{
		//
		$post = $this->input->post(null, true);
		//
		$data = array();
		//
		foreach ($post as $key => $ps) {
			if (
				$key == '_Idioma'
				|| $key == '_idItem'
				|| $key == 'status_id'
			) {
				continue;
			}
			if ($key == '_compDocument') {
				$doc = $post['_compDocument'];
				$data["doc"] = $doc;
				if (!empty($doc)) {
					$doc_name = $doc;
					if (file_exists($this->tmp_dir . $doc_name)) {
						$doc_tmp = $this->tmp_dir . $doc_name;
						$data['extract'] = $this->extractPoints($table, $doc_tmp);
					}
					$data['archivo'] = $doc_name;
				}
			}
		}
		//
		return $data;
	}

	public function extractPoints($table, $file)
	{
		require_once APPPATH . "third_party/PHPExcel/Classes/PHPExcel/IOFactory.php";
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$data = [];
		$cont = 0;
		$this->db->empty_table($table);
		for ($row = 2; $row <= $highestRow; $row++) {
			$rowArray = $sheet->rangeToArray('A' . $row . ':D' . $row, NULL, TRUE, FALSE);
			$rowData = $rowArray[0];
			$cont++;
			$data[] = [
				"shared" => time(),
				"lang_id" => 1,
				"status_id" => "publico",
				"created" => date('Y-m-d H:i:s'),
				"father_id" => 0,
				"id" => $cont,
				"nombre" => $rowData[0],
				"direccion" => $rowData[1],
				"latitud" => $rowData[2],
				"longitud" => $rowData[3]
			];
		}

		$this->db->insert_batch($table, $data);
		return $cont;
	}
}
