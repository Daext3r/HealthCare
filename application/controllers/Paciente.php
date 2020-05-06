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
         "scripts" => array("modules/ScriptModule_Panel", "clases/Informe","paciente/Script_Informes")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      //carga la vista de inicio
      $this->load->view("paciente/Informes_v");
   }

   public function misdatos()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array(
            "modules/StyleModule_Panel", "paciente/misdatos", "modules/StyleModule_Panel_Responsive"
         ),
         "scripts" => array("modules/ScriptModule_Panel", "paciente/misdatos")
      ));

      //carga el modulo principal
      $this->load->view("modules/ViewModule_Panel");

      //carga la vista de inicio
      $this->load->view("paciente/MisDatos_v");
   }

   public function actualizarDatos()
   {
      //si no hay datos POST es que ha accedido directamente por la URL, lo redirigimos a inicio
      if (count($_POST) == 0) {
         redirect(base_url() . "paciente/inicio");
         return;
      }

      //añadimos la clave al array solo si el usuario ha introducido una nueva y ha cambiado el campo
      if ($this->input->post("clave") != "null") {
         if ($this->input->post("clave") != "") {
            $datos['clave'] = hash("sha512", $this->input->post("clave"));
         } else {
            //sesion temporal que servirá para mostrar un mensaje de error
            $this->session->set_flashdata("info", "error_clave");
            redirect(base_url() . "paciente/misdatos");
         }
      }

      $datos['correo'] = $this->input->post("correo");
      $datos['telefono'] = $this->input->post("telefono");
      $datos['fijo'] = $this->input->post("fijo");
      $datos['direccion'] = $this->input->post("direccion");

      //leemos de la session para usarlo en la clausula where
      $ciu = $this->session->userdata("ciu");
      $this->load->model("Pacientes_model");

      if ($this->Pacientes_model->actualizarDatos($datos, $ciu)) {
         //sesion temporal que servirá para mostrar un mensaje de informacion
         $this->session->set_flashdata("info", "ok");
         redirect(base_url() . "paciente/misdatos");
      } else {
         //sesion temporal que servirá para mostrar un mensaje de error
         $this->session->set_flashdata("info", "error_unk");
         redirect(base_url() . "paciente/misdatos");
      }
   }
}
