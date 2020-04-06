<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Centros_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function crearCentro($datos)
   {
      if ($this->db->insert("centros", $datos)) {
         return 1;
      } else {
         return 0;
      }
   }

   public function buscarCentroNombre($centro)
   {
      $this->db->select("id, nombre");
      $this->db->like("nombre", $centro);
      return $this->db->get("centros")->result_array();
   }

   public function leerDatosCentro($centro)
   {
      $this->db->select("id, nombre, direccion, telefonos, CIU_gerente, hora_apertura, hora_cierre");
      $this->db->where("id", $centro);
      return $this->db->get("centros")->row_array();
   }

   public function actualizarCentro($id, $datos) {
      $this->db->where("id", $id);
      $this->db->set($datos);
      
      if($this->db->update("centros")) {
         return 1;
      } else {
         return 0;
      }
   }
}
