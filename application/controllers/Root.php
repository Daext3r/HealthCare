<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Root extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //si el usuario no es root lo sacamos de aqui y lo mandamos al login
        if ($this->session->userdata("ciu") != 'root') {
            redirect(base_url() . 'login');
        }

        //cargamos los datos del usuario llamando al modelo
        $this->load->model("Usuarios_model");

        $datos = $this->Usuarios_model->leerDatos($this->session->userdata("ciu"));

        $this->session->set_userdata($datos);

        //guardamos el tipo de perfil, root
        $this->session->set_userdata("tipo", "root");
    }

    public function inicio()
    {
        //carga el head con las hojas de estilos y scripts necesarios
        $this->load->view("modules/head", array(
            "hojas" => array("modules/panel", "modules/panel-responsive"),
            "scripts" => array("utils/common")
        ));

        //carga el modulo principal
        $this->load->view("modules/panel");
    }

    public function crear($item)
    {
        if ($item == 'usuario') {

            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/head", array(
                "hojas" => array("modules/panel", "modules/panel-responsive"),
                "scripts" => array("utils/common")
            ));

            //carga el modulo principal
            $this->load->view("modules/panel");

            $this->load->view("modules/registro-usuario");
        }
    }
}
