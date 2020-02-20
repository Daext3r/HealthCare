<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paciente_m extends CI_Model
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
        }
    }
}
