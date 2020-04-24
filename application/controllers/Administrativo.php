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
      $this->load->view("modules/head", array("hojas" => array("modules/panel", "modules/panel-responsive"), "scripts" => array("utils/common")));
      $this->load->view("modules/panel");
   }

   public function crearUsuario()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/head", array(
         "hojas" => array("modules/panel", "modules/panel-responsive", "modules/registro-usuario"),
         "scripts" => array("utils/common", "modules/registro-usuario", "lib/dni")
      ));

      //carga el modulo principal
      $this->load->view("modules/panel");

      //carga el panel de registro
      $this->load->view("modules/registro-usuario");
   }

   public function nuevo($tipo)
   {
      switch ($tipo) {
         case 'facultativo':
            $this->load->view("modules/head", array(
               "hojas" => array("modules/panel", "modules/panel-responsive", "modules/nuevo-facultativo"),
               "scripts" => array("utils/common", "modules/nuevo-facultativo")
            ));

            $this->load->view("modules/panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/nuevo-facultativo");

            break;
         case 'paciente':
            $this->load->view("modules/head", array(
               "hojas" => array("modules/panel", "modules/panel-responsive", "modules/nuevo-paciente"),
               "scripts" => array("utils/common", "modules/nuevo-paciente")
            ));

            $this->load->view("modules/panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/nuevo-paciente");
            break;
         case 'personal_lab':
            $this->load->view("modules/head", array(
               "hojas" => array("modules/panel", "modules/panel-responsive", "modules/nuevo-personal_lab"),
               "scripts" => array("utils/common", "modules/nuevo-personal_lab")
            ));

            $this->load->view("modules/panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/nuevo-personal_lab");
            break;
      }
   }
}
