<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paciente extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //si no tiene ciu es que no ha pasado por el login, lo redirigimos al mismo
        if (!$this->session->userdata("ciu")) {
            //redirigimos al login
            redirect(base_url() . "login");
            return;
        }

        //si no tiene nombre, carga los datos
        if ($this->session->userdata("ciu")) {

            //cargamos los datos del usuario llamando al modelo
            $this->load->model("Paciente_m");

            $datos = $this->Paciente_m->leerDatos($this->session->userdata("ciu"));

            $this->session->set_userdata($datos);
        }


        //carga el head con la hoja de estilos general
        $this->load->view("modules/head", array("hojas" => array("paciente/panel-paciente", "paciente/panel-paciente-responsive")));

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
        //carga la vista de inicio
        $this->load->view("paciente/Inicio_v");
    }

    public function citas()
    {
        $this->load->model("Paciente_m");
        $citas = $this->Paciente_m->leerCitas($this->session->userdata("ciu"));
        
        $facultativos = $this->Paciente_m->leerFacultativos($this->session->userdata("ciu"));
        
        //carga la vista de inicio
        $this->load->view("paciente/Citas_v", array("hojasEstilos" => array("paciente/panel-paciente", "paciente/panel-paciente-responsive"), "citas" => $citas, "facultativos" => $facultativos));
    }

    public function tratamientos()
    {
        //carga la vista de inicio
        $this->load->view("paciente/Tratamientos_v");
    }

    public function informes()
    {
        //carga la vista de inicio
        $this->load->view("paciente/Informes_v");
    }

    public function misdatos()
    {
        //carga la vista de inicio
        $this->load->view("paciente/MisDatos_v");
    }

    public function actualizarDatos() {
        //TODO: si no tiene datos por POST redirigimos a inicio
        //si los tiene verificamos los datos
    }
}
