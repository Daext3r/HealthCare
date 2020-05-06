<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informes_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   //leemos los informes como paciente
   public function leerListaInformesPaciente($ciu)
   {
      //leemos todos los informes de este usuario
      $this->db->select("id, privado, episodio, fecha, nombre_completo_medico, especialidad");
      $this->db->where("CIU_paciente", $ciu);
      $this->db->order_by("fecha", "DESC");
      $query = $this->db->get("vista_resumen_informes");

      $informes = $query->result_array();

      return $informes;
   }

   //leemos los informes como Facultativo
   public function leerListaInformesFacultativo($ciu) {

   }

   public function guardarInforme($contenido, $fac, $paciente, $episodio, $fecha, $hora)
   {
      return $this->db->insert("informes", array("CIU_facultativo" => $fac, "CIU_paciente" => $paciente, "fecha" => $fecha, "hora" => $hora, "contenido" => $contenido, "episodio" => $episodio));
   }

   public function leerInforme($id) {
      $this->db->where("id", $id);
      return $this->db->get("vista_resumen_informes")->row_array();
   }
}
