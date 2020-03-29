<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		//borramos todos los datos de sesión que existan
		$this->session->sess_destroy();

		//carga el head con una hoja de estilos
		$this->load->view("modules/head", array("hojas" => array("utils/login"), "scripts" => array("utils/login")));

		//carga la vista de login
		$this->load->view("Login_v");
	}

	public function autenticar()
	{
		//metodo llamado por el formulario de login
		$correo = $this->input->post("email");
		$clave = hash("sha512", $this->input->post("clave"));

		$this->load->model("Login_m");

		$resultado = $this->Login_m->autenticar($correo, $clave);

		if (!$resultado) {
			//si el resultado es false, recargamos la pagina mostrando un mensaje de error
			$this->session->set_flashdata('error', 'no_user');

			//redirigimos al login
			redirect(base_url() . "login");
		} else {
			//si el usuario no es root
			if ($resultado != 'root') {

				//escribimos la variable de CIU
				$this->session->set_userdata('ciu', $resultado['ciu']);

				//carga el head con una hoja de estilos
				$this->load->view("modules/head", array("hojas" => array("utils/perfiles")));

				//carga la vista de seleccion de perfil
				$this->load->view("Perfiles_v", array("perfiles" => $resultado));
			} else {

				//si el usuario es root, escribimos el ciu y lo redirigimos a su panel
				$this->session->set_userdata("ciu", 'root');
				redirect(base_url() . 'root/inicio');
			}
		}
	}
}
