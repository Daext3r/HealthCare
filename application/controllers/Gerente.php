<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gerente extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es el tipo de perfil que corresponde a este panel, redirigimos al login
      if ($this->session->userdata("tipo") != "gerente") {
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
   public function crearUsuario()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Registro_Usuario"),
         "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Registro_Usuario", "lib/dni")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      //carga el panel de registro
      $this->load->view("modules/ViewModule_Registro_Usuario");
   }
   public function gestionarAdministrativos()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "gerente/gestionarAdministrativos"),
         "scripts" => array("modules/ScriptModule_Panel", "gerente/gestionarAdministrativos", "lib/pagination")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      //carga el panel de registro
      $this->load->view("gerente/gestionarAdministrativos_v");
   }

   public function nuevo($tipo)
   {
      switch ($tipo) {
         case 'facultativo':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Nuevo_Facultativo"),
               "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Nuevo_facultativo")
            ));

            $this->load->view("modules/ViewModule_Panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/ViewModule_Nuevo_Facultativo");

            break;
         case 'paciente':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Nuevo_Paciente"),
               "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Nuevo_Paciente")
            ));

            $this->load->view("modules/ViewModule_Panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/ViewModule_Nuevo_Paciente");
            break;
      }
   }

   public function traslados()
   {
   }
}
