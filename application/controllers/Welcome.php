<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Estacion_model');  // Cargar el modelo
    }

    public function index() {
        // Obtener estaciones activas
        $this->db->where('activa', 1);
        $estaciones = $this->db->get('estaciones')->result_array();

        foreach ($estaciones as &$estacion) {
            // Verificar si hay un tiempo activo para esta estación
            $this->db->where('id_estacion', $estacion['id']);
            $this->db->where('hora_fin', NULL);
            $tiempo_activo = $this->db->get('tiempos_estaciones')->row_array();

            // Si hay un tiempo activo, indicarlo
            $estacion['tiempo_activo'] = !empty($tiempo_activo);
        }

        $data['estaciones'] = $estaciones;
        $this->load->view('welcome_message', $data);
    }

    public function agregar() {
        // Cargar vista para agregar estación
        $this->load->view('agregar_estacion');
    }

    public function guardar_estacion() {
        // Obtener datos del formulario
        $numero_estacion = $this->input->post('numero_estacion');
        $nombre_estacion = $this->input->post('nombre_estacion');

        // Preparar los datos para insertar
        $data = array(
            'numero_estacion' => $numero_estacion,
            'nombre_estacion' => $nombre_estacion
        );

        // Insertar en la base de datos
        $this->Estacion_model->insertar_estacion($data);

        // Redirigir a la página principal
        redirect('welcome');
    }

    public function eliminar($id_estacion) {
        // Cambiar la columna activa a 0
        $this->db->where('id', $id_estacion);
        $this->db->update('estaciones', ['activa' => 0]);

        // Redirigir a la página principal
        redirect('welcome');
    }


    public function iniciar_tiempo_normal() {
        $id_estacion = $this->input->post('estacion_id');
    
        // Verificar si ya hay un tiempo en curso para esta estación
        $this->db->where('id_estacion', $id_estacion);
        $this->db->where('hora_fin', NULL);
        $tiempo_activo = $this->db->get('tiempos_estaciones')->row_array();
    
        if (!$tiempo_activo) {
            // Insertar nuevo registro con hora de inicio (sin duración)
            $data = [
                'id_estacion' => $id_estacion,
                'hora_inicio' => date('Y-m-d H:i:s') // Hora actual
            ];
            $this->db->insert('tiempos_estaciones', $data);
    
            // Devolver respuesta JSON de éxito
            echo json_encode(['success' => true, 'message' => 'Cronómetro normal iniciado']);
        } else {
            // Ya hay un tiempo activo
            echo json_encode(['success' => false, 'message' => 'Ya hay un tiempo activo para esta estación.']);
        }
    }
    


    // Iniciar tiempo (ya sea tiempo libre o cuenta regresiva)
    public function iniciar_tiempo_regresivo() {
        $id_estacion = $this->input->post('estacion_id');
        $duracion = $this->input->post('duracion'); // Duración en segundos

        // Verificar si ya hay un tiempo en curso para esta estación
        $this->db->where('id_estacion', $id_estacion);
        $this->db->where('hora_fin', NULL);
        $tiempo_activo = $this->db->get('tiempos_estaciones')->row_array();

        if (!$tiempo_activo) {
            // Insertar nuevo registro con hora de inicio y duración
            $data = [
                'id_estacion' => $id_estacion,
                'hora_inicio' => date('Y-m-d H:i:s'), // Hora actual
                'duracion' => $duracion // Duración especificada
            ];
            $this->db->insert('tiempos_estaciones', $data);
            echo json_encode(['success' => true, 'message' => 'Tiempo libre iniciado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ya hay un tiempo activo para esta estación.']);
        }
    }

    // Detener tiempo
   // Detener tiempo regresivo al finalizar
public function detener_tiempo_regresivo() {
    $id_estacion = $this->input->post('estacion_id');
    
    // Verificar si hay un tiempo activo
    $this->db->where('id_estacion', $id_estacion);
    $this->db->where('hora_fin', NULL);
    $tiempo_activo = $this->db->get('tiempos_estaciones')->row_array();
    
    if ($tiempo_activo) {
        $hora_inicio = new DateTime($tiempo_activo['hora_inicio']);
        $hora_fin = new DateTime(); // Hora actual
    
        // Calcular la duración en segundos
        $intervalo = $hora_inicio->diff($hora_fin);
        $duracion_segundos = ($intervalo->h * 3600) + ($intervalo->i * 60) + $intervalo->s;
    
        // Actualizar la hora de fin y la duración
        $this->db->where('id', $tiempo_activo['id']);
        $this->db->update('tiempos_estaciones', [
            'hora_fin' => $hora_fin->format('Y-m-d H:i:s'),
            'duracion' => $duracion_segundos // Guardar duración en segundos
        ]);
    
        echo json_encode(['success' => true, 'message' => 'Tiempo regresivo detenido correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No hay un tiempo activo para esta estación.']);
    }
}

    
// Detener cronómetro normal
public function detener_tiempo_normal() {
    $id_estacion = $this->input->post('estacion_id');

    // Verificar si hay un tiempo activo
    $this->db->where('id_estacion', $id_estacion);
    $this->db->where('hora_fin', NULL); // Buscar un registro activo (sin hora de fin)
    $tiempo_activo = $this->db->get('tiempos_estaciones')->row_array();

    if ($tiempo_activo) {
        $hora_inicio = new DateTime($tiempo_activo['hora_inicio']);
        $hora_fin = new DateTime(); // Hora actual

        // Calcular la duración en segundos
        $intervalo = $hora_inicio->diff($hora_fin);
        $duracion_segundos = ($intervalo->h * 3600) + ($intervalo->i * 60) + $intervalo->s;

        // Actualizar la hora de fin y la duración
        $this->db->where('id', $tiempo_activo['id']);
        $this->db->update('tiempos_estaciones', [
            'hora_fin' => $hora_fin->format('Y-m-d H:i:s'),
            'duracion' => $duracion_segundos // Guardar duración en segundos
        ]);

        echo json_encode(['success' => true, 'message' => 'Cronómetro detenido y duración guardada.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No hay un cronómetro activo para esta estación.']);
    }
}

//probando los cambios en una nueva rama
    
}