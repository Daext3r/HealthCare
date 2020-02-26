<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paciente extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //si no tiene CIU es que no ha pasado por el login, lo redirigimos al mismo
        if (!$this->session->userdata("CIU")) {
            //redirigimos al login
            redirect(base_url() . "login");
        }

        //carga el head con una hoja de estilos
        $this->load->view("modules/head", array("hojas" => array("paciente")));

        //carga el modulo principal
        $this->load->view("modules/panel-paciente");
    }

    public function logout()
    {
        //el propio login borra la sesion
        redirect(base_url() . "login");
    }

    public function inicio()
    {
        $ciu = $this->session->userdata("CIU");

        //cargamos los datos del usuario llamando al modelo
        $this->load->model("Paciente_m");
        $datos = $this->Paciente_m->leerDatos($ciu);

        //guardamos los datos en la sesion
        foreach ($datos as $clave => $valor) {
            $this->session->set_userdata($clave, $valor);
        }

        //carga la vista de inicio
        $this->load->view("paciente/Inicio_v");
    }

    public function citas()
    {
        //carga la vista de inicio
        $this->load->view("paciente/Citas_v");
    }

    public function informes()
    {
        //carga la vista de inicio
        $this->load->view("paciente/Informes_v");
    }

    public function tratamientos()
    {
        //carga la vista de inicio
        $this->load->view("paciente/Tratamientos_v");
    }

    public function misdatos()
    {
        //carga la vista de inicio
        $this->load->view("paciente/MisDatos_v");
    }
}
