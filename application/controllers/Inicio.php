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
        $mensaje = "";
        $mensaje .= "Nombre: {$data['empresa']}\n";
        $mensaje .= "Empresa: {$data['nombre']}\n";
        $mensaje .= "Tipo de documento: {$data['tipo_documento']}\n";
        $mensaje .= "Numero de Documento: {$data['numero_documento']}\n";
        $mensaje .= "Direccion: {$data['direccion']}\n";
        $mensaje .= "Ciudad: {$data['ciudad']}\n";
        $mensaje .= "Telefono: {$data['telefono']}\n";
        $mensaje .= "Email: {$data['email']}\n";
        $mensaje .= "Mensaje: {$data['mensaje']}\n";

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
        $mensaje = "";
        $mensaje .= "Nombre: {$data['nombre']}\n";
        $mensaje .= "Correo: {$data['email']}\n";
        $mensaje .= "Telefono: {$data['telefono']}\n";
        $mensaje .= "Empresa: {$data['empresa']}\n";

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
            $mensaje .= "Nombre: {$data['nombre']}\n";
        }
        if (array_key_exists("celular", $data)) {
            $mensaje .= "Celular: {$data['celular']}\n";
        }
        if (array_key_exists("correo", $data)) {
            $mensaje .= "Correo: {$data['correo']}\n";
        }
        if (array_key_exists("razon_social", $data)) {
            $mensaje .= "Razón Social: {$data['razon_social']}\n";
        }
        if (array_key_exists("select-tipo-empresa", $data)) {
            $mensaje .= "Tipo de empresa: {$data['select-tipo-empresa']}\n";
        }
        if (array_key_exists("select-asunto", $data)) {
            $mensaje .= "Asunto: {$data['select-asunto']}\n";
        }
        if (array_key_exists("mensaje", $data)) {
            $mensaje .= "Mensaje: {$data['mensaje']}\n";
        }
        if ($this->sendSMTPEmailByMail('info-digital@pilascolombia.com', $mensaje, 'Contactenos') !== true) {
            // Generate error
            echo '{"answer": false}';
        } else {
            echo '{"answer": true}';
        }
    }

    private function sendSMTPEmailByMail($to, $msg, $subject, $cc = '')
    {
        $this->load->library('email');
        $this->email->set_mailtype('text');
        $this->email->set_alt_message('');
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