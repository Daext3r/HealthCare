<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		//carga el head con una hoja de estilos
		$this->load->view("modules/ViewModule_Head", array("hojas" => array("utils/inicio")));

		//carga la vista de inicio
		$this->load->view("Inicio_v");
	}
}
