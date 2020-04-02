<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_controller extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();
      $this->load->model("Usuarios_model");
   }

   public function leerNotificaciones()
   {

      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      //cargamos las notificaciones y las devolvemos
      $notifs = $this->Usuarios_model->leerNotificaciones($this->session->userdata("ciu"));
      echo json_encode($notifs);
   }

   public function borrarNotificacion()
   {
      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      //borramos la notifiacion
      $this->Usuarios_model->borrarNotificacion($this->input->post("id"));
   }

   public function registrarUsuario()
   {
      //si no estamos realizando una peticion ajax, redirigimos a login y anulamos ejecucion del script
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }

      //guardamos los datos del formulario en el array 
      foreach ($_POST as $clave => $valor) {
         $datos[$clave] = $valor;
      }
 
      //añadimos una clave por defecto y generamos el ciu
      $datos['clave'] = hash('sha512', "12345678");
      $datos['ciu'] = self::generarCiu($datos['nombre'], $datos['apellidos'], $datos['fecha_nacimiento']);

      //insertamos los datos y mostramos un error en funcion de si ha habido error o no
      if ($this->Usuarios_model->registrarUsuario($datos)) {
         echo 1;
      } else {
         echo 0;
      }
   }

   public function generarCiu($nombre, $apellidos, $fnac)
   {
      //ponemos la primera letra en mayuscula y separamos el nombre en caracteres
      $nombre = ucfirst($nombre);
      $nombre = str_split($nombre, 1);

      //dividimos en 2 apellidos
      $apellidos = explode(" ", $apellidos);

      //dividimos cada apellido en caracteres y les ponemos la primera letra en mayuscula
      $apellido1 = $apellidos[0];
      $apellido1 = ucfirst($apellido1);
      $apellido1 = str_split($apellido1, 1);

      $apellido2 = $apellidos[1];
      $apellido2 = ucfirst($apellido2);
      $apellido2 = str_split($apellido2, 1);

      //primer y tercer caracter de nombre y apellidos
      $ciu = $nombre[0] . $nombre[2] . $apellido1[0] . $apellido1[2] . $apellido2[0] . $apellido2[2];

      //convertimos a timestamp
      $fnac = strtotime($fnac);

      //fecha de nacimiento
      $ciu .= date("Y", $fnac);
      $ciu .= date("m", $fnac);
      $ciu .= date("d", $fnac);

      return $ciu;
   }
}
