<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.
class Facultativos_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $this->load->model("Facultativos_model");
   }

   public function buscarEspecialidad()
   {
      echo json_encode($this->Facultativos_model->buscarEspecialidad($this->input->post("especialidad")));
   }

   public function alta()
   {
      $usuario = $this->input->post("usuario");
      $colegiado = $this->input->post("colegiado");
      $sala = $this->input->post("sala");
      $especialidad = $this->input->post("especialidad");
      $centro = $this->input->post("centro");

      echo $this->Facultativos_model->alta($usuario, $colegiado, $especialidad, $sala, $centro);
   }

   public function buscarFacultativoNombre()
   {
      $nombre = $this->input->post("nombre");
      echo json_encode($this->Facultativos_model->buscarFacultativoNombre($nombre));
   }
}
