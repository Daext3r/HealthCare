<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		//borramos todos los datos de sesión que existan
		$this->session->sess_destroy();

		//carga el head con una hoja de estilos
		$this->load->view("modules/head", array("hojas" => array("utils/login"), "scripts" => array("utils/login")));

		//carga la vista de login
		$this->load->view("Login_v");
	}
}
