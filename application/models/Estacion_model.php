<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function guardar_estacion($data) {
        $data['hora_inicio'] = date('Y-m-d H:i:s');
        return $this->db->insert('estaciones', $data);  // 'estaciones' es el nombre de la tabla
    }

    public function obtener_estaciones() {
        $query = $this->db->get('estaciones');
        return $query->result_array();  // Retorna todas las filas de resultados
    }

    public function eliminar_estacion($numero_estacion) {
        $this->db->where('numero_estacion', $numero_estacion);
        $this->db->delete('estaciones');
    }
    
    
}
