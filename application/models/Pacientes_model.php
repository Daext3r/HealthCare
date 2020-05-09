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

   public function crearEpisodio($descripcion, $especialidad, $paciente) {
      if($this->db->insert('episodios', array("CIU_paciente" => $paciente, "especialidad" => $especialidad, "descripcion" => $descripcion))) {
         return 1;
      } else {
         return 0;
      }
   }

   public function leerEpisodios($paciente) {
      return $this->db->query("SELECT id, CIU_paciente, descripcion, fecha_creacion, ult_actualizacion, cerrado, (SELECT denominacion from especialidades WHERE especialidades.id = episodios.especialidad) AS especialidad FROM episodios WHERE CIU_paciente = ?", array($paciente))->result_array();
   }

   public function buscarPacienteCiuNombre($dato) {
      $this->db->select("CIU, nombre_completo");
      $this->db->like('CIU', $dato);
      $this->db->or_like('nombre_completo', $dato);
      $this->db->group_by('CIU');
      return $this->db->get("vista_usuarios_pacientes")->result_array();
   }

   public function leerFacultativosReferencia($ciu) {
      $this->db->where("CIU_paciente", $ciu);
      return $this->db->get("vista_pacientes_facultativos_referencia")->row_array();
   }
}
