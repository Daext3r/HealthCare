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
}
