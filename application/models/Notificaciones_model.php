<?php

class Notificaciones_model extends CI_Model {

public function insertar_notificacion($data) {
    $this->db->insert('notificaciones', $data);
}

public function obtener_notificaciones($id_estacion) {
    return $this->db->get_where('notificaciones', ['id_estacion' => $id_estacion])->result();
}

public function eliminar_notificacion($id) {
    $this->db->delete('notificaciones', ['id' => $id]);
}



}
