<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboratorio_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }
      
      $this->load->model("Laboratorio_model");
   }

   public function registrarPersonal()
   {
      echo $this->Laboratorio_model->registrarPersonal($this->input->post("usuario"), $this->input->post("centro"));
   }

   public function leerAnaliticasAtendidas()
   {
      $lab = $this->session->userdata("ciu");

      echo json_encode($this->Laboratorio_model->leerAnaliticasAtendidas($lab));
   }
}
