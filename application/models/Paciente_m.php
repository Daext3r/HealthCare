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
            return false;
        }
    }

    public function leerCitas($ciu)
    {
        //buscamos todas las citas de este paciente
        $this->db->where("CIU_paciente", $ciu);
        $this->db->where("estado", '0');

        //ejecutamos la consulta y devolvemos el array de citas
        $citas = $this->db->get("vista_citas_pacientes_medicos")->result_array();
        return $citas;
    }

    public function leerFacultativos($ciu)
    {
        
        $consulta = $this->db->query("SELECT (SELECT nombre_completo FROM vista_usuarios_medicos WHERE CIU = pacientes.CIU_medico_referencia) AS medico, CIU_medico_referencia AS CIU_medico FROM pacientes WHERE CIU_paciente = ?", array($ciu));

        //como queremos leer solo una fila, usamos ->row()
        $facultativos = $consulta->result_array();

        return $facultativos;
    }

    public function actualizarDatos($datos, $ciu) {
        
        foreach($datos as $campo => $valor) {
            $this->db->set($campo, $valor);
        }

        $this->db->where('ciu', $ciu);

        if($this->db->update("usuarios")) {
            return true;
        } else {
            return false;
        }
    }

    public function leerDatosInicio($ciu) {
        $datos = array();
        
        $this->db->like("CIU_usuario", $ciu);
        $this->db->from("notificaciones");
        $datos['notificaciones'] = $this->db->count_all_results();

        $this->db->like("CIU_paciente", $ciu);
        $this->db->from("citas");
        $datos['citas'] = $this->db->count_all_results();
        
        $this->db->like("CIU_paciente", $ciu);
        $this->db->from("tratamientos");
        $datos['tratamientos'] = $this->db->count_all_results();

        return $datos;
    }
}
