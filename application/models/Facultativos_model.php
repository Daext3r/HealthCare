<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facultativos_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function buscarEspecialidad($pista)
   {
      $this->db->select("id, denominacion");
      $this->db->like("denominacion", $pista);
      return $this->db->get("especialidades")->result_array();
   }

   public function alta($usuario, $colegiado, $especialidad, $sala, $centro)
   {
      if ($this->db->insert('facultativos', array('CIU_facultativo' => $usuario, 'numero_colegiado' => $colegiado, 'especialidad' => $especialidad, 'sala' => $sala, 'centro' => $centro))) {
         return 1;
      } else {
         return 0;
      }
   }

   public function buscarFacultativoNombre($nombre)
   {
      $this->db->select("CIU, nombre_completo");
      $this->db->like("nombre_completo", $nombre);
      return $this->db->get("vista_usuarios_facultativos")->result_array();
   }

   public function buscarFacultativoCiuNombre($dato)
   {
      $this->db->select("CIU, nombre_completo");
      $this->db->like('CIU', $dato);
      $this->db->or_like('nombre_completo', $dato);
      $this->db->group_by('CIU');
      return $this->db->get("vista_usuarios_facultativos")->result_array();
   }

   public function leerEnfermedadesPaciente($paciente)
   {
      $this->db->where("CIU_paciente", $paciente);
      $this->db->select("enfermedades");
      return $this->db->get("pacientes")->row_array()['enfermedades'];
   }

   public function actualizarEnfermedadesPaciente($paciente, $enfermedades)
   {
      $this->db->where("CIU_paciente", $paciente);
      $this->db->set("enfermedades", $enfermedades);

      if ($this->db->update("pacientes")) {
         return 1;
      } else {
         return 0;
      }
   }

   public function actualizarCentro($facultativo, $centro)
   {
      $this->db->where("CIU_facultativo", $facultativo);
      $this->db->set("centro", $centro);

      if ($this->db->update("facultativos")) {
         return 1;
      } else {
         return 0;
      }
   }

   public function leerAnaliticasPaciente($paciente)
   {
      return $this->db->query("SELECT codigo_analitica, fecha_solicitud, fecha_resultado, (SELECT especialidad FROM vista_usuarios_facultativos WHERE CIU  = analiticas.CIU_facultativo) AS especialidad FROM analiticas WHERE CIU_paciente = ?", array($paciente))->result_array();
   }
}
