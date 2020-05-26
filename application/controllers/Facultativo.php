<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facultativo extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es el tipo de perfil que corresponde a este panel, redirigimos al login
      if ($this->session->userdata("tipo") != "facultativo") {
         //redirigimos al login
         redirect(base_url() . "login");
         return;
      }
   }

   public function inicio()
   {
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Inicio"),
         "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_Inicio")
      ));
      $this->load->view("modules/ViewModule_Panel");
      $this->load->view("facultativo/View_Inicio");
   }

   public function citas($accion)
   {
      switch ($accion) {
         case 'ver':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Citas"),
               "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_Citas")
            ));

            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("facultativo/View_Citas");
            break;
         case 'derivar':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "modules/StyleModule_Nueva_Cita"),
               "scripts" => array("modules/ScriptModule_Panel", "modules/ScriptModule_Nueva_Cita")
            ));

            $this->load->view("modules/ViewModule_Panel");

            //el formulario de altas es un modulo que puede ser usado por varios tipos de cuenta
            $this->load->view("modules/ViewModule_Nueva_Cita");
            break;
      }
   }

   public function informes($accion)
   {
      switch ($accion) {
         case 'nuevo':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_NuevoInforme", "facultativo/Style_ListaPacientes"),
               "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_NuevoInforme", "facultativo/Script_ListaPacientes")
            ));

            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("facultativo/View_NuevoInforme");
            break;

         case 'historial':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_HistorialInformes", "facultativo/Style_ListaPacientes"),
               "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_HistorialInformes", "facultativo/Script_ListaPacientes", "clases/Informe")
            ));

            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("facultativo/View_HistorialInformes");
            break;
            break;
      }
   }

   public function episodios()
   {
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Episodios", "facultativo/Style_ListaPacientes"),
         "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_Episodios", "facultativo/Script_ListaPacientes")
      ));

      $this->load->view("modules/ViewModule_Panel");

      $this->load->view("facultativo/View_Episodios");
   }

   public function analiticas($accion)
   {
      switch ($accion) {
         case 'nueva':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Nueva_Analitica", "facultativo/Style_ListaPacientes"),
               "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_Nueva_Analitica", "facultativo/Script_ListaPacientes")
            ));

            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("facultativo/View_Nueva_Analitica");
            break;
         case 'historial':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Historial_Analiticas", "facultativo/Style_ListaPacientes"),
               "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_ListaPacientes", "facultativo/Script_Historial_Analiticas")
            ));

            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("facultativo/View_Historial_Analiticas");
            break;
      }
   }

   public function tratamientos($accion)
   {
      switch ($accion) {
         case 'nuevo':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Nuevo_Tratamiento", "facultativo/Style_ListaPacientes"),
               "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_Nuevo_Tratamiento", "facultativo/Script_ListaPacientes")
            ));

            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("facultativo/View_Nuevo_Tratamiento");
            break;
         case 'ver':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Ver_Tratamientos", "facultativo/Style_ListaPacientes"),
               "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_ListaPacientes", "facultativo/Script_Ver_Tratamientos")
            ));

            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("facultativo/View_Ver_Tratamientos");
            break;
      }
   }

   public function enfermedades()
   {
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Enfermedades", "facultativo/Style_ListaPacientes"),
         "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_ListaPacientes", "facultativo/Script_Enfermedades")
      ));

      $this->load->view("modules/ViewModule_Panel");

      $this->load->view("facultativo/View_Enfermedades");
   }
}
