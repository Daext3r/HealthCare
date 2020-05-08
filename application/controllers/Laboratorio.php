<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboratorio extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function inicio()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive"),
         "scripts" => array("modules/ScriptModule_Panel")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");
   }
}
