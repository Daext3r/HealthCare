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
   public function gestionarAdministrativos()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/head", array(
         "hojas" => array("modules/panel", "modules/panel-responsive", "gerente/gestionarAdministrativos"),
         "scripts" => array("utils/common", "gerente/gestionarAdministrativos", "lib/pagination")
      ));

      //carga el modulo principal
      $this->load->view("modules/panel");

      //carga el panel de registro
      $this->load->view("gerente/gestionarAdministrativos_v");
   }
   public function traslados()
   {
   }
}
