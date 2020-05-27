<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analiticas_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function nuevaAnalitica($paciente, $facultativo, $pruebas)
   {
      $this->db->insert("analiticas", array("CIU_paciente" => $paciente, "CIU_facultativo" => $facultativo, "pruebas" => $pruebas));
      return $this->db->insert_id();
   }

   public function buscarAnalitica($id)
   {
      return $this->db->query("SELECT COUNT(*) AS existe  FROM analiticas WHERE codigo_analitica = ?", array($id))->result_array();
   }

   public function atenderAnalitica($id)
   {
      $this->db->where("codigo_analitica", $id);
      $this->db->where("CIU_personal", NULL);
      $this->db->set("CIU_personal", $this->session->userdata("ciu"));
      $this->db->update("analiticas");
      return $this->db->affected_rows();
   }

   public function leerPruebasAnalitica($codigo)
   {
      $this->db->select("pruebas, observaciones_personal");
      $this->db->where("codigo_analitica", $codigo);
      return $this->db->get("analiticas")->row_array();
   }

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
