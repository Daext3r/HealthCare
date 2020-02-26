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

    public function leerCitas($ciu)
    {
        //buscamos todas las citas de este paciente
        $consulta = $this->db->query("SELECT * FROM vista_citas_pacientes_medicos WHERE CIU_paciente = '$ciu' AND estado = '0'");

        //ejecutamos la consulta y devolvemos el array de citas
        $citas = $consulta->result_array();

        return $citas;

    }
}
