<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Centros_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   /**
    * Crea un centro con los datos indicados
    * @param object $datos
    * @return int
    */
   public function crearCentro($datos)
   {
      if ($this->db->insert("centros", $datos)) {
         return 1;
      } else {
         return 0;
      }
   }

   /**
    * Busca un centro por una parte del nombre
    * @param string $centro
    * @return object
    */
   public function buscarCentroNombre($centro)
   {
      $this->db->select("id, nombre");
      $this->db->like("nombre", $centro);
      return $this->db->get("centros")->result_array();
   }

   /**
    * Lee los datos de un centro
    * @param int $centro
    * @return object
    */
   public function leerDatosCentro($centro)
   {
      $this->db->select("id, nombre, direccion, telefonos, CIU_gerente, hora_apertura, hora_cierre");
      $this->db->where("id", $centro);
      return $this->db->get("centros")->row_array();
   }

   /**
    * Actualiza los datos de un centro
    * @param int $id
    * @param object $datos
    * @return int
    */
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

   /**
    * Lee el centro indicando el gerente
    * @param string $ciu
    * @return int
    */
   public function leerCentroPorGerente($ciu)
   {
      $this->db->where("CIU_gerente", $ciu);
      $this->db->select("id");
      return $this->db->get("centros")->row_array();
   }

   /**
    * Agrega un administrativo a un centro
    * @param object $datos
    * @return int
    */
   public function agregarAdministrativo($datos)
   {
      if ($this->db->insert("administrativos", $datos)) {
         return 1;
      } else {
         return 0;
      }
   }

   /**
    * Lee los administrativos de un centro
    * @param int $centro
    * @return object
    */
   public function leerAdministrativosCentro($centro)
   {
      $this->db->select("nombre_completo, CIU_administrativo");
      $this->db->where("id_centro", $centro);
      return $this->db->get("vista_administrativos_centros")->result_array();
   }

   /**
    * Elimina un administrativo de un centro
    * @param string $ciu
    * @return int
    */
   public function eliminarAdministrativo($ciu)
   {
      $this->db->where("CIU_administrativo", $ciu);
      if ($this->db->delete("administrativos")) {
         return 1;
      } else {
         return 0;
      }
   }

   /**
    * Lee las horas de apertura y cierre indicando el facultativo
    * @param string $ciu
    * @return object
    */
   public function leerHorasPorFacultativo($ciu)
   {
      $this->db->select("hora_apertura, hora_cierre");
      $this->db->from("centros");
      $this->db->where("facultativos.CIU_facultativo", $ciu);
      $this->db->join("facultativos", "facultativos.centro = centros.id");
      return $this->db->get()->result_array();
   }

   /**
    * Lee el centro en el cual trabaja un facultativo
    * @param string $facultativo
    * @return int
    */
   public function leerCentroPorFacultativo($facultativo)
   {
      $this->db->select("centro");
      $this->db->where("CIU_facultativo", $facultativo);
      return $this->db->get("facultativos")->row_array();
   }
}
