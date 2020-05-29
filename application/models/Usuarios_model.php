<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }

   /**
    * Lee ciertos datos del usuario que deben ser privados
    * @param string $ciu
    * @return object
    */
   public function leerDatosPrivados($ciu)
   {
      $this->db->select("ciu, dni, direccion, telefono, fijo, correo");
      $this->db->where("ciu", $ciu);
      return $this->db->get("usuarios")->row_array();
   }

   /**
    * Lee ciertos datos del usuario que pueden ser publicos
    * @param string $ciu
    * @return object
    */
   public function leerDatosPublicos($ciu)
   {
      $this->db->select("sexo, nombre, apellidos, nacionalidad, fecha_nacimiento");
      $this->db->where("ciu", $ciu);
      return $this->db->get("usuarios")->row_array();
   }

   /**
    * Lee los datos del apartado de inicio de un tipo de usuario
    * @param string $tipo
    */
   public function leerDatosInicio($tipo)
   {
      $datos = array();

      switch ($tipo) {
         case 'admin':
            //devuelve la cantidad de usuarios, centros, y tratamientos que hay en el sistema
            $datos = $this->db->query("SELECT (SELECT COUNT(*) FROM usuarios) as usuarios, (SELECT COUNT(*) FROM centros) as centros, (SELECT COUNT(*) FROM tratamientos) as tratamientos;")->result_array();
            break;
         case 'gerente':
            //devuelve la cantidad de pacientes, facultativos, y administrativos que hay en su centro
            $centro = $this->db->query("SELECT id as centro FROM centros WHERE CIU_gerente = ?", array($this->session->userdata("ciu")))->result_array()[0]['centro'];

            $datos = $this->db->query("SELECT (SELECT COUNT(*) FROM pacientes WHERE CIU_medico_referencia IN (SELECT CIU_facultativo FROM facultativos WHERE centro = ?)) AS pacientes, (SELECT COUNT(*) FROM facultativos WHERE centro = ?) AS facultativos, (SELECT COUNT(*) FROM administrativos WHERE id_centro = ?) AS administrativos", array($centro, $centro, $centro))->row_array();
            break;
         case 'administrativo':
            $fecha = new DateTime();

            //devuelve la cantidad de citas en el dia de hoy, pacientes asignados a este centro (por el medico de referencia), facultativos trabajando en el centro
            $datos = $this->db->query("SELECT (SELECT COUNT(*) FROM citas WHERE fecha = ?) AS citas, (SELECT COUNT(*) FROM pacientes WHERE CIU_medico_referencia IN (SELECT CIU_facultativo FROM facultativos WHERE centro = (SELECT id_centro FROM administrativos WHERE CIU_administrativo = ? ))) AS pacientes, (SELECT COUNT(*) FROM facultativos WHERE centro = (SELECT id_centro FROM administrativos WHERE CIU_administrativo = ?)) AS facultativos", array($fecha->format('Y-m-d'), $this->session->userdata("ciu"), $this->session->userdata("ciu")))->result_array();
            break;
         case 'facultativo':
            //devuelve la cantidad de citas que tiene hoy, informes realizados, y pacientes de los cuales es el medico de referencia
            $datos = $this->db->query("SELECT (SELECT COUNT(*) FROM citas WHERE CIU_facultativo = ? AND fecha = ?) AS citas, (SELECT COUNT(*) FROM informes WHERE CIU_facultativo = ?) AS informes, (SELECT COUNT(*) FROM pacientes WHERE CIU_medico_referencia = ?) AS pacientes", array($this->session->userdata("ciu"), date("Y-m-d"), $this->session->userdata("ciu"), $this->session->userdata("ciu")))->result_array();
            break;
         case 'laboratorio':
            //devuelve la cantidad de pruebas pendientes, pruebas cerradas, y pruebas realizadas por el
            $datos = $this->db->query("SELECT (SELECT COUNT(*) FROM analiticas WHERE fecha_resultado IS NULL) AS pendientes, (SELECT COUNT(*) FROM analiticas WHERE fecha_resultado IS NOT NULL) AS cerradas, (SELECT COUNT(*) FROM analiticas WHERE fecha_resultado IS NOT NULL AND CIU_personal = ?) AS realizadas", array($this->session->userdata("ciu")))->result_array();
            break;
         case 'paciente':
            //devuelve la cantidad de notificaciones, citas, y tratamientos activos que tiene
            $datos = $this->db->query("SELECT (SELECT COUNT(*) FROM notificaciones WHERE CIU_usuario = ?) AS notificaciones, (SELECT COUNT(*) FROM citas WHERE estado = 'P' AND CIU_paciente = ?) AS citas, (SELECT COUNT(*) FROM tratamientos WHERE CIU_paciente = ? AND fecha_fin >= ?) AS tratamientos", array($this->session->userdata("ciu"), $this->session->userdata("ciu"), $this->session->userdata("ciu"), date("Y-m-d")))->result_array();
            break;
      }

      return $datos;
   }

   /**
    * Lee las notificaciones de un usuario
    * @param string $ciu
    * @return object
    */
   public function leerNotificaciones($ciu)
   {
      $this->db->where("CIU_usuario", $ciu);
      $this->db->select("id, resumen, informacion");
      $datos = $this->db->get("notificaciones")->result_array();
      return $datos;
   }

   /**
    * Borra una notificacion
    * @param int $id
    */
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

   /**
    * Busca un usuario por una parte del CIU
    * @param string $ciu
    * @deprecated
    * @return object
    */
   public function buscarUsuarioCiu($ciu)
   {
      $this->db->like("CIU", $ciu);
      return $this->db->get("vista_usuarios_nombre")->result_array();
   }

   /**
    * Busca un usuario por parte del nombre
    * @param string $nombre
    * @deprecated
    * @return object
    */
   public function buscarUsuarioNombre($nombre)
   {
      $this->db->like("nombre_completo", $nombre);
      return $this->db->get("vista_usuarios_nombre")->result_array();
   }

   /**
    * Busca un usuario por una parte del nombre o del CIU
    * @param string $dato
    * @return object
    */
   public function buscarUsuarioCiuNombre($dato)
   {
      $this->db->like('CIU', $dato);
      $this->db->or_like('nombre_completo', $dato);
      $this->db->group_by('CIU');
      return $this->db->get("vista_usuarios_nombre")->result_array();
   }

   /**
    * Lee datos de un usuario
    * @param string $ciu
    * @return object
    */
   public function leerDatosUsuario($ciu)
   {
      $this->db->select("CIU, nombre, apellidos, dni, sexo, nacionalidad, fecha_nacimiento, correo, direccion, telefono, fijo");
      $this->db->where("CIU", $ciu);
      return $this->db->get("usuarios")->row_array();
   }

   /**
    * Actualiza los datos de un usuario
    * @param string $ciu
    * @param object $datos
    * @return int 
    */
   public function actualizarUsuario($ciu, $datos)
   {
      $this->db->where("CIU", $ciu);
      $this->db->set($datos);
      if ($this->db->update("usuarios")) {
         return 1;
      } else {
         return 2;
      }
   }

   /**
    * Comprueba si un usuario existe 
    * @param string $ciu
    * @return int
    */
   public function comprobarExistencia($ciu)
   {
      $this->db->where('CIU', $ciu);
      return $this->db->count_all_results('usuarios');
   }

   /**
    * Cambia la clave de un usuario
    * @param string $ciu
    * @param string $ciu
    */
   public function cambiarClave($ciu, $clave)
   {
      $this->db->where("CIU", $ciu);
      $this->db->set("clave", $clave);
      if ($this->db->update("usuarios")) {
         return 1;
      } else {
         return 0;
      }
   }
}
