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

   public function buscarAnalitica($id) {
      return $this->db->query("SELECT (SELECT nombre_completo FROM vista_usuarios_nombre WHERE vista_usuarios_nombre.CIU = analiticas.CIU_paciente) AS paciente FROM analiticas WHERE codigo_analitica = ?", array($id))->result_array();
   }

   public function atenderAnalitica($id) {
      $this->db->where("codigo_analitica", $id);
      $this->db->set("CIU_personal", $this->session->userdata("ciu"));
      if($this->db->update("analiticas")) {
         return 1;
      } else {
         return 0;
      }
   }
}
