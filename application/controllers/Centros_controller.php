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
}
