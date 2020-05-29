<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informes_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   /**
    * Lee los informes de un paciente
    * @param string $ciu
    * @return object
   */
   public function leerListaInformes($ciu)
   {
      //leemos todos los informes de este usuario
      $this->db->select("id, privado, episodio, fecha, nombre_completo_medico, especialidad");
      $this->db->where("CIU_paciente", $ciu);
      $this->db->order_by("fecha", "DESC");
      return $this->db->get("vista_resumen_informes")->result_array();
   }

   /**
    * Crea un nuevo informe
    * @param string $contenido
    * @param string $fac
    * @param string $paciente
    * @param int $episodio
    * @param date $fecha
    * @param string $hora
    * @param boolean $privado
    * @return objectF
    */
   public function guardarInforme($contenido, $fac, $paciente, $episodio, $fecha, $hora, $privado)
   {
      return $this->db->insert("informes", array("CIU_facultativo" => $fac, "CIU_paciente" => $paciente, "fecha" => $fecha, "hora" => $hora, "contenido" => $contenido, "episodio" => $episodio, "privado" => $privado));
   }

   /**
    * Lee todos los datos de un informe
    * @param int $id
    * @return object
    */
   public function leerInforme($id)
   {
      $this->db->where("id", $id);
      return $this->db->get("vista_resumen_informes")->row_array();
   }
}
