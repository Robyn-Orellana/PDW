<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

      // Función para insertar una nueva estación en la tabla 'estaciones'
      public function insertar_estacion($data) {
        $this->db->insert('estaciones', $data);
    }
    
    // Función para obtener una estación por su número de estación
    public function obtener_estacion_por_numero($numero_estacion) {
        return $this->db->get_where('estaciones', array('numero_estacion' => $numero_estacion))->row_array();
    }

  // Nueva función para obtener todas las estaciones activas
  public function obtener_todas_las_estaciones() {
    $this->db->select('*');
    $this->db->from('estaciones');
    $this->db->where('activa', 1);  // Solo estaciones activas
    $query = $this->db->get();
    return $query->result_array(); // Retorna todas las estaciones como un array
}

}
