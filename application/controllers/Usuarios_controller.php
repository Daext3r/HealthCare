<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Usuarios_model");
    }

    public function leerNotificaciones()
    {

        //si no es una peticion ajax redirigimos al inicio
        if (!$this->input->is_ajax_request()) {
            redirect(base_url() . "paciente/inicio");
            return;
        }

        //cargamos las notificaciones y las devolvemos
        $notifs = $this->Usuarios_model->leerNotificaciones($this->session->userdata("ciu"));
        echo json_encode($notifs);
    }

    public function borrarNotificacion()
    {
        //si no es una peticion ajax redirigimos al inicio
        if (!$this->input->is_ajax_request()) {
            redirect(base_url() . "paciente/inicio");
            return;
        }

        //borramos la notifiacion
        $this->Usuarios_model->borrarNotificacion($this->input->post("id"));
    }
}
