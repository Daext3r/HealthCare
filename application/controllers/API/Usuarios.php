<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();
      $this->load->model("Usuarios_model");

      //si no es una peticion ajax redirigimos al inicio
      if (!$this->input->is_ajax_request()) {
         redirect(base_url() . "login");
         return;
      }
   }

   /**
    * Lee los datos de inicio de cualquier usuario segun su tipo
    * @return object
    */
   public function leerDatosInicio()
   {
      $tipo = $this->session->userdata("tipo");
      echo json_encode($this->Usuarios_model->leerDatosInicio($tipo));
   }

   /**
    * Lee las notificaciones de un usuario
    * @return object
    */
   public function leerNotificaciones()
   {
      //cargamos las notificaciones y las devolvemos
      echo json_encode($this->Usuarios_model->leerNotificaciones($this->session->userdata("ciu")));
   }

   /**
    * Borra una notificacion
    */
   public function borrarNotificacion()
   {
      //borramos la notifiacion
      $this->Usuarios_model->borrarNotificacion($this->input->post("id"));
   }

   /**
    * Crea un nuevo usuario
    * @return int
    */
   public function registrarUsuario()
   {
      $datos = array();

      //guardamos los datos del formulario en un array 
      foreach ($_POST as $clave => $valor) {
         $datos[$clave] = $valor;
      }

      //añadimos una clave por defecto y generamos el ciu
      $datos['clave'] = hash('sha512', "12345678");
      $datos['ciu'] = self::generarCiu($datos['nombre'], $datos['apellidos'], $datos['fecha_nacimiento']);

      //insertamos los datos y mostramos un error en funcion de si ha habido error o no
      echo $this->Usuarios_model->registrarUsuario($datos) ? 1 : 0;
   }

   /**
    * Metodo para generar el CIU en funcion de varios datos
    * @return string
    * @param string $nombre
    * @param string $apellidos
    * @param string $fnac
    */
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

      //hacemos un bucle para comprobar que no exista ya un usuario con el mismo CIU

      $existe = true;
      $numero = 0;
      $nuevoCiu = "";

      //si existe el formato será NnAaAaAAAAMMDD[$numero]
      //por ejemplo: AeDnDl199912171 | AeDnDl199912172 | AeDnDl199912173 | AeDnDl199912174 etc
      do {
         //nuevo CIU a comprobar
         $nuevoCiu = $ciu . $numero;
         $cantidad = $this->Usuarios_model->comprobarExistencia($nuevoCiu);

         //si existe incrementamos el numero en uno
         if ($cantidad >= 1) {
            $numero++;
         } else {
            $existe = false;
         }
      } while ($existe);

      return $nuevoCiu;
   }

   /**
    * Busca un usuario segun su ciu
    * @return object
    * @deprecated
    */
   public function buscarUsuarioCiu()
   {
      echo json_encode($this->Usuarios_model->buscarUsuarioCiu($this->input->post("ciu")));
   }

   /**
    * Busca un usuario por una parte de su nombre
    * @return object
    * @deprecated
    */
   public function buscarUsuarioNombre()
   {
      echo json_encode($this->Usuarios_model->buscarUsuarioNombre($this->input->post("nombre")));
   }

   /**
    * Busca un usuario pro una parte de su nombre o su CIU
    * @return object
    */
   public function buscarUsuarioCiuNombre()
   {
      echo json_encode($this->Usuarios_model->buscarUsuarioCiuNombre($this->input->post("dato")));
   }

   /**
    * Lee los datos de un usuario
    * @return object
    */
   public function leerDatosUsuario()
   {
      echo json_encode($this->Usuarios_model->leerDatosUsuario($this->input->post("ciu")));
   }

   /**
    * Actualiza los datos de un usuario
    * @return int
    */
   public function actualizarUsuario()
   {
      //quitamos el id del array y lo guardamos a parte
      $datos = $_POST;
      $ciu = isset($datos['CIU']) ? $datos['CIU'] : $this->session->userdata("ciu");
      unset($datos['CIU']);

      //miramos si ha enviado imagen de perfil. de ser asi se procesa en otro metodo aparte y se quita del array
      if (isset($datos['img'])) {
         self::actualizarImagenPerfil($datos['img']);
         unset($datos['img']);
      }

      echo $this->Usuarios_model->actualizarUsuario($ciu, $datos);
   }

   /**
    * Restaura la clave de un usuario a 12345678
    * @return int
    */
   public function restaurarClave()
   {
      echo $this->Usuarios_model->cambiarClave($this->input->post("ciu"), hash("sha512", "12345678"));
   }

   /**
    * Cambia la clave de un usuario a la especificada
    * @return int
    */
   public function cambiarClave()
   {
      echo $this->Usuarios_model->cambiarClave($this->session->userdata("ciu"), hash("sha512", $this->input->post("clave")));
   }

   /**
    * Actualiza SOLO la imagen de perfil
    * @return void
    */
   public function actualizarImagenPerfil($imagenBase)
   {
      //cargamos el helper de file
      $this->load->helper("file");
      $imagen = explode(",", $imagenBase);
      $imagen = $imagen[1];

      //data:image/[formato];base64
      //separamos la propia imagen del formato
      $formato = explode(",", $imagenBase);
      $formato = $formato[0];

      //separamo por el ;
      $formato = explode(";", $formato);

      //cogemos la primera parte, y separamos por la barra
      $formato = explode("/", $formato[0]);

      //nos quedamos con el formato
      $formato = $formato[1];


      //borramos la imagen anterior que haya
      $archivos = glob("./assets/perfiles/" . $this->session->userdata("ciu") . ".*");
      if (count($archivos) >= 1) unlink($archivos[0]);

      //guardamos la nueva imagen de perfil
      write_file("./assets/perfiles/" . $this->session->userdata("ciu") . "." . $formato, base64_decode($imagen));
   }
}
