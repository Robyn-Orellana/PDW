<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Estacion_model');  // Cargar el modelo
    }
	public function index()
	{
		$this->load->view('welcome_message');
		
	}

    public function agregar()
    {
        // Aquí puedes cargar una vista o manejar la lógica para agregar una nueva estación
        $this->load->view('agregar_estacion');
    }

	public function guardar() {
        // Capturar los datos del formulario
        $data = array(
            'numero_estacion' => $this->input->post('numero_estacion'),
            'nombre_cliente' => $this->input->post('nombre_cliente'),
            'tiempo_solicitado' => $this->input->post('tiempo_solicitado'),
            'tiempo_libre' => $this->input->post('tiempo_libre') ? 1 : 0,  // Si está marcado, es 1; si no, es 0
            'fecha' => $this->input->post('fecha')
        );

        // Enviar los datos al modelo para guardarlos en la base de datos
        if ($this->Estacion_model->guardar_estacion($data)) {
            // Si la inserción fue exitosa, redirigir a la página de éxito o principal
            redirect('welcome');
        } else {
            // Si hubo un error, mostrar un mensaje de error
            echo "Hubo un problema al guardar la estación.";
        }
    }
}
