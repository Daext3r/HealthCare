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
      $this->load->view("modules/head", array(
         "hojas" => array("modules/panel", "modules/panel-responsive"),
         "scripts" => array("utils/common")
      ));

      //carga el modulo principal
      $this->load->view("modules/panel");
   }

   public function crear($item)
   {
      switch ($item) {
         case 'usuario':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/head", array(
               "hojas" => array("modules/panel", "modules/panel-responsive", "modules/registro-usuario"),
               "scripts" => array("utils/common", "modules/registro-usuario", "lib/dni")
            ));

            //carga el modulo principal
            $this->load->view("modules/panel");

            //carga el panel de registro
            $this->load->view("modules/registro-usuario");
            break;
         case 'centro':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/head", array("hojas" => array("modules/panel", "modules/panel-responsive", "admin/crearCentro"), "scripts" => array("utils/common", "admin/crearCentro")));

            //carga el modulo principal
            $this->load->view("modules/panel");

            //carga el panel de registro
            $this->load->view("admin/Crear_centro_v");
            break;
      }
   }

   public function administrar($item)
   {
      switch ($item) {
         case 'usuario':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/head", array(
               "hojas" => array("modules/panel", "modules/panel-responsive", "modules/datos-usuario"),
               "scripts" => array("utils/common", "modules/datos-usuario", "lib/dni")
            ));

            //carga el modulo principal
            $this->load->view("modules/panel");

            //carga el panel de registro
            $this->load->view("modules/datos-usuario");
            break;
         case 'centro':
            //carga el head con las hojas de estilos y scripts necesarios
            $this->load->view("modules/head", array(
               "hojas" => array("modules/panel", "modules/panel-responsive", "admin/AdministrarCentro"),
               "scripts" => array("utils/common", "admin/AdministrarCentro")
            ));

            //carga el modulo principal
            $this->load->view("modules/panel");

            //carga el panel de registro
            $this->load->view("admin/AdministrarCentro_v");
            break;
      }
   }
}
