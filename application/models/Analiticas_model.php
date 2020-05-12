<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analiticas_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }
   
   public function nuevaAnalitica($paciente, $facultativo, $pruebas) {
      $this->db->insert("analiticas", array("CIU_paciente" => $paciente, "CIU_facultativo" => $facultativo, "pruebas" => $pruebas));
      return 1;
   }
}