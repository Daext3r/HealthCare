<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facultativo extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es el tipo de perfil que corresponde a este panel, redirigimos al login
      if ($this->session->userdata("tipo") != "facultativo") {
         //redirigimos al login
         redirect(base_url() . "login");
         return;
      }
   }

   public function inicio()
   {
      $this->load->view("modules/head", array("hojas" => array("modules/panel", "modules/panel-responsive"), "scripts" => array()));
      $this->load->view("modules/panel");
   }
}
