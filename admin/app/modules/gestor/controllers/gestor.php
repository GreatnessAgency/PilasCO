<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Gestor extends Ext_Controller
{
    public $user;
    public function __construct()
    {
        parent::__construct();
        //verifica si la session no ha expirado y si hay un usuario activo
        $this->isLoggedIn();
        $this->tablecore = 'modules';
        $this->tabletags = 'module_fields';
        $this->tablemedia = 'multimedia';
        $this->tabletype = 'type';
        $this->tp['controller'] = 'gestor';
        $this->tp['titulo'] = '';
        $this->tp['contenido'] = '';
        $this->tp['icon'] = (object) array('desc' => '(Escala * 90px )', 'width' => 'scale', 'height' => 90);
        $this->tp['imguno'] = (object) array('desc' => '(960px * Escala)', 'width' => 960, 'height' => 'scale');
    }
    /*
    SISTEMA DE MODULOS EN BASE DE DATOS
     */
    public function index($moduleId = "", $alert = 0, $lang = 1, $borrar = "")
    {
        // Con el id del modulo bajo toda la informacion referente al modulo.
        // El id del modulo es obligatorio.
        $module = $this->getModule($moduleId, true);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id != 0 && count(@$this->permisos) <= 0) {
            exit();
        }
        $this->tp['titulo'] = $module->title;
        $this->tp['contenido'] = $module->title;
        //Con la informacion del modulo consulto si el campo content es unico (que debe cargar el edit)
        //o multiple (que muestra el list y puede cargar muchos hijos del modulo)
        if ($module->content == 'unico') {
            //Si existe el item unico a editar entonces va a el, si no entoces lo crea con crear y luego pasa a editarlo.
            //consulto el tipo de contenido que debo cargar
            $this->db->select('shared');
            $item = $this->db->get_where($module->friendly);
            if ($item->num_rows() > 0) {
                $item = $item->row();
                header('location:' . $this->tp['site_url'] . $this->tp['controller'] . '/edit/' . $module->id . '/' . $item->shared . '/1/');
                exit();
            } else {
                header('location:' . $this->tp['site_url'] . $this->tp['controller'] . '/create/' . $module->id . '/1/editar');
                exit();
            }
        }
        //id del lenguaje actual
        $this->tp['lang'] = $lang;
        //obtengo los lenguajes
        //    $this->tp['languages'] = $this->db->get_where($this->tabletype, array('type_id' => 3, 'status_id' => 't'))->result();
        //si borrar es diferente de vacio
        if ($borrar != "") {
            //borrar la informacion de la tabla del modulo si es necesario
            $this->db->delete($module->friendly, array('shared' => $borrar));
        }
        //items de pages
        $this->db->select('*');
        $this->db->where_not_in('status_id', array("borrador", "papelera"));
        $this->db->where(array('lang_id' => $lang));
        $this->db->order_by('modify', 'desc');
        $items = $this->db->get($module->friendly)->result();
        foreach ($items as $it) {
            $it->theImage = "";
            foreach ($module->components as $component) {
                if ($component->type != 'duplicator') {
    
                    $name = $component->name;
    
                    if ($component->type == 'gallery') {
                        $this->db->order_by('position', 'ASC');
                        $this->db->select('*');
                        $where = array('content_id' => $it->id);
                        $colQuery = $this->db->get_where($module->friendly . '_' . $component->name . '_gallery', $where);
                        if ($it->theImage == "" && $colQuery->num_rows() > 0) {
                            $column = $colQuery->row();
                            $it->theImage = $column->value;
                        }
                    } else if ($component->type == 'select') {
                        $column = @$it->$name;
                        $specs = json_decode($component->attributes);
                        $it->$name = $column;
                        if (@$specs->from == 'string') {
                            $opts = explode(',', $specs->source);
                            foreach ($opts as $l => $op) {
                                if ($column == ($l + 1)) {
                                    $it->$name = $op;
                                }
                            }
                        }
                        if (@$specs->from == 'json') {
                            $opts = $specs->source;
                            foreach ($opts as $l => $op) {
                                if ($column == $op) {
                                    $it->$name = $op;
                                }
                            }
                        }
                        if (@$specs->from == 'module') {
                            //obener el listado de items validos del modulo seleccionado
                            $moduleId = @$specs->module;
                            //nombre de la tabla a consultar
                            $this->db->select('friendly');
                            $modulo = $this->db->get_where('modules', array('id' => $moduleId))->row();
                            //nombre del campo a a mostrar al usuario
                            $this->db->select('name');
                            $this->db->order_by('position', 'ASC');
                            $componente = $this->db->get_where('module_fields', array('content_id' => $moduleId, 'type' => 'input'))->row();
                            //registro a consultar
                            $nombre = $componente->name;
                            $this->db->select($modulo->friendly . '.shared, ' . $modulo->friendly . '.' . $nombre);
                            $this->db->order_by($modulo->friendly . '.position', 'ASC');
                            if (@$specs->selectable == 'multiple') {
                                $relation = $module->friendly . '_has_' . $component->name;
                                $this->db->join($relation, $modulo->friendly . '.shared = ' . $relation . '.' . $modulo->friendly . '_id');
                                $this->db->where_in($relation . '.' . $module->friendly . '_id', $it->id);
                                $query = $this->db->get($modulo->friendly);
                                if ($query->num_rows > 0) {
                                    $opts = $query->result();
                                    $sts = "";
                                    foreach ($opts as $l => $opt) {
                                        $coma = ($l > 0) ? ',' : "";
                                        $sts .= $coma . $opt->$nombre;
                                    }
                                    $it->$name .= $sts;
                                }
                            } else {
                                $opt = $this->db->get_where($modulo->friendly, array('shared' => $column));
                
                                if ($opt->num_rows > 0) {
                                    $opt = $opt->row();
                                    $it->$name = $opt->$nombre;
                                }
                            }
                        }
                    } else if ($component->type == 'editor') {
                        $content = $it->$name;
                        $it->$name = $this->lowText(strip_tags($content), 20);
                    }
                }
            }
        }
        $this->tp['items'] = $items;
        $this->tp['module'] = $module;
        //    $this->debug($items , true);
        if ($alert == 1) {
            $this->tp['alert'] = $this->tp['contenido'] . ' creado con &eacute;xito';
        }
        if ($alert == 2) {
            $this->tp['alert'] = $this->tp['contenido'] . ' actualizado con &eacute;xito';
        }
        if ($alert == 3) {
            $this->tp['alert'] = 'El ' . $this->tp['contenido'] . ' ha sido borrado';
        }
        $this->load->view('list', $this->tp);
    }
    public function create($moduleId = "", $lang = 1, $accion = 'crear')
    {
        $module = $this->getModule($moduleId);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id != 0 && @$this->permisos->edi != 't') {
            exit();
        }
        $shared = time();
        $datos = array(
            'lang_id' => 1,
            'shared' => $shared,
            'created' => date('Y-m-d H:i:s'),
            'status_id' => 'borrador', // borrador | papelera | publico | oculto
            'father_id' => 0,
        );
        /*
         * realizo el insert en la tabla correspondiente
         */
        $this->db->insert($module->friendly, $datos);
        //
        header('location:' . $this->tp['site_url'] . $this->tp['controller'] . '/edit/' . $module->id . '/' . $shared . '/1/' . $accion);
    }
    public function edit($moduleId = "", $shared, $lang = 1, $accion = "editar")
    {
        $module = $this->getModule($moduleId, true);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id != 0 && @$this->permisos->edi != 't') {
            exit();
        }
        $this->tp['titulo'] = $module->title;
        $this->tp['contenido'] = $module->title;
        if ($_POST) {
            $post = $this->input->post(null, true);
            foreach ($post['_Idioma'] as $k => $i) {
                $datos = $this->procesarData($module->friendly, $k, $post['_idItem'][$k]);
                $datos['lang_id'] = $i;
                $datos['shared'] = $shared;
                $datos['modify'] = date('Y-m-d H:i:s');
                if ($this->user->rol_id == 0 || @$this->permisos->pub == 't') {
                    $status = (@$post['status_id'] != "") ? $post['status_id'] : 'oculto';
                    $datos['status_id'] = $status;
                }
                if ($this->user->rol_id != 0 && @$this->permisos->pub != 't') {
                    $datos['status_id'] = 'oculto';
                }
                $this->db->update($module->friendly, $datos, array('id' => $post['_idItem'][$k]));
            }
            $json = array('success' => true, 'params' => $this->tp['controller'] . '/index/' . $module->id . '/2/' . $lang);
            exit(json_encode($json));
        }
        $color = 'e7f7d0';
        $acto = 'Editando';
        $modo = 'Editar';
        $boton = 'Actualizar';
        if ($accion == 'crear') {
            $color = "d3e9f2";
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
    private function procesarData($table = "", $k, $id)
    {
        //
        $post = $this->input->post(null, true);
        //
        $data = array();
        $delIn = array();
        //
        foreach ($post as $key => $ps) {
            if ($key == '_Idioma'
                || $key == '_idItem'
                || $key == 'status_id'
            ) {
                continue;
            }
            if ($key == '_lanlong') {
                $lats = $post['_lanlong'][$k];
                foreach ($lats as $llave => $latlong) {
                    if (!empty($latlong)) {
                        $latlng = explode(', ', $latlong);
                        $data['lat_' . $llave] = $latlng[0];
                        $data['lng_' . $llave] = $latlng[1];
                    }
                }
            } elseif ($key == '_multiSelect') {
                $components = $post['_multiSelect'][$k];
                //borrar items clasicos
                foreach ($components as $component => $item) {
                    $this->db->delete($table . '_has_' . $component, array(
                        $table . '_id' => $id,
                    ));
                }
                //agregar nuevos items
                foreach ($components as $component => $items) {
                    $dataItems = array();
                    foreach ($items as $item) {
                        $info = array(
                            $table . '_id' => $id
                            , $component . '_id' => $item,
                        );
                        $dataItems[] = $info;
                    }
                    if (count($dataItems) > 0) {
                        $this->db->insert_batch($table . '_has_' . $component, $dataItems);
                    }
                }
            } elseif ($key == '_compImage') {
                $imgs = $post['_compImage'][$k];
                foreach ($imgs as $llave => $img) {
                    if (@$img != "") {
                        $img_name = $img;
                        if (file_exists($this->tmp_dir . $img)) {
                            $img_tmp = $this->tmp_dir . $img;
                            $inf = pathinfo($img_tmp);
                            $img_name = $llave . '-' . md5(microtime()) . '.' . $inf['extension'];
                            $img_new = $this->img_dir . $img_name;
                            rename($img_tmp, $img_new);
                        }
                        $data[$llave] = $img_name;
                    }
                }
            } elseif ($key == '_compDocument') {
                $docs = $post['_compDocument'][$k];
                foreach ($docs as $llave => $doc) {
                        if (@$doc != "") {
                                $doc_name = $doc;
                                if (file_exists($this->tmp_dir . $doc)) {
                            $doc_tmp = $this->tmp_dir . $doc;
                            $inf = pathinfo($doc_tmp);
                            $doc_name = $llave . '-' . md5(microtime()) . '.' . $inf['extension'];
                            $doc_new = $this->doc_dir . $doc_name;
                                        rename($doc_tmp, $doc_new);
                        }
                                $data[$llave] = $doc_name;
                    }
                }
            } elseif ($key == '_compGallery') {
                $components = $post['_compGallery'][$k];
                foreach ($components as $component => $items) {
                    $images = $items['image'];
                    $descs = @$items['desc'];
                    $imgData = array();
                        foreach ($images as $llave => $img) {
                                if (@$img != "") {
                                        $img_name = $img;
                            if (file_exists($this->tmp_dir . $img)) {
                                $img_tmp = $this->tmp_dir . $img;
                                $inf = pathinfo($img_tmp);
                                $img_name = $component . '-gallery-' . md5(microtime()) . '.' . $inf['extension'];
                                $img_new = $this->img_dir . $img_name;
                                                rename($img_tmp, $img_new);
                            }
                            $imginfo = array(
                                'content_id' => $id
                                , 'value' => $img_name
                                , 'description' => $descs[$llave]
                                , 'created' => date('Y-m-d H:i:s'),
                            );
                            $imgData[] = $imginfo;
                        }
                    }
                    if (count($imgData) > 0) {
                        $this->db->insert_batch($table . '_' . $component . '_gallery', $imgData);
                    }
                }
            } else {
                if (is_array($ps)) {
                    $value = $ps[$k];
                } else {
                    $value = $ps;
                }
                $data[$key] = $value;
            }
        }
        //
        return $data;
    }
    private function getModule($moduleId, $components = false, $cantidadComponentes = 0)
    {
        if (!is_numeric($moduleId)) {
            exit('Modulo no especificado, consulte a su proveedor para temas de soporte.');
        }
        $this->db->select('id, title, friendly, description, content, shared');
        $module = $this->db->get_where($this->tablecore, array('id' => $moduleId, 'status_id' => 'publico'));
        if ($module->num_rows() <= 0) {
            exit('Modulo no habilitado, consulte a su proveedor para temas de soporte.');
        }
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
    public function get_categorias_select($retornar = false)
    {
        $this->db->select('shared, description');
        $this->db->order_by('id', 'DESC');
        $this->db->where_in('typefile_id', array('categoria_infraestructura', 'categoria_edificaciones'));
        $this->tp['categorias'] = $this->db->get($this->tablemedia)->result();
        if ($retornar) {
            return $this->tp['categorias'];
        }
        $this->load->view('categorias-select', $this->tp);
    }
    /* COMPONENTE DUPLICADOR */
    public function get_items_duplicator($page = 1, $padreId, $componentId)
    {
        //traer la informacion del componente
        $this->db->select('*');
        $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
        $component->specs = json_decode($component->attributes);
        //del componente traer los 3 primeros fields
        $this->db->select('description, name, type');
        $this->db->order_by('position', 'ASC');
        $fields = $this->db->get_where($this->tabletags, array('father_id' => $componentId, 'status_id' => 'publico'))->result();
        //datos del modulo  para obtener la tabla a buscar.
        $module = $this->getModule($component->content_id);
        $this->setCurrentUser($module->friendly);
        //paginador
        $where = array('content_id' => $padreId);
        $total = $this->db->get_where($module->friendly . '_' . $component->name, $where)->num_rows();
        $perpage = 5;
        $cont = ceil($total / $perpage);
        $div = '#ListadoItemsDe' . $padreId . '-' . $componentId;
        $this->tp['pagination'] = $this->miPaginador($cont, $page, $div, $padreId, $componentId);
        //
        $page = ($page - 1) * $perpage;
        $this->db->limit($perpage, $page);
        //traer items hijos del contenido y que el tipo coinsida con el name del componente
        $this->db->order_by('position', 'ASC');
        $items = $this->db->get_where($module->friendly . '_' . $component->name, $where)->result();
        $this->tp['fields'] = $fields;
        $this->tp['items'] = $items;
        $this->tp['component'] = $component;
        $this->load->view('items-duplicator', $this->tp);
    }
    //
    public function get_item_duplicator($id = 0, $padreId = 0, $componentId = 0)
    {
        //
        if ($componentId == 0 || !is_numeric($componentId)) {
            exit('Error en la ejecución del, componente.');
        }
        //traer la informacion del componente
        $this->db->select('*');
        $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
        $module = $this->getModule($component->content_id);
        $specs = json_decode($component->attributes);
        $item = (object) array();
        if ($id != 0) {
            //    $this->db->select('value as imagen, description, link, status_id, typefile_id');
            $item = $this->db->get_where($module->friendly . '_' . $component->name, array('id' => $id))->row();
            //
            //$item->id = $result->id;
            //$item->status_id = $result->status_id;
            //$item->position = $result->position;
            //$json = json_decode($result->value);
            //foreach($json as $name => $value){
            //    $item->$name = $value;
            //}
        } else {
            if (@$specs->tot != null && $specs->tot != 0) {
                //contar el numero total de items permitidos para este duplicador
                $act = $this->db->get_where($module->friendly . '_' . $component->name, array('content_id' => $padreId))->num_rows();
                if ($act >= $specs->tot) {
                    exit('<div class="col-sm-12">Ha alcazado el numero máximo de: ' . $component->description . '</div>');
                }
            }
        }
        $this->db->select('*');
        $this->db->order_by('position', 'ASC');
        $components = $this->db->get_where($this->tabletags, array('father_id' => $componentId, 'status_id' => 'publico'))->result();
        $componentes = "";
        foreach ($components as $component) {
            $componentes .= $this->getTemplate($component, 0, $item);
            //print_r($componentes);exit();
        }
        if (@$specs->publish == "true") {
            $component_publish = (object) array(
                'description' => 'Publicar'
                , 'name' => 'status_id'
                , 'type' => 'select'
                , 'size' => 6
                , 'attributes' => json_encode(array(
                    'from' => 'json'
                    , 'source' => json_encode(array(
                        'publico' => 'Público'
                        , 'oculto' => 'Oculto',
                    )),
                )),
            );
            $separador = (object) array(
                'description' => 'Separador'
                , 'name' => 'separador'
                , 'type' => 'separarator'
                , 'size' => 12,
            );
            $componentes .= $this->getTemplate($separador, 0, $item);
            $componentes .= $this->getTemplate($component_publish, 0, $item);
        }
        if (@$specs->order == "true") {
            $component_orden = (object) array(
                'description' => 'Posición'
                , 'name' => 'position'
                , 'type' => 'input'
                , 'size' => 6
                , 'attributes' => json_encode(array(
                    'validations' => 'onlynum',
                )),
            );
            $componentes .= $this->getTemplate($component_orden, 0, $item);
        }
        exit($componentes);
    }
    //
    public function set_item_duplicator($id = 0, $padreId, $componentId)
    {
        //
        if ($_POST) {
            //obtener informacion del componente
            $this->db->select('content_id, name, attributes, description');
            $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
            $module = $this->getModule($component->content_id);
            $this->setCurrentUser($module->friendly);
            if ($this->user->rol_id != 0 && @$this->permisos->edi != 't') {
                exit();
            }
            $data = $this->procesarData($module->friendly, 0, $id);
            $position = 0;
            $post = $this->input->post(null, true);
            $status = (@$post['status_id'][0] != "") ? $post['status_id'][0] : 'oculto';
            $data['status_id'] = $status;
            if (array_key_exists('position', $data)) {
                $position = (is_numeric($data['position'])) ? $data['position'] : 0;
                unset($data['position']);
                $data['position'] = $position;
            }
            $data['content_id'] = $padreId;
            if ($id == 0) {
                $specs = json_decode($component->attributes);

                if (@$specs->tot != null && $specs->tot != 0) {
                    //contar el numero total de items permitidos para este duplicador
                    $act = $this->db->get_where($this->tabletags, array('content_id' => $padreId, 'type' => $component->name))->num_rows();
                    if ($act >= $specs->tot) {
                        exit(json_encode(array('success' => false, 'msj' => 'Ha alcazado el numero máximo de: ' . $component->description)));
                    }
                }
                //insertar el item del duplicador
                $this->db->insert($module->friendly . '_' . $component->name, $data);
            } else {
                $this->db->update($module->friendly . '_' . $component->name, $data, array('id' => $id));
            }
            exit(json_encode(array('success' => true)));
        }
    }
    //
    public function del_item_duplicator($id = "", $padreId, $componentId)
    {
        $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
        $module = $this->getModule($component->content_id);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id == 0 || @$this->permisos->del == 't') {
            $this->db->delete($module->friendly . '_' . $component->name, array('id' => $id, 'content_id' => $padreId));
        }
        header('Location:' . $this->config->site_url() . $this->tp['controller'] . '/get_items_duplicator/1/' . $padreId . '/' . $componentId);
    }
    //
    public function pub_item_duplicator($val, $id, $padreId, $componentId)
    {
        $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
        $module = $this->getModule($component->content_id);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id == 0 || @$this->permisos->edi == 't') {
            $this->db->update($module->friendly . '_' . $component->name, array('status_id' => $val), array('id' => $id, 'content_id' => $padreId));
        }
        header('Location:' . $this->config->site_url() . $this->tp['controller'] . '/get_items_duplicator/1/' . $padreId . '/' . $componentId);
    }
    /* COMPONENTE DUPLICADOR */
    /*
     * Metodo basicos para todos los formularios con gallery
     */
    public function update_image($id, $componentId)
    {
        $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
        $module = $this->getModule($component->content_id);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id == 0 || @$this->permisos->edi == 't') {
            if ($_POST) {
                //post
                $this->db->update($module->friendly . '_' . $component->name . '_gallery', $_POST, array('id' => $id));
                exit();
            }
            $this->db->select('description');
            $item = $this->db->get_where($module->friendly . '_' . $component->name . '_gallery', array('id' => $id))->row();
            exit(json_encode($item));
        }
    }
    public function update_positions($items)
    {
        $get = $this->input->get(null, true);
        $componentId = $get['component'];
        $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
        $module = $this->getModule($component->content_id);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id == 0 || @$this->permisos->edi == 't') {
            $items = substr($items, 0, -1);
            $items = explode("_", $items);
            $update = array();
            $pos = 1;
            foreach ($items as $id) {
                $update['position'] = $pos;
                $this->db->update($module->friendly . '_' . $component->name . '_gallery', $update, array('id' => $id));
                $pos++;
            }
        }
    }
    public function publish_image($status, $id, $content_id, $componentId)
    {
        $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
        $module = $this->getModule($component->content_id);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id == 0 || @$this->permisos->edi == 't') {
            //update status
            $this->db->update($module->friendly . '_' . $component->name . '_gallery', array('status_id' => $status), array('id' => $id));
            $this->get_images_gallery($content_id, $componentId);
        }
    }
    public function delete_image($id, $content_id, $componentId)
    {
        $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
        $module = $this->getModule($component->content_id);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id == 0 || @$this->permisos->del == 't') {
            $data = $this->db->get_where($module->friendly . '_' . $component->name . '_gallery', array('id' => $id, 'content_id' => $content_id))->row();
            unlink($this->img_dir . $data->value);
            $this->db->delete($module->friendly . '_' . $component->name . '_gallery', array('id' => $id));
        }
        $this->get_images_gallery($content_id, $componentId);
    }
    public function get_images_gallery($content_id, $componentId)
    {
        $this->db->select('id, content_id, name, attributes');
        $component = $this->db->get_where($this->tabletags, array('id' => $componentId))->row();
        $this->tp['component'] = $component;
        $this->tp['specs'] = json_decode($component->attributes);
        $module = $this->getModule($component->content_id);
        //
        $this->db->order_by('position', 'ASC');
        $this->db->select('id, content_id, value, description, status_id');
        $this->tp['imgs'] = $this->db->get_where($module->friendly . '_' . $component->name . '_gallery', array('content_id' => $content_id))->result();
        //
        $this->load->view($this->tp['controller'] . '/gallery', $this->tp);
    }
    /*
     * Metodo basicos para todos los controladores
     */
    public function publish($val, $shared, $moduleId)
    {
        //si esta definido padre_shared entonces muestra a los hijos
        $module = $this->getModule($moduleId);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id == 0 || @$this->permisos->pub == 't') {
            $this->db->update($module->friendly, array('status_id' => $val), array('shared' => $shared));
        }
        header('Location:' . $this->config->site_url() . $this->tp['controller'] . '/index/' . $moduleId . '/2/1/');
    }
    public function delete($moduleId, $shared)
    {
        $module = $this->getModule($moduleId);
        $this->setCurrentUser($module->friendly);
        if ($this->user->rol_id == 0 || @$this->permisos->del == 't') {
            $this->db->update($module->friendly, array('status' => 'papelera'), array('shared' => $shared));
        }
        header('Location:' . $this->config->site_url() . $this->tp['controller'] . '/index/' . $moduleId . '/3/1/');
    }
    public function simple_delete($id, $moduleId)
    {
        $module = $this->getModule($moduleId);
        if ($this->user->rol_id == 0 || @$this->permisos->del == 't') {
            $this->db->update($module->friendly, array('status' => 'papelera'), array('id' => $id));
        }
        header('Location:' . $this->config->site_url() . $this->tp['controller'] . '/index/' . $moduleId . '/3/1/');
    }
}
