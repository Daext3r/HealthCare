<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gerente_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model("Gerente_model");
   }

   public function solicitarTraslado()
   {
      //cargamos el modelo de centros
      $this->load->model("Centros_model");

      //leemos el centro actual del facultativo, y miramos que no sea el mismo al que se le quiere mandar
      //en ese caso devolvemos 0
      $facultativo = $this->input->post("facultativo");
      $centro_destino = $this->Centros_model->leerCentroPorGerente($this->session->userdata("ciu"));
      $centro_actual = $this->Centros_model->leerCentroPorFacultativo($facultativo);

      if ($centro_destino['id'] == $centro_actual['centro']) {
         echo 0;
         return;
      } else {
         //si no es el mismo centro, lo insertamos
         echo $this->Gerente_model->nuevoTraslado($facultativo, $centro_destino['id']);
      }
   }
}
