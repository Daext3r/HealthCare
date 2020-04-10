<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Centros_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model("Centros_model");
   }

   public function crearCentro()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $datos = array();

      //guardamos los datos del formulario en el array 
      foreach ($_POST as $clave => $valor) {
         $datos[$clave] = $valor;
      }

      //devolvemos el resultado de la consulta. 1 o 0
      echo $this->Centros_model->crearCentro($datos);
   }

   public function actualizarCentro()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $datos = $_POST;
      $id = $datos['id'];
      unset($datos['id']);
      echo $this->Centros_model->actualizarCentro($id, $datos);
   }

   public function buscarCentroNombre()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      //buscamos el centro por el modelo y escribimos en formato JSON
      echo json_encode($this->Centros_model->buscarCentroNombre($this->input->post("centro")));
   }

   public function leerDatosCentro()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      //buscamos los datos del centro por el modelo y escribimos en formato JSON
      echo json_encode($this->Centros_model->leerDatosCentro($this->input->post("centro")));
   }

   public function agregarAdministrativo()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $centro = $this->Centros_model->leerCentroPorGerente($this->session->userdata("ciu"));

      echo $this->Centros_model->agregarAdministrativo(array("CIU_administrativo" => $this->input->post("usuario"), "id_centro" => $centro['id']));
   }

   public function leerAdministrativosCentro()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $centro = $this->Centros_model->leerCentroPorGerente($this->session->userdata("ciu"));
      echo json_encode($this->Centros_model->leerAdministrativosCentro($centro['id']));
   }

   public function eliminarAdministrativo()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      echo $this->Centros_model->eliminarAdministrativo($this->input->post("ciu"));
   }
}
