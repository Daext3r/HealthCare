<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gerente_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function nuevoTraslado($facultativo, $centro) {
      if($this->db->insert("traslados", array("centro_destino" => $centro, "CIU_facultativo" => $facultativo))) {
         return 1;
      } else {
         return 0;
      }
   }
}