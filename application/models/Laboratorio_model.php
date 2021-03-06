<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboratorio_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   /**
    * Registra un nuevo personal de laboratorio en un centro
    * @param string $usuario
    * @param int $centro
    */
   public function registrarPersonal($usuario, $centro)
   {
      if ($this->db->insert("laboratorio", array("CIU_personal" => $usuario, "centro" => $centro))) {
         return 1;
      } else {
         return 0;
      }
   }

   /**
    * Lee las analiticas atendidas por un personal de laboratorio X
    * @param string $lab
    * @return object
    */
   public function leerAnaliticasAtendidas($lab)
   {
      $this->db->select("codigo_analitica, fecha_solicitud");
      $this->db->where("CIU_personal", $lab);
      $this->db->where("fecha_resultado", null);
      return $this->db->get("analiticas")->result_array();
   }

   /**
    * Lee las analiticas terminadas de un personal de laboratorio
    * @param string $lab
    * @return object
    */
   public function leerAnaliticasTerminadas($lab)
   {
      return $this->db->query("SELECT codigo_analitica, fecha_solicitud, fecha_resultado FROM analiticas WHERE CIU_personal = ? ORDER BY fecha_resultado DESC", array($lab))->result_array();
   }
}
