<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Centros_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function crearCentro($datos)
   {
      if($this->db->insert("centros", $datos)) {
         return 1;
      } else {
         return 0;
      }
   }
}
