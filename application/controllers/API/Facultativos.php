<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.
class Facultativos extends CI_Controller
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
      echo json_encode($this->Facultativos_model->buscarFacultativoNombre($this->input->post("nombre")));
   }

   public function buscarFacultativoCiuNombre()
   {
      echo json_encode($this->Facultativos_model->buscarFacultativoCiuNombre($this->input->post("dato")));
   }

   public function leerEnfermedadesPaciente()
   {
      echo $this->Facultativos_model->leerEnfermedadesPaciente($this->input->post("paciente"));
   }

   public function actualizarEnfermedadesPaciente()
   {
      echo $this->Facultativos_model->actualizarEnfermedadesPaciente($this->input->post("paciente"), $this->input->post("enfermedades"));
   }

   public function leerAnaliticasPaciente()
   {
      echo json_encode($this->Facultativos_model->leerAnaliticasPaciente($this->input->post("paciente")));
   }
}
