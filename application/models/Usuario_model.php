<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtenerTodos() {
        // Obtiene todos los usuarios de la tabla 'usuarios'
        $query = $this->db->get('usuarios');
        return $query->result_array(); // Devuelve los resultados como un array asociativo
    }

    public function obtenerPorNombre($nombre) {
        // Obtiene un usuario por nombre
        $this->db->where('nombre', $nombre);
        $query = $this->db->get('usuarios');
        return $query->row_array(); // Devuelve una fila como un array asociativo
    }

    public function crear($data) {
        return $this->db->insert('usuarios', $data);
    }

    public function obtenerPorId($id) {
        // Obtiene un usuario por ID
        $this->db->where('idUsuario', $id);
        $query = $this->db->get('usuarios');
        return $query->row_array(); // Devuelve una fila como un array asociativo
    }

    public function actualizar($id, $data) {
        $this->db->where('idUsuario', $id);
        return $this->db->update('usuarios', $data);
    }

    public function eliminar($id) {
        $this->db->where('idUsuario', $id);
        return $this->db->delete('usuarios');
    }
}
