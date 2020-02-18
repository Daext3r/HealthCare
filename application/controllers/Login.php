<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		//carga el head con una hoja de estilos
		$this->load->view("modules/head", array("hojas" => array("login")));
		
		//carga la vista de login
        $this->load->view("Login_v");
	}

	public function autenticar() {
		//metodo llamado por el formulario de login
		$correo = $this->input->post("email");
		$clave = hash("sha512", $this->input->post("clave"));

		$this->load->model("Login_m");
		$this->Login_m->autenticar($correo, $clave);

	}
}
