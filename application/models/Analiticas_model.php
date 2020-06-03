<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analiticas_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   /**
    * Crea una nueva analitica. Devuelve el ID del nuevo registro
    * @return int
    * @param string $paciente
    * @param string $facultativo
    * @param object $pruebas
    */
   public function nuevaAnalitica($paciente, $facultativo, $pruebas)
   {
      $this->db->insert("analiticas", array("CIU_paciente" => $paciente, "CIU_facultativo" => $facultativo, "pruebas" => $pruebas));
      return $this->db->insert_id();
   }

   /**
    * Comprueba la existencia de una analitica por su ID
    * @param int $id
    * @return object
    */
   public function buscarAnalitica($id)
   {
      return $this->db->query("SELECT COUNT(*) AS existe  FROM analiticas WHERE codigo_analitica = ?", array($id))->result_array();
   }

   /**
    * Atiende una analítica. Devuelve el numero de filas afectadas ya que el segundo WHERE implica que no este atendida previamente
    * @param int $id
    * @return int
    */

   public function atenderAnalitica($id)
   {
      $this->db->where("codigo_analitica", $id);
      $this->db->where("CIU_personal", NULL);
      $this->db->set("CIU_personal", $this->session->userdata("ciu"));
      $this->db->update("analiticas");
      return $this->db->affected_rows();
   }

   /**
    * Lee las pruebas de una analitica segun su codigo
    * @param int $codigo
    * @return object
    */
   public function leerPruebasAnalitica($codigo)
   {
      $this->db->select("pruebas, observaciones_personal");
      $this->db->where("codigo_analitica", $codigo);
      return $this->db->get("analiticas")->row_array();
   }

   /**
    * Actualiza los datos de una analitica
    * @param int $analitica
    * @param object $pruebas
    * @return int
    */
   public function actualizarAnalitica($analitica, $pruebas)
   {
      $this->db->where("codigo_analitica", $analitica);
      $this->db->set("pruebas", $pruebas);
      if ($this->db->update("analiticas")) {
         return 1;
      } else {
         return 0;
      }
   }


   /**
    * Cierra una analitica con una posible observacion
    * @param int $analitica
    * @param string observacion
    * @return int
    */
   public function cerrarAnalitica($analitica, $observacion)
   {
      $fecha = new DateTime('now');

      $this->db->where("codigo_analitica", $analitica);
      $this->db->set("fecha_resultado", $fecha->format("Y-m-d"));
      $this->db->set("observaciones_personal", $observacion);

      if ($this->db->update("analiticas")) {
         return 1;
      } else {
         return 0;
      }
   }
}
