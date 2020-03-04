<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.
//Para ello usaremos una variable POST llamada ajax, que deberá estar a true para poder acceder
class Tratamientos_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->input->is_ajax_request()) {
            redirect(base_url());
            return;
        }

        $this->load->model("Tratamientos_model");
    }
}