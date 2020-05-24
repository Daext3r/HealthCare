<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrativo extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      //si no es el tipo de perfil que corresponde a este panel, redirigimos al login
      if ($this->session->userdata("tipo") != "administrativo") {
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

   public function usuario($accion)
   {
      switch ($accion) {
         case 'nuevo':
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
         case 'modificar':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Datos_Usuario"),
               "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Datos_Usuario", "lib/dni")
            ));

            $this->load->view("modules/ViewModule_Panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/ViewModule_Datos_Usuario");
            break;
      }
   }

   public function nuevo($tipo)
   {
      switch ($tipo) {
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
         case 'laboratorio':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Nuevo_Laboratorio"),
               "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Nuevo_Laboratorio")
            ));

            $this->load->view("modules/ViewModule_Panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/ViewModule_Nuevo_Laboratorio");
            break;
      }
   }

   public function citas($accion)
   {
      switch ($accion) {
         case 'nueva':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Nueva_Cita"),
               "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Nueva_Cita")
            ));

            $this->load->view("modules/ViewModule_Panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/ViewModule_Nueva_Cita");
            break;
         case 'ver':
            //TODO en V2
            break;
      }
   }
}
