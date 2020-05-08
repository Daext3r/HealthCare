<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboratorio_controller extends CI_Controller
{
   public function __construct() {
      parent::__construct();
      $this->load->model("Personal_model");
   }

   public function registrarPersonal() {
      echo $this->Personal_model->registrarPersonal($this->input->post("usuario"), $this->input->post("centro"));
   }
}