<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gerente_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   /**
    * Crea una nueva solicitud de traslado
    * @param string $facultativo
    * @param int $centro
    * @return int
    */
   public function nuevoTraslado($facultativo, $centro)
   {
      if ($this->db->insert("traslados", array("centro_destino" => $centro, "CIU_facultativo" => $facultativo))) {
         return 1;
      } else {
         return 0;
      }
   }

   /**
    * Leemos los traslados cuyo facultativo trabaje en el centro que se especifique
    * @param int $centro
    * @return object
    */
   public function leerTraslados($centro)
   {

      return $this->db->query("SELECT * FROM vista_traslados WHERE CIU_facultativo IN (SELECT CIU_facultativo FROM facultativos WHERE centro = ?)", array($centro))->result_array();
   }

   /**
    * Lee el centro del destino al que va el facultativo de un traslado X
    * @param int $id
    * @return object
    */
   public function leerNuevoCentro($id)
   {
      $this->db->where("id", $id);
      $this->db->select("centro_destino");
      return $this->db->get("vista_traslados")->row_array();
   }

   /**
    * Lee el facultativo pertenenciente a un traslado
    * @param int $id
    * @return object
    */
   public function leerNuevoFacultativo($id)
   {
      $this->db->where("id", $id);
      $this->db->select("CIU_facultativo");
      return $this->db->get("vista_traslados")->row_array();
   }

   /**
    * Borra un traslado
    * @param int $id
    * @return object
    */
   public function borrarTraslado($id)
   {
      $this->db->where("id", $id);
      if ($this->db->delete("traslados")) {
         return 1;
      } else {
         return 0;
      }
   }

   /**
    * Busca si un facultativo ya esta siendo trasladado
    * @param string $facultativo
    * @return object
    */
   public function comprobarUsuarioTraslado($facultativo)
   {
      $this->db->where("CIU_facultativo", $facultativo);
      return $this->db->count_all_results('traslados');
   }
}
