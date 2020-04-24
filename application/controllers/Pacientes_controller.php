<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.
class Pacientes_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model("Pacientes_model");
   }

   public function alta()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $usuario = $this->input->post("usuario");
      $colegiado = $this->input->post("colegiado");
      $sala = $this->input->post("sala");
      $especialidad = $this->input->post("especialidad");
      $centro = $this->input->post("centro");

      echo $this->Facultativos_model->alta($usuario, $colegiado, $especialidad, $sala, $centro);

   }
}
