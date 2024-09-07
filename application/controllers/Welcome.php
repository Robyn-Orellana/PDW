<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Estacion_model');  // Cargar el modelo
    }
	public function index()
{
    $this->db->where('activa', 1);
    $estaciones = $this->db->get('estaciones')->result_array();

    foreach ($estaciones as &$estacion) {
        // Verificar si hay un tiempo activo para esta estación
        $this->db->where('id_estacion', $estacion['id']);
        $this->db->where('hora_fin', NULL);
        $tiempo_activo = $this->db->get('tiempos_estaciones')->row_array();

        // Si hay un tiempo activo, lo indicamos
        $estacion['tiempo_activo'] = !empty($tiempo_activo);
    }

    $data['estaciones'] = $estaciones;
    $this->load->view('welcome_message', $data);
}

    public function agregar()
    {
        // Aquí puedes cargar una vista o manejar la lógica para agregar una nueva estación
        $this->load->view('agregar_estacion');
    }

    public function guardar_estacion() {
        // Cargar el modelo
        $this->load->model('Estacion_model');
    
        // Obtener los datos del formulario
        $numero_estacion = $this->input->post('numero_estacion');
        $nombre_estacion = $this->input->post('nombre_estacion');
    
        // Preparar los datos para insertar en la base de datos
        $data = array(
            'numero_estacion' => $numero_estacion,
            'nombre_estacion' => $nombre_estacion
        );
    
        // Insertar los datos en la tabla estaciones
        $this->Estacion_model->insertar_estacion($data);
    
        // Redirigir a la página de inicio
        redirect('welcome');
    }

    // Función para eliminar estación (cambiar activa a 0)
    public function eliminar($id_estacion)
    {
        // Cambia la columna activa a 0 en la tabla estaciones
        $this->db->where('id', $id_estacion);
        $this->db->update('estaciones', ['activa' => 0]);

        // Redirigir de vuelta a la página principal
        redirect('welcome');
    }

    public function iniciar_tiempo($id_estacion)
{
    // Verificar si ya existe un tiempo en curso para esta estación
    $this->db->where('id_estacion', $id_estacion);
    $this->db->where('hora_fin', NULL); // Solo si no ha terminado
    $tiempo_activo = $this->db->get('tiempos_estaciones')->row_array();

    if (!$tiempo_activo) {
        // Insertar un nuevo registro de tiempo con la hora de inicio
        $data = [
            'id_estacion' => $id_estacion,
            'hora_inicio' => date('Y-m-d H:i:s'), // Hora actual
        ];

        $this->db->insert('tiempos_estaciones', $data);
    } else {
        // Ya hay un tiempo en curso, puedes manejar este caso con un mensaje si lo prefieres
        echo "Ya hay un tiempo activo para esta estación.";
    }

    // Redirigir a la página principal
    redirect('welcome');
}

public function detener_tiempo($id_estacion)
{
    // Verificar si hay un tiempo activo (sin hora_fin)
    $this->db->where('id_estacion', $id_estacion);
    $this->db->where('hora_fin', NULL);
    $tiempo_activo = $this->db->get('tiempos_estaciones')->row_array();

    if ($tiempo_activo) {
        // Actualizar la hora de fin con la hora actual
        $this->db->where('id', $tiempo_activo['id']);
        $this->db->update('tiempos_estaciones', ['hora_fin' => date('Y-m-d H:i:s')]);
    } else {
        // No hay tiempo activo, manejar este caso con un mensaje
        echo "No hay un tiempo activo para esta estación.";
    }

    // Redirigir a la página principal
    redirect('welcome');
}


	
}
