<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analiticas extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $this->load->model("Analiticas_model");
   }

   /**
    * Crea una nueva analitica para el paciente indicado. Devuelve la respuesta del modelo, 0 o 1    
    * @return int
    */
   public function nuevaAnalitica()
   {
      echo $this->Analiticas_model->nuevaAnalitica($this->input->post("paciente"), $this->session->userdata("ciu"), $this->input->post("pruebas"));
   }

   /**
    * Comprueba si una analitica existe
    * @return object
    */
   public function buscarAnalitica()
   {
      echo json_encode($this->Analiticas_model->buscarAnalitica($this->input->post("id")));
   }

   /**
    * Ajusta el valor de CIU_personal de la analitica especificada al CIU del usuario desde el cual se hace la petición
    * @return int
    */
   public function atenderAnalitica()
   {
      echo $this->Analiticas_model->atenderAnalitica($this->input->post("id"));
   }

   /**
    * Lee las pruebas y resultados de una analitica
    * @return object
    */
   public function leerPruebasAnalitica()
   {
      $codigo = $this->input->post("codigo");
      echo json_encode($this->Analiticas_model->leerPruebasAnalitica($codigo));
   }

   /**
    * Actualiza los datos de una analitica
    * @return int
    */
   public function actualizarAnalitica()
   {
      $pruebas = $this->input->post("pruebas");
      $analitica = $this->input->post("analitica");

      echo $this->Analiticas_model->actualizarAnalitica($analitica, $pruebas);
   }

   /**
    * Ajusta la fecha de resultado de una analítica
    * @return int
    */
   public function cerrarAnalitica()
   {
      echo $this->Analiticas_model->cerrarAnalitica($this->input->post("codigo"), $this->input->post("observacion"));
   }
}
