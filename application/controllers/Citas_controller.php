<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.
//Para ello usaremos una variable POST llamada ajax, que deberá estar a true para poder acceder
class Citas_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->input->post("ajax")) {
            redirect(base_url());
            return;
        }

        $this->load->model("Citas_model");
    }

    public function borrarCita()
    {
        $cita = $this->input->post("cita");

        $paciente = null;

        if ($this->input->post("propia") == true) {
            $paciente = $this->session->userdata("ciu");
        } else {
            $paciente = $this->input->post("ciu");
        }

        echo ($this->Citas_model->borrarCita($cita, $paciente)) ? true : false;
    }
}
