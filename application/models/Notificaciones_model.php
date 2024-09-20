<?php

class Notificaciones_model extends CI_Model {


    public function __construct() {
        parent::__construct();
        $this->load->database(); // Cargar la base de datos
    }



public function insertar_notificacion($data) {
    $this->db->insert('notificaciones', $data);
}

public function obtener_notificaciones($id_estacion) {
    return $this->db->get_where('notificaciones', ['id_estacion' => $id_estacion])->result();
}

public function eliminar_notificacion($id) {
    $this->db->where('id', $id);
    return $this->db->delete('notificaciones');
}

  // Función para guardar una nueva notificación
  public function guardar_notificacion($data) {
    $this->db->insert('notificaciones', $data);
}

public function obtener_todas_las_notificaciones() {
    return $this->db->get('notificaciones')->result_array(); // Obtener todas las notificaciones
}


public function obtener_notificacion_por_id($id) {
    return $this->db->get_where('notificaciones', array('id' => $id))->row_array();
}

public function actualizar_notificacion($id, $data) {
    $this->db->where('id', $id);
    $this->db->update('notificaciones', $data);
}

}
