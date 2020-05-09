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
}
