<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   public function leerDatosPrivados($ciu)
   {
      $this->db->select("ciu, dni, direccion, telefono, fijo, correo");
      $this->db->where("ciu", $ciu);
      return $this->db->get("usuarios")->row_array();
   }

   public function leerDatosPublicos($ciu)
   {
      $this->db->select("sexo, nombre, apellidos, nacionalidad, fecha_nacimiento");
      $this->db->where("ciu", $ciu);
      return $this->db->get("usuarios")->row_array();
   }

   public function leerCantidadDatos($ciu, $valores)
   {
      //$valores es un array que tiene los valores que necesitamos
      //usamos un if porque el campo a buscar se llama de forma distinta en las distintas tablas
      $array = array();

      if (array_search("notificaciones", $valores)) {
         $this->db->like("CIU_usuario", $ciu);
         $this->db->from("notificaciones");
         $array['notificaciones'] = $this->db->count_all_results();
      }

      if (array_search("citas", $valores)) {
         $this->db->like("CIU_paciente", $ciu);
         $this->db->where("estado", "P");
         $this->db->from("citas");
         $array['citas'] = $this->db->count_all_results();
      }
      if (array_search("tratamientos", $valores)) {
         $this->db->like("CIU_paciente", $ciu);
         $this->db->where("fecha_fin >=", date("Y-m-d"));
         $this->db->from("tratamientos");
         $array['tratamientos'] = $this->db->count_all_results();
      }

      return $array;
   }

   public function leerNotificaciones($ciu)
   {
      $this->db->where("CIU_usuario", $ciu);
      $this->db->select("id, resumen, informacion");
      $datos = $this->db->get("notificaciones")->result_array();
      return $datos;
   }

   public function borrarNotificacion($id)
   {
      $this->db->delete('notificaciones', array("id" => $id));
   }

   public function registrarUsuario($datos)
   {
      if ($this->db->insert("usuarios", $datos)) {
         return true;
      } else {
         return false;
      }
   }

   public function buscarUsuarioCiu($ciu) {
      
      $this->db->like("CIU", $ciu);
      return $this->db->get("vista_usuarios_nombre")->result_array();

   }

   public function leerDatosUsuario($ciu) {
      $this->db->select("CIU, nombre, apellidos, dni, sexo, nacionalidad, fecha_nacimiento, correo, direccion, telefono, fijo");
      $this->db->where("CIU", $ciu);
      return $this->db->get("usuarios")->row_array();
   }

   public function actualizarUsuario($ciu, $datos) {
      $this->db->where("CIU", $ciu);
      $this->db->set($datos);
      if($this->db->update("usuarios")) {
         return 1;
      } else {
         return 2;
      }
   }
}
