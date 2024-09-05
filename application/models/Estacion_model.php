<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function guardar_estacion($data) {
        return $this->db->insert('estaciones', $data);  // 'estaciones' es el nombre de la tabla
    }
}
