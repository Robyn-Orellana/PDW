<?php
// Auth.php (ubicado en application/libraries)
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

    protected $CI;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->library('session');
    }

    public function check_login() {
        if (!$this->CI->session->userdata('logged_in')) {
            redirect('auth_controller/login');
        }
    }

    public function check_role($role) {
        if ($this->CI->session->userdata('role') !== $role) {
            show_error('No tienes permiso para acceder a esta página.', 403);
        }
    }
}
