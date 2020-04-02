<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paciente extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no tiene ciu es que no ha pasado por el login, lo redirigimos al mismo
      if (!$this->session->userdata("ciu")) {
         //redirigimos al login
         redirect(base_url() . "login");
         return;
      }

      //carga el modelo de la base de datos
      $this->load->model("Usuarios_model");

      //comprobamos que el usuario tenga acceso a este panel
      if ($this->session->userdata('perfiles')['paciente'] == true) {

         //si el usuario tiene permiso de paciente, comprobamos si ya tiene los datos guardados
         if ($this->session->userdata("dni") == "") {
            //si la session dni no existe es que es la primera vez que entra en este apartado, por lo que leemos los datos
            $publicos = $this->Usuarios_model->leerDatosPublicos($this->session->userdata("ciu"));
            $privados = $this->Usuarios_model->leerDatosPrivados($this->session->userdata("ciu"));

            //los datos privados seran de sesion
            $this->session->set_userdata($privados);

            $this->session->set_userdata($publicos);

            //DESACTIVADO POR EL MOMENTO
            //En caso de querer activarlo, se han de modificar varias vistas
            //los datos publicos seran cookies
            /*foreach ($publicos as $clave => $valor) {
                    set_cookie($clave, $valor, 0, $this->config->item("application_domain"), "/");
                }*/

            //por ultimo guardamos el tipo de usuario que tiene, por lo que no podrá acceder a otros paneles hasta que no vuelva a iniciar sesión con otro perfil
            $this->session->set_userdata("tipo", "paciente");
         }
      } else {
         //si no tiene permiso de paciente, le sacamos de aqui
         redirect(base_url() . "login");
      }
   }

   public function logout()
   {
      //el propio login borra la sesion
      redirect(base_url() . "login");
   }

   public function inicio()
   {
      //leemos los datos de inicio. notificaciones, citas y tratamientos
      $datos = $this->Usuarios_model->leerCantidadDatos($this->session->userdata("ciu"), array(null, "citas", "tratamientos", "notificaciones"));


      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/head", array(
         "hojas" => array("modules/panel", "paciente/inicio", "modules/panel-responsive"),
         "scripts" => array("utils/common", "paciente/inicio")
      ));

      //carga el modulo principal
      $this->load->view("modules/panel");

      //carga la vista de inicio
      $this->load->view("paciente/Inicio_v", array("datos" => $datos));
   }

   public function citas()
   {
      $this->load->model("Citas_model");
      $this->load->model("Paciente_m");
      $citas = $this->Citas_model->leerCitas($this->session->userdata("ciu"));

      $facultativos = $this->Paciente_m->leerFacultativos($this->session->userdata("ciu"));

      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/head", array(
         "hojas" => array("modules/panel", "paciente/citas", "modules/panel-responsive"),
         "scripts" => array("utils/common", "paciente/citas")
      ));

      //carga el modulo principal
      $this->load->view("modules/panel");

      //carga la vista de inicio
      $this->load->view("paciente/Citas_v", array(
         "citas" => $citas, "facultativos" => $facultativos
      ));
   }

   public function tratamientos()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/head", array(
         "hojas" => array("modules/panel", "paciente/tratamientos", "modules/panel-responsive"),
         "scripts" => array("utils/common", "paciente/tratamientos")
      ));

      //carga el modulo principal
      $this->load->view("modules/panel");

      //carga la vista de inicio
      $this->load->view("paciente/Tratamientos_v");
   }

   public function informes()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/head", array(
         "hojas" => array(
            "modules/panel", "paciente/informes", "modules/panel-responsive"
         ),
         "scripts" => array("utils/common", "paciente/informes", "lib/pagination")
      ));

      //carga el modulo principal
      $this->load->view("modules/panel");

      //carga la vista de inicio
      $this->load->view("paciente/Informes_v");
   }

   public function misdatos()
   {
      //carga el head con las hojas de estilos y scripts necesarios
      $this->load->view("modules/head", array(
         "hojas" => array(
            "modules/panel", "paciente/misdatos", "modules/panel-responsive"
         ),
         "scripts" => array("utils/common", "paciente/misdatos")
      ));

      //carga el modulo principal
      $this->load->view("modules/panel");

      //carga la vista de inicio
      $this->load->view("paciente/MisDatos_v");
   }

   public function actualizarDatos()
   {
      //si no hay datos POST es que ha accedido directamente por la URL, lo redirigimos a inicio
      if (count($_POST) == 0) {
         redirect(base_url() . "paciente/inicio");
         return;
      }

      //añadimos la clave al array solo si el usuario ha introducido una nueva y ha cambiado el campo
      if ($this->input->post("clave") != "null") {
         if ($this->input->post("clave") != "") {
            $datos['clave'] = hash("sha512", $this->input->post("clave"));
         } else {
            //sesion temporal que servirá para mostrar un mensaje de error
            $this->session->set_flashdata("info", "error_clave");
            redirect(base_url() . "paciente/misdatos");
         }
      }

      $datos['correo'] = $this->input->post("correo");
      $datos['telefono'] = $this->input->post("telefono");
      $datos['fijo'] = $this->input->post("fijo");
      $datos['direccion'] = $this->input->post("direccion");

      //leemos de la session para usarlo en la clausula where
      $ciu = $this->session->userdata("ciu");
      $this->load->model("Paciente_m");

      if ($this->Paciente_m->actualizarDatos($datos, $ciu)) {
         //sesion temporal que servirá para mostrar un mensaje de informacion
         $this->session->set_flashdata("info", "ok");
         redirect(base_url() . "paciente/misdatos");
      } else {
         //sesion temporal que servirá para mostrar un mensaje de error
         $this->session->set_flashdata("info", "error_unk");
         redirect(base_url() . "paciente/misdatos");
      }
   }
}
