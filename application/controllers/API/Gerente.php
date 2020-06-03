<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gerente extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model("Gerente_model");
   }

   /**
    * Solicitar el traslado de un facultativo de un centro a otro
    * @return int
    */
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
      }

      //si no es el mismo centro, comprobamos si ya hay un traslado en curso para ese usuario
      if ($this->Gerente_model->comprobarUsuarioTraslado($facultativo) >= 1) {
         echo 2;
         return;
      }

      //de lo contrario generamos el traslado
      echo $this->Gerente_model->nuevoTraslado($facultativo, $centro_destino['id']);
   }

   /**
    * Lee los traslados actuales de un centro
    * @return object
    */
   public function leerTraslados()
   {
      $this->load->model("Centros_model");
      //leemos los traslados que hay para este centro.
      echo json_encode($this->Gerente_model->leerTraslados($this->Centros_model->leerCentroPorGerente($this->session->userdata("ciu"))['id']));
   }

   /**
    * Resuelve el traslado, de forma satisfactoria o fallida
    * @return int
    */
   public function resolverTraslado()
   {
      $res = $this->input->post("res");
      $traslado = $this->input->post("id");

      if ($res == "true") {
         $this->load->model("Facultativos_model");
         //si es que si actualizamos la tabla facultativos y le cambiamos el centro. despues borramos el traslado
         $nuevoCentro = $this->Gerente_model->leerNuevoCentro($traslado);
         $facultativo = $this->Gerente_model->leerNuevoFacultativo($traslado);

         if ($this->Facultativos_model->actualizarCentro($facultativo['CIU_facultativo'], $nuevoCentro['centro_destino']) == 1) {
            $this->Gerente_model->borrarTraslado($traslado);
         }
      } else {
         //si es que no solo borramos el traslado
         $this->Gerente_model->borrarTraslado($traslado);
      }

      echo 1;
   }
}
