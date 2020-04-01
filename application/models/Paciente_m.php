<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paciente_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function leerFacultativos($ciu)
    {   
        $consulta = $this->db->query("SELECT (SELECT nombre_completo FROM vista_usuarios_facultativos WHERE CIU = pacientes.CIU_medico_referencia) AS medico, CIU_medico_referencia AS CIU_medico FROM pacientes WHERE CIU_paciente = ?", array($ciu));

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
}
