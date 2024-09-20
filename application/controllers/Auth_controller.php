<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function login() {
        $this->load->view('login');
    }

    public function process() {
        $nombre = $this->input->post('nombre');
        $password = $this->input->post('password');

        // Obtener el usuario por nombre
        $usuario = $this->Usuario_model->obtenerPorNombre($nombre);

        // Verificar credenciales
        if ($usuario && password_verify($password, $usuario['password'])) {
            // Configurar los datos de sesión
            $this->session->set_userdata('usuario_id', $usuario['idUsuario']);
            
            // Redirigir a la página del cronómetro que está en el controlador Welcome
            redirect('welcome'); // Cambia 'cronometro' si el método tiene un nombre diferente
        } else {
            // Mostrar mensaje de error de autenticación
            $data['error'] = 'Usuario o contraseña incorrectos';
            $this->load->view('login', $data);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
