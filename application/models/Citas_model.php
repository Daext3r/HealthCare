<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Citas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //usando QueryBuilders, borramos la cita
    public function borrarCita($cita, $paciente) {
        $this->db->where('id', $cita);
        $this->db->where('CIU_paciente', $paciente);
        
        //si se ejecuta la consulta, devuelve true. Si no, false
        return ($this->db->delete("citas")) ? true : false;
    }
}