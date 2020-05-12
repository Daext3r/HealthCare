<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analiticas_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $this->load->model("Analiticas_model");
   }

   public function nuevaAnalitica()
   {
      echo $this->Analiticas_model->nuevaAnalitica($this->input->post("paciente"), $this->session->userdata("ciu"), $this->input->post("pruebas"));
   }
}
