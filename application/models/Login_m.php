<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function autenticar($correo, $clave) {
        //recive por parametros el correo y la clave con la que se debe autenticar el usuario
        //en este punto la clave ya está cifrada en SHA512

        //TODO: verificar la identidad del usuario, si esta registrado y en caso de estarlo, buscar a cuantos perfiles tiene acceso
    }
}
