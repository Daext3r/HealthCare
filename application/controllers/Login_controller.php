<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . "vendor/autoload.php";

use Firebase\JWT\JWT;

class Login_controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model("Login_model");
   }

   public function test()
   {
      var_dump($_POST);
   }

   public function login()
   {
      //metodo llamado por el formulario de login
      $jwt = $this->input->post("jwt");
      $correo = $this->input->post("correo");
      $clave = hash("sha512", $this->input->post("clave"));
      $recuerdame = $this->input->post("recuerdame");

      if ($jwt != "") {
         //si hay token, lo desciframos
         $token = JWT::decode($jwt, $this->config->item('application_key'), array('HS512'));

         //leemos los datos del token
         $correo = $token->correo;
         $clave = $token->clave;
      }

      //el resultado será false o un array con los usuarios a los que tiene permiso y el ciu
      $perfiles = $this->Login_model->autenticar($correo, $clave);
      $ciu = $perfiles['ciu'];
      unset($perfiles['ciu']);

      if (!$perfiles) {
         //si el resultado es false, recargamos la pagina mostrando un mensaje de error
         $this->session->set_flashdata('error', 'no_user');

         //redirigimos al login
         redirect(base_url() . "login");
      } else {
         //correo que verá el usuario
         $correoSecreto = "";

         //si hemos marcado la casilla de recordar, generamos el jwt para mandarlo a la vista y que lo guarde en localstorage junto al correo oculto
         if ($recuerdame == "on") {
            $jwt = JWT::encode(array("correo" => $correo, "clave" => $clave), $this->config->item('application_key'), 'HS512');

            //separamos el correo en usuario y servidor
            $correo = explode("@", $correo);

            //escribimos los tres primeros caracteres
            for ($i = 0; $i < 3; $i++) {
               $correoSecreto = $correoSecreto . $correo[0][$i];
            }

            //rellenamos el resto con asteriscos
            for ($i = 4; $i < count(str_split($correo[0], 1)) + 1; $i++) {
               $correoSecreto = $correoSecreto . "*";
            }

            //añadimos el arroba y el dominio del correo
            $correoSecreto = $correoSecreto . "@" . $correo[1];
         }

         //sesion que contiene los perfiles a los que tiene acceso
         //se usara para que mas adelante no acceda a otros paneles
         $this->session->set_userdata('perfiles', $perfiles);
         $this->session->set_userdata("ciu", $ciu);

         //carga el head con una hoja de estilos
         $this->load->view("modules/ViewModule_Head", array("hojas" => array("utils/perfiles"), "scripts" => array("utils/perfiles")));

         //carga la vista de seleccion de perfil
         $this->load->view("Perfiles_v", array("perfiles" => $perfiles, "jwt" => $jwt, "correo" => ($correoSecreto) ? $correoSecreto : ""));
      }
   }
}
