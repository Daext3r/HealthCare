<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gerente_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function nuevoTraslado($facultativo, $centro)
   {
      if ($this->db->insert("traslados", array("centro_destino" => $centro, "CIU_facultativo" => $facultativo))) {
         return 1;
      } else {
         return 0;
      }
   }

   public function leerTraslados($centro)
   {
      //leemos los traslados cuyo facultativo trabaje en el centro que se especifique
      return $this->db->query("SELECT * FROM vista_traslados WHERE CIU_facultativo IN (SELECT CIU_facultativo FROM facultativos WHERE centro = ?)", array($centro))->result_array();
   }

   public function leerNuevoCentro($id)
   {
      $this->db->where("id", $id);
      $this->db->select("centro_destino");
      return $this->db->get("vista_traslados")->row_array();
   }

   public function leerNuevoFacultativo($id)
   {
      $this->db->where("id", $id);
      $this->db->select("CIU_facultativo");
      return $this->db->get("vista_traslados")->row_array();
   }

   public function borrarTraslado($id)
   {
      $this->db->where("id", $id);
      if ($this->db->delete("traslados")) {
         return 1;
      } else {
         return 0;
      }
   }

   public function comprobarUsuarioTraslado($facultativo)
   {
      $this->db->where("CIU_facultativo", $facultativo);
      return $this->db->count_all_results('traslados');
   }
}
