<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
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
        $this->resources = base_url() . "assets/";
        $this->load->library('email');
    }

    public function index()
    {
        $this->tp['title'] = "Inicio - Pilas con el ambiente";
        $this->tp['assets'] = $this->resources;
        $this->tp['site_url'] = base_url();
        $this->load->view('inc/head', $this->tp);
        $this->tp['formDefault'] = true;
        $this->load->view('inc/header', $this->tp);

        $this->load->view('inicio', $this->tp);
        $this->tp['sectionClass'] = 'bodyhome';
        $this->load->view('inc/footer', $this->tp);
    }

    public function register()
    {
        $data = $this->input->post(NULL, TRUE);
        $mensaje = "
			<b>Nombre:</b> {$data['empresa']}<br>
			<b>Correo:</b> {$data['nombre']}<br>
			<b>Mensaje:</b> {$data['tipo_documento']}<br>
			<b>Nombre:</b> {$data['numero_documento']}<br>
			<b>Correo:</b> {$data['direccion']}<br>
			<b>Mensaje:</b> {$data['ciudad']}<br>
			<b>Nombre:</b> {$data['telefono']}<br>
			<b>Correo:</b> {$data['email']}<br>
			<b>Mensaje:</b> {$data['mensaje']}
		";

        if ($this->sendSMTPEmailByMail('info-digital@pilascolombia.com', $mensaje, 'Registro empresa') !== true) {
            // Generate error
            echo '{"answer": false}';
        } else {
            echo '{"answer": true}';
        }
    }

    public function sticker()
    {
        $data = $this->input->post(NULL, TRUE);
        $mensaje = "
			<b>Nombre:</b> {$data['nombre']}<br>
			<b>Correo:</b> {$data['email']}<br>
			<b>Mensaje:</b> {$data['telefono']}<br>
			<b>Mensaje:</b> {$data['empresa']}
		";

        if ($this->sendSMTPEmailByMail('info-digital@pilascolombia.com', $mensaje, 'Stickers') !== true) {
            // Generate error
            echo '{"answer": false}';
        } else {
            //Descargar archivo
            echo '{"answer": true, "path_file": "' . $this->resources . 'images/documentacion/Sticker_INSTITUCIONAL.pdf"}';
        }
    }

    public function contact()
    {
        $data = $this->input->post(NULL, TRUE);
        $mensaje = "";
        if (array_key_exists("nombre", $data)) {
            $mensaje .= "<b>Nombre:</b> {$data['nombre']}<br>";
        }
        if (array_key_exists("celular", $data)) {
            $mensaje .= "<b>Celular:</b> {$data['celular']}<br>";
        }
        if (array_key_exists("correo", $data)) {
            $mensaje .= "<b>Correo:</b> {$data['correo']}<br>";
        }
        if (array_key_exists("razon_social", $data)) {
            $mensaje .= "<b>Razón Social:</b> {$data['razon_social']}<br>";
        }
        if (array_key_exists("select-tipo-empresa", $data)) {
            $mensaje .= "<b>Tipo de empresa:</b> {$data['select-tipo-empresa']}<br>";
        }
        if (array_key_exists("select-asunto", $data)) {
            $mensaje .= "<b>Asunto:</b> {$data['select-asunto']}<br>";
        }
        if (array_key_exists("mensaje", $data)) {
            $mensaje .= "<b>Mensaje:</b> {$data['mensaje']}";
        }
        if ($this->sendSMTPEmailByMail('info-digital@pilascolombia.com', $mensaje, 'Contactenos') !== true) {
            // Generate error
            echo '{"answer": false}';
        } else {
            echo '{"answer": true}';
        }
    }

    private function sendSMTPEmailByMail($to, $msg, $subject, $cc = 'daniel.escobar@zavgroup.com')
    {
        $this->load->library('email');
        $result = $this->email
            ->from('info-digital@pilascolombia.com')
            ->reply_to($cc)   
            ->to($to)
            ->subject($subject)
            ->message($msg)
            ->send();
        return $result;
    }
}