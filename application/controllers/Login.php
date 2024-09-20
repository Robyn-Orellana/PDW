<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');  // Cargar la biblioteca Auth
        $this->load->helper('url');    // Para redirigir a otras páginas
    }

    public function index() {
        // Cargar la vista del formulario de login
        $this->load->view('login');
    }

    public function process() {
        // Obtener el usuario y la contraseña del formulario de login
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Intentar autenticar al usuario usando la biblioteca Auth
        if ($this->auth->login($username, $password)) {
            // Si la autenticación es exitosa, redirigir a la página principal
            redirect('welcome');
        } else {
            // Si falla, volver al formulario de login con un mensaje de error
            $data['error'] = 'Usuario o contraseña incorrectos';
            $this->load->view('login', $data);
        }
    }

    public function logout() {
        // Cerrar la sesión del usuario y redirigir al formulario de login
        $this->auth->logout();
        redirect('login');
    }
}
