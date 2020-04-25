<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrativo extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function inicio()
   {
      $this->load->view("modules/ViewModule_Head", array("hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive"), "scripts" => array("utils/common")));
      $this->load->view("modules/ViewModule_Panel");
   }

   public function crearUsuario()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Registro_Usuario"),
         "scripts" => array("utils/common", "modules/ScriptModule_Registro_Usuario", "lib/dni")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      //carga el panel de registro
      $this->load->view("modules/ViewModule_Registro_Usuario");
   }

   public function nuevo($tipo)
   {
      switch ($tipo) {
         case 'facultativo':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Nuevo_Facultativo"),
               "scripts" => array("utils/common", "modules/ScriptModule_Panel")
            ));

            $this->load->view("modules/ViewModule_Panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/ViewModule_Nuevo_Facultativo");

            break;
         case 'paciente':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Nuevo_Paciente"),
               "scripts" => array("utils/common", "modules/ScriptModule_Nuevo_Paciente")
            ));

            $this->load->view("modules/ViewModule_Panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/ViewModule_Nuevo_Paciente");
            break;
         case 'personal_lab':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Nuevo_PersonalLab"),
               "scripts" => array("utils/common", "modules/ScriptModule_Nuevo_PersonalLab")
            ));

            $this->load->view("modules/ViewModule_Panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/ViewModule_Nuevo_PersonalLab");
            break;
      }
   }
}
