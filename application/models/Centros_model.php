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

   public function actualizarCentro($id, $datos)
   {
      $this->db->where("id", $id);
      $this->db->set($datos);

      if ($this->db->update("centros")) {
         return 1;
      } else {
         return 0;
      }
   }

   public function leerCentroPorGerente($ciu)
   {
      $this->db->where("CIU_gerente", $ciu);
      $this->db->select("id");
      return $this->db->get("centros")->row_array();
   }

   public function agregarAdministrativo($datos)
   {
      if ($this->db->insert("administrativos", $datos)) {
         return 1;
      } else {
         return 0;
      }
   }

   public function leerAdministrativosCentro($centro)
   {
      $this->db->select("nombre_completo, CIU_administrativo");
      $this->db->where("id_centro", $centro);
      return $this->db->get("vista_administrativos_centros")->result_array();
   }

   public function eliminarAdministrativo($ciu)
   {
      $this->db->where("CIU_administrativo", $ciu);
      if ($this->db->delete("administrativos")) {
         return 1;
      } else {
         return 0;
      }
   }

   public function leerHorasPorFacultativo($ciu)
   {
      $this->db->select("hora_apertura, hora_cierre");
      $this->db->from("centros");
      $this->db->where("facultativos.CIU_facultativo", $ciu);
      $this->db->join("facultativos", "facultativos.centro = centros.id");
      return $this->db->get()->result_array();
   }

   public function leerCentroPorFacultativo($facultativo)
   {
      $this->db->select("centro");
      $this->db->where("CIU_facultativo", $facultativo);
      return $this->db->get("facultativos")->row_array();
   }
}
