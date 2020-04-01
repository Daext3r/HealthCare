<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Citas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function leerCitas($ciu)
    {
        //buscamos todas las citas de este paciente
        $this->db->where("CIU_paciente", $ciu);
        $this->db->where("estado", 'P');

        //ejecutamos la consulta y devolvemos el array de citas
        $citas = $this->db->get("vista_citas_pacientes_facultativos")->result_array();
        return $citas;
    }

    public function borrarCita($cita, $paciente)
    {
        $this->db->where('id', $cita);
        $this->db->where('CIU_paciente', $paciente);

        //si se ejecuta la consulta, devuelve true. Si no, false
        return ($this->db->delete("citas")) ? true : false;
    }

    public function leerCitasDia($medico, $fecha, $hora)
    {
        $this->db->where("CIU_facultativo", $medico);
        $this->db->where("fecha", $fecha);
        
        //el paciente quiere esta hora como minimo
        $this->db->where("hora >=", $hora);

        //la hora maxima de una cita seran las 14:55
        $this->db->where("hora <", "15:00");
        
        //seleccionamos solo las horas
        $this->db->select("hora");

        //devolvemos las citas de ese dia
        $result = $this->db->get("citas");
        return $result;
    }

    public function seleccionarCita($medico, $paciente, $fecha, $hora) {
        $datos = array("CIU_facultativo" => $medico, "CIU_paciente" => $paciente, "fecha" => $fecha, "hora" => $hora, "estado" => 'P');

        if($this->db->insert("citas", $datos)) {
            return true;
        } else {
            return false;
        }
    }
}
