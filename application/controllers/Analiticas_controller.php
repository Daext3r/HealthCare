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

   public function buscarAnalitica()
   {
      echo json_encode($this->Analiticas_model->buscarAnalitica($this->input->post("id")));
   }

   public function atenderAnalitica()
   {
      echo $this->Analiticas_model->atenderAnalitica($this->input->post("id"));
   }

   public function leerPruebasAnalitica()
   {
      $codigo = $this->input->post("codigo");
      echo json_encode($this->Analiticas_model->leerPruebasAnalitica($codigo));
   }

   public function actualizarAnalitica()
   {
      $pruebas = $this->input->post("pruebas");
      $analitica = $this->input->post("analitica");

      echo $this->Analiticas_model->actualizarAnalitica($analitica, $pruebas);
   }

   public function cerrarAnalitica()
   {
      echo $this->Analiticas_model->cerrarAnalitica($this->input->post("codigo"), $this->input->post("observacion"));
   }
}
