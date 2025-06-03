<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puntos extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct()
	{
       parent::__construct();
       $this->resources = base_url()."assets/";
			 $this->load->database(); 

	}
	
	public function index()	{
		$this->db->select('departamento, ciu_munic, nombre, sede, tipo_ent, barrio, 
                      lat_ubicacion AS lat, lng_ubicacion AS lng, 
                      direccion, tipo_cont, status_id');
		$module = $this->db->get('web_puntosderecoleccion');

		$this->tp['title'] = "Puntos de Recoleccion";
		$this->tp['assets'] = $this->resources;	
		$this->tp['site_url'] = base_url();
		$this->load->view('inc/head', $this->tp);
		$this->tp['formDefault'] = true;
		$this->load->view('inc/header', $this->tp);
		$this->tp['puntos'] = json_encode($module->result_array());
		$this->load->view('puntos', $this->tp);
		$this->tp['sectionClass']='bodyhome';
		$this->load->view('inc/footer', $this->tp);
	}
}