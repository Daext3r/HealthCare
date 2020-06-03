<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Centros extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $this->load->model("Centros_model");
   }

   /**
    * Crea un nuevo centro con los datos mandados por POST
    * @return int
    */
   public function crearCentro()
   {
      $datos = array();

      //guardamos los datos del formulario en el array 
      foreach ($_POST as $clave => $valor) {
         $datos[$clave] = $valor;
      }

      //devolvemos el resultado de la consulta. 1 o 0
      echo $this->Centros_model->crearCentro($datos);
   }

   /**
    * Actualiza los datos de un centro
    * @return int
    */
   public function actualizarCentro()
   {
      $datos = $_POST;
      $id = $datos['id'];
      unset($datos['id']);
      echo $this->Centros_model->actualizarCentro($id, $datos);
   }

   /**
    * Busca un centro por una parte del nombre. Devuelve todas las coincidencias
    * @return object
    */
   public function buscarCentroNombre()
   {
      //buscamos el centro por el modelo y escribimos en formato JSON
      echo json_encode($this->Centros_model->buscarCentroNombre($this->input->post("centro")));
   }

   /**
    * Lee los datos de un centro
    * @return object
    */
   public function leerDatosCentro()
   {
      //buscamos los datos del centro por el modelo y escribimos en formato JSON
      echo json_encode($this->Centros_model->leerDatosCentro($this->input->post("centro")));
   }

   /**
    * Agrega un nuevo administrativo a un centro
    * @return int
    */
   public function agregarAdministrativo()
   {
      $centro = $this->Centros_model->leerCentroPorGerente($this->session->userdata("ciu"));

      echo $this->Centros_model->agregarAdministrativo(array("CIU_administrativo" => $this->input->post("usuario"), "id_centro" => $centro['id']));
   }

   /**
    * Lee los administrativos de un centro
    * @return object
    */
   public function leerAdministrativosCentro()
   {
      $centro = $this->Centros_model->leerCentroPorGerente($this->session->userdata("ciu"));
      echo json_encode($this->Centros_model->leerAdministrativosCentro($centro['id']));
   }

   /**
    * Elimina un administrativo de un centro
    * @return int
    */
   public function eliminarAdministrativo()
   {
      echo $this->Centros_model->eliminarAdministrativo($this->input->post("ciu"));
   }

   /**
    * Lee las horas de apertura y de cierre segun el facultativo que se indique
    * @return object
    */
   public function leerHorasPorFacultativo()
   {
      echo json_encode($this->Centros_model->leerHorasPorFacultativo($this->input->post("ciu")));
   }
}
