<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pacientes_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function leerFacultativos($ciu)
   {
      //leemos el nombre y CIU del medico y enfermero de referencia
      return $this->db->query("SELECT (SELECT nombre_completo FROM vista_usuarios_facultativos WHERE CIU = pacientes.CIU_medico_referencia) as medico, CIU_medico_referencia AS CIU_medico, (SELECT nombre_completo FROM vista_usuarios_facultativos WHERE CIU = pacientes.CIU_enfermero_referencia) as enfermero, CIU_enfermero_referencia AS CIU_enfermero FROM pacientes WHERE CIU_paciente = ?;", array($ciu))->row_array();
   }

   public function actualizarDatos($datos, $ciu)
   {

      foreach ($datos as $campo => $valor) {
         $this->db->set($campo, $valor);
      }

      $this->db->where('ciu', $ciu);

      if ($this->db->update("usuarios")) {
         return true;
      } else {
         return false;
      }
   }

   public function alta($usuario, $medico, $enfermero, $grupo_sanguineo)
   {
      if($this->db->insert("pacientes", array("CIU_paciente" => $usuario, "CIU_medico_referencia" => $medico, "CIU_enfermero_referencia" => $enfermero, "grupo_sanguineo" => $grupo_sanguineo))) {
         return 1;
      } else {
         return 0;
      }
   }
}
