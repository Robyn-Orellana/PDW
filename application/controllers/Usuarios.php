<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $data['usuarios'] = $this->Usuario_model->obtenerTodos();
        $this->load->view('index', $data);
    }

    public function agregar() {
        $this->load->view('agregar');
    }

    public function guardar() {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[usuarios.nombre]');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[usuarios.email]');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');
        $this->form_validation->set_rules('rol', 'Rol', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('agregar');
        } else {
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'rol' => $this->input->post('rol')
            );

            if ($this->Usuario_model->crear($data)) {
                $this->session->set_flashdata('success', 'Usuario creado con éxito');
                redirect('usuarios');
            } else {
                $this->session->set_flashdata('error', 'Hubo un problema al crear el usuario.');
                $this->load->view('agregar');
            }
        }
    }

    public function editar($id) {
        $data['usuario'] = $this->Usuario_model->obtenerPorId($id);
        $this->load->view('editar', $data);
    }

    public function actualizar($id) {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Contraseña', 'min_length[8]');
        $this->form_validation->set_rules('rol', 'Rol', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['usuario'] = $this->Usuario_model->obtenerPorId($id);
            $this->load->view('editar', $data);
        } else {
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'email' => $this->input->post('email'),
                'rol' => $this->input->post('rol')
            );

            if ($this->input->post('password')) {
                $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            }

            $this->Usuario_model->actualizar($id, $data);
            redirect('usuarios');
        }
    }

    public function eliminar($id) {
        $this->Usuario_model->eliminar($id);
        redirect('usuarios');
    }
}
