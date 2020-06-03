<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.
class Facultativos extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      $this->load->model("Facultativos_model");
   }

   /**
    * Devuelve los facultativos que cumplan esa especialidad
    * @return object
    */
   public function buscarEspecialidad()
   {
      echo json_encode($this->Facultativos_model->buscarEspecialidad($this->input->post("especialidad")));
   }

   /**
    * Da de alta un nuevo facultativo
    * @return int
    */
   public function alta()
   {
      $usuario = $this->input->post("usuario");
      $colegiado = $this->input->post("colegiado");
      $sala = $this->input->post("sala");
      $especialidad = $this->input->post("especialidad");
      $centro = $this->input->post("centro");

      echo $this->Facultativos_model->alta($usuario, $colegiado, $especialidad, $sala, $centro);
   }

   /**
    * Busca un facultativo segun parte del nombre
    * @return object
    * @deprecated
    */
   public function buscarFacultativoNombre()
   {
      echo json_encode($this->Facultativos_model->buscarFacultativoNombre($this->input->post("nombre")));
   }

   /**
    * Busca un facultativo segun parte del nombre o parte del CIU
    * @return object
    */
   public function buscarFacultativoCiuNombre()
   {
      echo json_encode($this->Facultativos_model->buscarFacultativoCiuNombre($this->input->post("dato")));
   }

   /**
    * Lee las enfermedades de un paciente
    * @return int
    */
   public function leerEnfermedadesPaciente()
   {
      echo $this->Facultativos_model->leerEnfermedadesPaciente($this->input->post("paciente"));
   }

   /**
    * Actualiza las enfermedades de un paciente
    * @return int
    */
   public function actualizarEnfermedadesPaciente()
   {
      echo $this->Facultativos_model->actualizarEnfermedadesPaciente($this->input->post("paciente"), $this->input->post("enfermedades"));
   }

   /**
    * Lee las analiticas de un paciente
    * @return object
    */
   public function leerAnaliticasPaciente()
   {
      echo json_encode($this->Facultativos_model->leerAnaliticasPaciente($this->input->post("paciente")));
   }
}
