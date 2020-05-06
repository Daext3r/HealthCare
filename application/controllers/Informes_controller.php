<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.

class Informes_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      if (!$this->input->is_ajax_request()) {
         redirect(base_url());
         return;
      }

      $this->load->model("Informes_model");
   }

   public function leerListaInformes()
   {
      //si propio es true, significa que es el propio paciente el que quiere ver los informes
      //de lo contrario será un facultativo, por lo que se tendrá que especificar el ciu en la peticion ajax
      $ciu = null;

      if ($this->input->post("propio")) {
         $ciu = $this->session->userdata("ciu");
      } else {
         $ciu = $this->input->post("ciu");
      }

      //devolvemos la lista en formato json
      echo json_encode($this->Informes_model->leerListaInformes($ciu));
   }

   public function guardarInforme()
   {
      $contenido = $this->input->post("contenido");
      $fac = $this->session->userdata("ciu");
      $paciente = $this->input->post("paciente");
      $episodio = $this->input->post("episodio");

      $fecha = new DateTime();
      

      echo $this->Informes_model->guardarInforme($contenido, $fac, $paciente, $episodio, $fecha->format("Y-m-d"), $fecha->format("H:i:s"));
   }

   public function leerInforme($id)
   {
      
   }
}
