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
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive"),
         "scripts" => array("modules/ScriptModule_Panel")
      ));
      $this->load->view("modules/ViewModule_Panel");
   }

   public function citas()
   {
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Citas"),
         "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_Citas")
      ));

      $this->load->view("modules/ViewModule_Panel");

      $this->load->view("facultativo/View_Citas");
   }
}
