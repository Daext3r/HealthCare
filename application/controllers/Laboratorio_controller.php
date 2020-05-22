<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboratorio_controller extends CI_Controller
{
   public function __construct() {
      parent::__construct();
      $this->load->model("Laboratorio_model");
   }

   public function registrarPersonal() {
      echo $this->Laboratorio_model->registrarPersonal($this->input->post("usuario"), $this->input->post("centro"));
   }

   public function buscarAnalitica() {
      echo json_encode($this->Laboratorio_model->buscarAnalitica($this->input->post("id")));
   }

   public function atenderAnalitica() {
      echo $this->Laboratorio_model->atenderAnalitica($this->input->post("id"));
   }
}