<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\CitaController;
use Controllers\APIController;
use Controllers\AdminController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

// Iniciar Sesion
$router->get( '/', [LoginController::class, 'login'] );
$router->post( '/', [LoginController::class, 'login'] );
$router->get( '/logout', [LoginController::class, 'logout'] );

// Recuperar Passwrod
$router->get( '/forget', [LoginController::class, 'forget'] );
$router->post( '/forget', [LoginController::class, 'forget'] );
$router->get( '/recover', [LoginController::class, 'recover'] );
$router->post( '/recover', [LoginController::class, 'recover'] );

// Crear cuentas
$router->get( '/register', [LoginController::class, 'register'] );
$router->post( '/register', [LoginController::class, 'register'] );

// Confirmar cuenta cuentas
$router->get( '/confirm', [LoginController::class, 'confirm'] );
$router->get( '/mensaje', [LoginController::class, 'mensaje'] );

// Zona Privada
$router->get( '/cita', [CitaController::class, 'index'] );
$router->get( '/admin', [AdminController::class, 'index'] );

// API de Citas
$router->get( '/api/servicios', [APIController::class, 'index'] );
$router->post( '/api/citas', [APIController::class, 'guardar'] );
$router->post( '/api/eliminar', [APIController::class, 'eliminar'] );

// CRUD de servicios
$router->get( '/servicios', [ServicioController::class, 'index'] );
$router->get( '/servicios/crear', [ServicioController::class, 'crear'] );
$router->post( '/servicios/crear', [ServicioController::class, 'crear'] );
$router->get( '/servicios/actualizar', [ServicioController::class, 'actualizar'] );
$router->post( '/servicios/actualizar', [ServicioController::class, 'actualizar'] );
$router->post( '/servicios/eliminar', [ServicioController::class, 'eliminar'] );


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();