<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// config/routes.php

//$route['default_controller'] = 'usuarios'; // Controlador por defecto

// Rutas para el controlador de Usuarios
$route['usuarios'] = 'usuarios/index'; // Listar usuarios
$route['usuarios/agregar'] = 'usuarios/agregar'; // Formulario para agregar usuario
$route['usuarios/guardar'] = 'usuarios/guardar'; // Acción para guardar un nuevo usuario
$route['usuarios/editar/(:any)'] = 'usuarios/editar/$1'; // Formulario para editar usuario con ID
$route['usuarios/actualizar/(:any)'] = 'usuarios/actualizar/$1'; // Acción para actualizar un usuario con ID
$route['usuarios/eliminar/(:any)'] = 'usuarios/eliminar/$1'; // Acción para eliminar usuario con ID
$route['login'] = 'auth_controller/login'; // Ruta para la página de login
$route['login/process'] = 'auth_controller/process'; // Ruta para procesar el login
$route['logout'] = 'auth_controller/logout'; // Ruta para cerrar sesión
