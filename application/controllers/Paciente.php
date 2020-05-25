<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paciente extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es el tipo de perfil que corresponde a este panel, redirigimos al login
      if ($this->session->userdata("tipo") != "paciente") {
         //redirigimos al login
         redirect(base_url() . "login");
         return;
      }
   }

   public function logout()
   {
      //el propio login borra la sesion
      redirect(base_url() . "login");
   }

   public function inicio()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "paciente/inicio", "modules/StyleModule_Panel_Responsive"),
         "scripts" => array("modules/ScriptModule_Panel", "paciente/inicio")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      //carga la vista de inicio
      $this->load->view("paciente/Inicio_v");
   }

   public function citas()
   {
      $this->load->model("Citas_model");
      $this->load->model("Pacientes_model");
      $citas = $this->Citas_model->leerCitas($this->session->userdata("ciu"));

      $facultativos = $this->Pacientes_model->leerFacultativos($this->session->userdata("ciu"));

      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "paciente/citas", "modules/StyleModule_Panel_Responsive"),
         "scripts" => array("modules/ScriptModule_Panel", "paciente/citas")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      //carga la vista de inicio
      $this->load->view("paciente/Citas_v", array(
         "citas" => $citas, "facultativos" => $facultativos
      ));
   }

   public function tratamientos()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "paciente/tratamientos", "modules/StyleModule_Panel_Responsive"),
         "scripts" => array("modules/ScriptModule_Panel", "paciente/tratamientos")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      //carga la vista de inicio
      $this->load->view("paciente/Tratamientos_v");
   }

   public function informes()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array(
            "modules/StyleModule_Panel", "paciente/informes", "modules/StyleModule_Panel_Responsive"
         ),
         "scripts" => array("modules/ScriptModule_Panel", "clases/Informe", "paciente/Script_Informes")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      //carga la vista de inicio
      $this->load->view("paciente/Informes_v");
   }
}
