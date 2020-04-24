<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.
class Facultativos_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model("Facultativos_model");
   }

   public function buscarEspecialidad()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      echo json_encode($this->Facultativos_model->buscarEspecialidad($this->input->post("especialidad")));
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

   public function buscarFacultativoNombre() {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $nombre = $this->input->post("nombre");
      echo json_encode($this->Facultativos_model->buscarFacultativoNombre($nombre));
   }
}
