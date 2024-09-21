<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Estacion_model');  // Cargar el modelo
        $this->load->model('Notificaciones_model');  // Modelo para notificaciones
    }

    public function index() {
        // Obtener estaciones activas
        $this->db->where('activa', 1);
        $estaciones = $this->db->get('estaciones')->result_array();

        // Cargar todas las notificaciones
        $notificaciones = $this->Notificaciones_model->obtener_todas_las_notificaciones();

        // Agrupar las notificaciones por estación
        $notificacionesPorEstacion = [];
        foreach ($notificaciones as $notificacion) {
            $estacionId = $notificacion['estacion_id'];
            if (!isset($notificacionesPorEstacion[$estacionId])) {
                $notificacionesPorEstacion[$estacionId] = [];
            }
            $notificacionesPorEstacion[$estacionId][] = $notificacion;
        }

        foreach ($estaciones as &$estacion) {
            // Verificar si hay un tiempo activo para esta estación
            $this->db->where('id_estacion', $estacion['id']);
            $this->db->where('hora_fin', NULL);
            $tiempo_activo = $this->db->get('tiempos_estaciones')->row_array();

            // Si hay un tiempo activo, indicarlo
            $estacion['tiempo_activo'] = !empty($tiempo_activo);

            // Agregar las notificaciones de esta estación
            $estacion['notificaciones'] = isset($notificacionesPorEstacion[$estacion['id']]) ? $notificacionesPorEstacion[$estacion['id']] : [];
        }

        $data['estaciones'] = $estaciones;
        $this->load->view('welcome_message', $data);
    }
       
    public function agregar() {
    // Cargar vista para agregar estación
        $this->load->view('agregar_estacion');
    }

    //aqui para las notificaiones----------------------------------------------------------
 

    public function notificacion() {

        $this->load->model('Notificaciones_model'); // Cargar el modelo de notificaciones
         $data['notificaciones'] = $this->Notificaciones_model->obtener_todas_las_notificaciones(); // Obtener las notificaciones

        // Cargar la vista admin_notificacion.php
        $this->load->view('admin_notificacion',     $data);
    }
   
    public function nuevanotificacion() {
        // Obtener todas las estaciones
        $data['estaciones'] = $this->Estacion_model->obtener_todas_las_estaciones();
        
        // Cargar la vista crearnotificacion y pasar los datos de las estaciones
        $this->load->view('crearnotificacion', $data); // Pasa las estaciones a la vista
    }


    public function guardarnotificacion() {
        $this->load->model('Notificaciones_model'); // Cargar el modelo existente
    
        // Recoger los datos del formulario
        $data = array(
            'estacion_id' => $this->input->post('id_estacion'),
            'nombrenotifi' => $this->input->post('nombrenotifi'),
            'titulo' => $this->input->post('titulo'),
            'mensaje' => $this->input->post('mensaje'),
            'imageUrl' => $this->input->post('imageUrl'),
            'imageWidth' => $this->input->post('imageWidth'),
            'imageHeight' => $this->input->post('imageHeight'),
            'colorFondo' => $this->input->post('colorFondo'),
            'colorBoton' => $this->input->post('colorBoton'),
            'intervalo' => $this->input->post('intervalo') // Agregar el intervalo
        );
        // Si es una alerta por ícono, ajustamos
        if ($this->input->post('tipoAlerta') === 'icon') {
            $data['imageUrl'] = null;
            $data['imageWidth'] = null;
            $data['imageHeight'] = null;
        }   
    
        // Guardar la notificación en la base de datos
        $this->Notificaciones_model->guardar_notificacion($data);
    
        redirect('welcome/notificacion');
    }
    

    public function obtener_notificacion($id) {
        $this->load->model('Notificacion_model');
        $notificacion = $this->Notificaciones_model->obtener_notificacion_por_id($id);
        echo json_encode($notificacion);
    }
    

    public function editarNotificacion($id) {
        // Obtener la notificación por ID
        $data['notificacion'] = $this->Notificaciones_model->obtener_notificacion_por_id($id);
        $data['estaciones'] = $this->Estacion_model->obtener_todas_las_estaciones();
    
        // Cargar la vista de creación, pero para editar
        $this->load->view('editarnotifi', $data);
    }
    
    public function actualizarNotificacion() {
        // Recoger los datos del formulario
        $data = array(
            'estacion_id' => $this->input->post('id_estacion'),
            'nombrenotifi' => $this->input->post('nombrenotifi'),
            'titulo' => $this->input->post('titulo'),
            'mensaje' => $this->input->post('mensaje'),
            'imageUrl' => $this->input->post('imageUrl'),
            'imageWidth' => $this->input->post('imageWidth'),
            'imageHeight' => $this->input->post('imageHeight'),
            'colorFondo' => $this->input->post('colorFondo'),
            'colorBoton' => $this->input->post('colorBoton'),
            'intervalo' => $this->input->post('intervalo')
        );
    
        // Si es una alerta por ícono, ajustamos
        if ($this->input->post('tipoAlerta') === 'icon') {
            $data['imageUrl'] = null;
            $data['imageWidth'] = null;
            $data['imageHeight'] = null;
        }
    
        // Actualizar la notificación en la base de datos
        $this->Notificaciones_model->actualizar_notificacion($this->input->post('id'), $data);
    
        redirect('welcome/notificacion');
    }
    
    public function eliminarNotificacion($id) {
        $this->load->model('Notificaciones_model');
        
        // Llamar al modelo para eliminar la notificación
        $this->Notificaciones_model->eliminar_notificacion($id);
        
        // Redirigir de vuelta a la lista de notificaciones
        redirect('welcome/notificacion');
    }
    
    

    //DEL PROYECTO ORIGNAL---------------------------------------------------------------
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

    
//AQUI TENGO LOS METODOS PARA PODER HACER USO DE LA BD

public function crear_notificacion() {
    $this->load->model('Notificaciones_model');

    // Obtener los datos del formulario
    $id_estacion = $this->input->post('id_estacion');
    $mensaje = $this->input->post('mensaje');
    $tipo = $this->input->post('tipo');
    $intervalo = $this->input->post('intervalo');

    // Insertar la nueva notificación
    $data = [
        'id_estacion' => $id_estacion,
        'mensaje' => $mensaje,
        'tipo' => $tipo,
        'intervalo' => $intervalo
    ];

    $this->Notificaciones_model->insertar_notificacion($data);
    redirect('welcome/notificacion'); // Redirigir a la página de notificaciones
}





}