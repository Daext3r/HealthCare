<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.

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

   public function leerTratamientos()
   {
      echo json_encode($this->Tratamientos_model->leerTratamientos($this->session->userdata("ciu")));
   }

   //este metodo es usado por los facultativos. el anterior solo por pacientes
   public function leerTratamientosFacultativo()
   {
      echo json_encode($this->Tratamientos_model->leerTratamientosFacultativo($this->input->post("paciente")));
   }

   public function borrarTratamiento()
   {
      echo $this->Tratamientos_model->borrarTratamiento($this->input->post("id"));
   }
   public function agregarTratamiento()
   {
      $nregistro = $this->input->post("nregistro");

      $tomas = $this->input->post("tomas");
      $paciente = $this->input->post("paciente");
      $fecha_inicio = $this->input->post("fecha_inicio");
      $fecha_fin = $this->input->post("fecha_fin");
      $episodio = $this->input->post("episodio");

      echo $this->Tratamientos_model->agregarTratamiento($nregistro, $paciente, $fecha_inicio, $fecha_fin, $tomas, $episodio);
   }
}
