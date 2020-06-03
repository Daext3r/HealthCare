<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tratamientos_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   /**
    * Lee los tratamientos de un paciente (desde paciente)
    * @param string $ciu
    * @return object
    */
   public function leerTratamientos($ciu)
   {
      $this->db->where("CIU_paciente", $ciu);
      $this->db->where("fecha_fin >=", date("Y-m-d"));
      $tratamientos = $this->db->get("tratamientos")->result_array();

      return $tratamientos;
   }

   /**
    * Crea un nuevo tratamiento
    * @param int $nregistro
    * @param string $paciente
    * @param date $fecha_fin
    * @param date $fecha_inicio
    * @param object $tomas
    * @param int $episodio
    * @return int 
    */
   public function agregarTratamiento($nregistro, $paciente, $fecha_inicio, $fecha_fin, $tomas, $episodio)
   {
      $datos =  array("nregistro" => $nregistro, "CIU_paciente" => $paciente, "fecha_inicio" => $fecha_inicio, "fecha_fin" => $fecha_fin, "tomas" => $tomas);
      //si el episodio no está vacio, 
      $datos["episodio"] = $episodio != "NULL" ? $episodio : null;

      if ($this->db->insert("tratamientos", $datos)) {
         return 1;
      } else {
         return 0;
      }
   }


   /**
    * Lee los tratamientos de un paciente (desde facultativo)
    * @param string $paciente
    * @return object
    */
   public function leerTratamientosFacultativo($paciente)
   {
      $this->db->where("CIU_paciente", $paciente);
      return  $this->db->get("tratamientos")->result_array();
   }

   /**
    * Borra un tratamiento
    * @param int $id
    * @return int
    */
   public function borrarTratamiento($id)
   {
      $this->db->where("id", $id);
      if ($this->db->delete("tratamientos")) {
         return 1;
      } else {
         return 0;
      }
   }
}
