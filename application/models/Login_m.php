<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_m extends CI_Model
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
            //si no es el usuario root leemos sus perfiles
            if ($row->ciu != 'root') {
                //si lo tiene buscamos sus perfiles
                $perfiles = self::leerPerfiles($row->ciu);
                $perfiles['ciu'] = $row->ciu;
                return $perfiles;
            } else {
                //si es root devolvemos 'root'
                return 'root';
            }

        } else {
            //si no hay resultados en row devolvemos false
            return false;
        }
    }

    public function leerPerfiles($ciu)
    {
        //variable que almacenará todos los perfiles a los que tiene acceso
        $perfiles = array();

        //si el usuario se ha autenticado correctamente, leemos y devolvemos los perfiles a los que tiene acceso
        $this->db->select("ciu_paciente");
        $this->db->where("ciu_paciente", $ciu);
        $result = $this->db->get("pacientes");
        if ($result->result()) {
            $perfiles['paciente'] = true;
        } else {
            $perfiles['paciente'] = false;
        }

        $this->db->select("ciu_medico");
        $this->db->where("ciu_medico", $ciu);
        $result = $this->db->get("facultativos");
        if ($result->row()) {
            $perfiles['medico'] = true;
        } else {
            $perfiles['medico'] = false;
        }



        $this->db->select("ciu_personal");
        $this->db->where("ciu_personal", $ciu);
        $result = $this->db->get("personal_laboratorio");
        if ($result->row()) {
            $perfiles['personal_lab'] = true;
        } else {
            $perfiles['personal_lab'] = false;
        }

        return $perfiles;
    }
}
