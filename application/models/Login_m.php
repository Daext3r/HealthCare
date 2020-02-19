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

        //TODO: verificar la identidad del usuario, ver si estar registrado y llamar a self::leerPerfiles

        $result = $this->db->query("SELECT CIU FROM usuarios WHERE correo = ? AND clave = ? LIMIT 1", array($correo, $clave));

        //leemos una fila
        //si quisieramos leer varias usariamos result()
        $row = $result->row();


        //comprobamos que $row tenga un registro
        if($row) {
            //si lo tiene buscamos sus perfiles
            $perfiles = self::leerPerfiles($row->CIU);
            return $perfiles;
            
        } else {
            //si no lo tiene devolvemos false
            return false;
        }
    }

    public function leerPerfiles($ciu)
    {
        //variable que almacenará todos los perfiles a los que tiene acceso
        $perfiles = array();

        //si el usuario se ha autenticado correctamente, leemos y devolvemos los perfiles a los que tiene acceso
        
        $result = $this->db->query("SELECT CIU_paciente FROM pacientes WHERE CIU_paciente = '$ciu'");
        if($result->row()) {
            $perfiles['paciente'] = true;
        } else {
            $perfiles['paciente'] = false;
        }

        $result = $this->db->query("SELECT CIU_medico FROM facultativos WHERE CIU_medico = '$ciu'");
        if($result->row()) {
            $perfiles['medico'] = true;
        } else {
            $perfiles['medico'] = false;
        }

        $result = $this->db->query("SELECT CIU_personal FROM personal_laboratorio WHERE CIU_personal = '$ciu'");
        if($result->row()) {
            $perfiles['personal_lab'] = true;
        } else {
            $perfiles['personal_lab'] = false;
        }

        return $perfiles;
    }
}
