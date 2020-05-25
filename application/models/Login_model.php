<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function autenticar($correo, $clave)
   {
      //recibe por parametros el correo y la clave con la que se debe autenticar el usuario
      //en este punto la clave ya está cifrada en SHA512

      $result = $this->db->query("SELECT ciu FROM usuarios WHERE correo = ? AND clave = ? LIMIT 1", array($correo, $clave));

      //leemos una fila
      //si quisieramos leer varias usariamos result()
      $row = $result->row();


      //comprobamos que $row tenga un registro
      if ($row) {
         //leemos los perfiles del usuario
         $array = self::leerPerfiles($row->ciu);

         //guardamos tambien el ciu del usuario
         $array['ciu'] = $row->ciu;

         ///devolvemos el array con los perfiles y el ciu
         return $array;
      } else {
         //si no hay resultados en row devolvemos false
         return false;
      }
   }

   public function leerPerfiles($ciu)
   {
      //variable que almacenará todos los perfiles a los que tiene acceso
      $perfiles = array();

      //comprobamos si el usuario es paciente
      $this->db->select("ciu_paciente");
      $this->db->where("ciu_paciente", $ciu);
      $result = $this->db->get("pacientes");
      if ($result->result()) {
         $perfiles['paciente'] = true;
      } else {
         $perfiles['paciente'] = false;
      }

      //comprobamos si el usuario es facultativo
      $this->db->select("ciu_facultativo");
      $this->db->where("ciu_facultativo", $ciu);
      $result = $this->db->get("facultativos");
      if ($result->row()) {
         $perfiles['facultativo'] = true;
      } else {
         $perfiles['facultativo'] = false;
      }

      //comprobamos si el usuario es personal de laboratorio
      $this->db->select("ciu_personal");
      $this->db->where("ciu_personal", $ciu);
      $result = $this->db->get("laboratorio");
      if ($result->row()) {
         $perfiles['laboratorio'] = true;
      } else {
         $perfiles['laboratorio'] = false;
      }


      //comprobamos si el usuario es gerente de un centro
      $this->db->select("CIU_gerente");
      $this->db->where("CIU_gerente", $ciu);
      $result = $this->db->get("centros");
      if ($result->row()) {
         $perfiles['gerente'] = true;
      } else {
         $perfiles['gerente'] = false;
      }

      //comprobamos si el usuario es administrativo en un centro
      $this->db->select("CIU_administrativo");
      $this->db->where("CIU_administrativo", $ciu);
      $result = $this->db->get("administrativos");
      if ($result->row()) {
         $perfiles['administrativo'] = true;
      } else {
         $perfiles['administrativo'] = false;
      }

      //comprobamos si el usuario es administrador del sistema
      $this->db->select("CIU_usuario");
      $this->db->where("CIU_usuario", $ciu);
      $result = $this->db->get("admins");
      if ($result->row()) {
         $perfiles['admin'] = true;
      } else {
         $perfiles['admin'] = false;
      }

      //devolvemos todos los perfiles a los cuales hemos comprobado que tiene acceso
      return $perfiles;
   }
}
