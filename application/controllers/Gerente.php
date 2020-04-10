<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gerente extends CI_Controller
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
      $this->session->set_userdata("tipo", "gerente");
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
         "scripts" => array("utils/common", "gerente/gestionarAdministrativos")
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
