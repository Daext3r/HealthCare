<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //cargamos los datos del usuario llamando al modelo
      $this->load->model("Usuarios_model");

      $datos = $this->Usuarios_model->leerDatosPrivados($this->session->userdata("ciu"));

      $this->session->set_userdata($datos);

      $datos = $this->Usuarios_model->leerDatosPublicos($this->session->userdata("ciu"));

      $this->session->set_userdata($datos);

      //guardamos el tipo de perfil, admin
      $this->session->set_userdata("tipo", "admin");
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
      switch($item) {
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
         case'centro':
            
         break;  
      }
   }
}
