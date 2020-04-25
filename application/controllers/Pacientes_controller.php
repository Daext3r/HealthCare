<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.
class Pacientes_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      
      $this->load->model("Pacientes_model");
   }

   public function alta()
   {
      $usuario = $this->input->post("usuario");
      $medico = $this->input->post("medico");
      $enfermero = $this->input->post("enfermero");
      $grupo_sanguineo = $this->input->post("grupo_sanguineo");
     

      echo $this->Pacientes_model->alta($usuario, $medico, $enfermero, $grupo_sanguineo);

   }
}
