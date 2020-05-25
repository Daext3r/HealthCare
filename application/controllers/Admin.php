<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es el tipo de perfil que corresponde a este panel, redirigimos al login
      if ($this->session->userdata("tipo") != "admin") {
         //redirigimos al login
         redirect(base_url() . "login");
         return;
      }
   }

   public function inicio()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "admin/Style_Inicio"),
         "scripts" => array("modules/ScriptModule_Panel", "admin/Script_Inicio")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      $this->load->view("admin/View_Inicio");
   }

   public function crear($item)
   {
      switch ($item) {
         case 'usuario':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Registro_Usuario"),
               "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Registro_Usuario", "lib/dni")
            ));

            //carga el modulo principal
            $this->load->view("modules/ViewModule_Panel");

            //carga el panel de registro
            $this->load->view("modules/ViewModule_Registro_Usuario");
            break;
         case 'centro':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "admin/crearCentro"),
               "scripts" => array("modules/ScriptModule_Panel", "admin/crearCentro")
            ));

            //carga el modulo principal
            $this->load->view("modules/ViewModule_Panel");

            //carga el panel de registro
            $this->load->view("admin/Crear_centro_v");
            break;
         case 'facultativo':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Nuevo_Facultativo"),
               "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Nuevo_Facultativo")
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

   public function administrar($item)
   {
      switch ($item) {
         case 'usuario':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Datos_Usuario"),
               "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Datos_Usuario", "lib/dni")
            ));

            //carga el modulo principal
            $this->load->view("modules/ViewModule_Panel");

            //carga el panel de registro
            $this->load->view("modules/ViewModule_Datos_Usuario");
            break;
         case 'centro':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "admin/AdministrarCentro"),
               "scripts" => array("modules/ScriptModule_Panel", "admin/AdministrarCentro")
            ));

            //carga el modulo principal
            $this->load->view("modules/ViewModule_Panel");

            //carga el panel de registro
            $this->load->view("admin/AdministrarCentro_v");
            break;
      }
   }
}
