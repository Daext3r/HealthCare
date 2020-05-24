<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboratorio extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es el tipo de perfil que corresponde a este panel, redirigimos al login
      if ($this->session->userdata("tipo") != "laboratorio") {
         //redirigimos al login
         redirect(base_url() . "login");
         return;
      }
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

      $this->load->view("laboratorio/View_Inicio");
   }

   public function analiticas($accion)
   {
      switch ($accion) {
         case 'atender':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "laboratorio/Style_Analiticas_Atender"),
               "scripts" => array("modules/ScriptModule_Panel", "laboratorio/Script_Analiticas_Atender")
            ));

            //carga el modulo principal
            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("laboratorio/View_Analiticas_Atender");
            break;
         case 'atendidas':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "laboratorio/Style_Analiticas_Atendidas"),
               "scripts" => array("modules/ScriptModule_Panel", "laboratorio/Script_Analiticas_Atendidas")
            ));

            //carga el modulo principal
            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("laboratorio/View_Analiticas_Atendidas");
            break;

         case 'historial':

            break;
      }
   }
}
