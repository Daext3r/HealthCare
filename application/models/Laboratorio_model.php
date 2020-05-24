<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboratorio_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function registrarPersonal($usuario, $centro)
   {
      if ($this->db->insert("laboratorio", array("CIU_personal" => $usuario, "centro" => $centro))) {
         return 1;
      } else {
         return 0;
      }
   }

   public function leerAnaliticasAtendidas($lab) {
      $this->db->select("codigo_analitica, fecha_solicitud");
      $this->db->where("CIU_personal", $lab);
      $this->db->where("fecha_resultado", null);
      return $this->db->get("analiticas")->result_array();
   }
}
