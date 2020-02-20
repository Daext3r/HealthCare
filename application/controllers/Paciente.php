<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paciente extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
        $ciu = $this->session->userdata("CIU");

        //cargamos los datos del usuario llamando al modelo
        $this->load->model("Paciente_m");
        $datos = $this->Paciente_m->leerDatos($ciu);
        
        //guardamos los datos en la sesion
        foreach($datos as $clave => $valor) {
            $this->session->set_userdata($clave, $valor);
        }

        //carga el head con una hoja de estilos
		$this->load->view("modules/head", array("hojas" => array("paciente")));

		//carga la vista de inicio
        $this->load->view("paciente/Panel_v");
        
	}
}
