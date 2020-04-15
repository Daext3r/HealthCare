<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permisos extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index($perfil)
   {
      //perfiles tiene los perfiles a los que puede tener acceso, para que no entre en ningun otro
      $perfiles = $this->session->userdata("perfiles");

      //leemos todos los tipos de perfil
      foreach ($perfiles as $clave => $valor) {
         //si el valor del perfil es true, y es al que quiere acceder ($perfil)
         if ($clave == $perfil && $valor) {
            $this->session->set_userdata("tipo", $perfil);
            //carga el modelo de la base de datos
            $this->load->model("Usuarios_model");

            //leemos los datos del usuario
            $publicos = $this->Usuarios_model->leerDatosPublicos($this->session->userdata("ciu"));
            $privados = $this->Usuarios_model->leerDatosPrivados($this->session->userdata("ciu"));

            //los ponemos en la sesion
            $this->session->set_userdata($privados);
            $this->session->set_userdata($publicos);

            redirect(base_url() . "$perfil/inicio");
         }
      }
   }
}
