<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function leerDatos($ciu)
    {
        $consulta = $this->db->query("SELECT ciu, nombre, apellidos, dni, sexo, nacionalidad, direccion, telefono, fijo, fecha_nacimiento, correo FROM usuarios WHERE ciu = ?", array($ciu));

        //como queremos leer solo una fila, usamos ->row()
        $row = $consulta->row_array();

        if ($row) {
            return $row;
        } else {
            return false;
        }
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
            $this->db->from("citas");
            $array['citas'] = $this->db->count_all_results();
            
        }
        if (array_search("tratamientos", $valores)) {
            $this->db->like("CIU_paciente", $ciu);
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
}
