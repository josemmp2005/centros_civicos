<?php
//Carga de archivos de configuración de la autocarga de clases
require('../vendor/autoload.php');

//Carga de archivos de configuración
require "../bootstrap.php";

// Importación de clases
use App\Core\Router;
use App\Controllers\CentrosCivicosController;
use App\Controllers\ActividadesController;
use App\Controllers\InscripcionesController;
use App\Controllers\InstalacionesController;
use App\Controllers\ReservasController;
use App\Controllers\UsuariosController;

// Creación de rutas
$router = new Router();

// Rutas Backend
// Rutas de Centros Civicos
$router->add(array(
    'name' => 'centrosCivicos',
    'path' => '/^\/centrosCivicos$/',
    'action' => [CentrosCivicosController::class, 'IndexAction'],
));
$router->add(array(
    'name' => 'centroCivico',
    'path' => '/^\/centroCivico\/\d+$/',
    'action' => [CentrosCivicosController::class, 'GetAction'],
));
$router->add(array(
    'name' => 'EliminarcentroCivico',
    'path' => '/^\/EliminarcentroCivico\/\d+$/',
    'action' => [CentrosCivicosController::class, 'DeleteAction'],
));
$router->add(array(
    'name' => 'AnadircentroCivico',
    'path' => '/^\/AnadircentroCivico$/',
    'action' => [CentrosCivicosController::class, 'AddAction'],
));
$router->add(array(
    'name' => 'EditarcentroCivico',
    'path' => '/^\/EditarcentroCivico\/\d+$/',
    'action' => [CentrosCivicosController::class, 'EditAction'],
));

// Rutas de Actividades
$router->add(array(
    'name' => 'actividades',
    'path' => '/^\/actividades$/',
    'action' => [ActividadesController::class, 'IndexAction'],
));
$router->add(array(
    'name' => 'actividad',
    'path' => '/^\/actividad\/\d+$/',
    'action' => [ActividadesController::class, 'GetAction'],
));
$router->add(array(
    'name' => 'Eliminaractividad',
    'path' => '/^\/Eliminaractividad\/\d+$/',
    'action' => [ActividadesController::class, 'DeleteAction'],
));
$router->add(array(
    'name' => 'Anadiractividad',
    'path' => '/^\/Anadiractividad$/',
    'action' => [ActividadesController::class, 'AddAction'],
));
$router->add(array(
    'name' => 'Editaractividad',
    'path' => '/^\/Editaractividad\/\d+$/',
    'action' => [ActividadesController::class, 'EditAction'],
));

// Rutas Inscripciones
$router->add(array(
    'name' => 'inscripciones',
    'path' => '/^\/inscripciones$/',
    'action' => [InscripcionesController::class, 'IndexAction'],
));
$router->add(array(
    'name' => 'inscripcion',
    'path' => '/^\/inscripcion\/\d+$/',
    'action' => [InscripcionesController::class, 'GetAction'],
));
$router->add(array(
    'name' => 'Eliminarinscripcion',
    'path' => '/^\/Eliminarinscripcion\/\d+$/',
    'action' => [InscripcionesController::class, 'DeleteAction'],
));
$router->add(array(
    'name' => 'Anadirinscripcion',
    'path' => '/^\/Anadirinscripcion$/',
    'action' => [InscripcionesController::class, 'AddAction'],
));
$router->add(array(
    'name' => 'Editarinscripcion',
    'path' => '/^\/Editarinscripcion\/\d+$/',
    'action' => [InscripcionesController::class, 'EditAction'],
));

// Rutas Instalaciones
$router->add(array(
    'name' => 'instalaciones',
    'path' => '/^\/instalaciones$/',
    'action' => [InstalacionesController::class, 'IndexAction'],
));
$router->add(array(
    'name' => 'instalacion',
    'path' => '/^\/instalacion\/\d+$/',
    'action' => [InstalacionesController::class, 'GetAction'],
));
$router->add(array(
    'name' => 'Eliminarinstalacion',
    'path' => '/^\/Eliminarinstalacion\/\d+$/',
    'action' => [InstalacionesController::class, 'DeleteAction'],
));
$router->add(array(
    'name' => 'Anadirinstalacion',
    'path' => '/^\/Anadirinstalacion$/',
    'action' => [InstalacionesController::class, 'AddAction'],
));
$router->add(array(
    'name' => 'Editarinstalacion',
    'path' => '/^\/Editarinstalacion\/\d+$/',
    'action' => [InstalacionesController::class, 'EditAction'],
));

// Rutas Reservas
$router->add(array(
    'name' => 'reservas',
    'path' => '/^\/reservas$/',
    'action' => [ReservasController::class, 'IndexAction'],
));
$router->add(array(
    'name' => 'reserva',
    'path' => '/^\/reserva\/\d+$/',
    'action' => [ReservasController::class, 'GetAction'],
));
$router->add(array(
    'name' => 'Eliminarreserva',
    'path' => '/^\/Eliminarreserva\/\d+$/',
    'action' => [ReservasController::class, 'DeleteAction'],
));
$router->add(array(
    'name' => 'Anadirreserva',
    'path' => '/^\/Anadirreserva$/',
    'action' => [ReservasController::class, 'AddAction'],
));
$router->add(array(
    'name' => 'Editarreserva',
    'path' => '/^\/Editarreserva\/\d+$/',
    'action' => [ReservasController::class, 'EditAction'],
));

// Rutas Usuarios
$router->add(array(
    'name' => 'usuarios',
    'path' => '/^\/usuarios$/',
    'action' => [UsuariosController::class, 'IndexAction'],
));
$router->add(array(
    'name' => 'usuario',
    'path' => '/^\/usuario\/\d+$/',
    'action' => [UsuariosController::class, 'GetAction'],
));
$router->add(array(
    'name' => 'Eliminarusuario',
    'path' => '/^\/Eliminarusuario\/\d+$/',
    'action' => [UsuariosController::class, 'DeleteAction'],
));
$router->add(array(
    'name' => 'Anadirusuario',
    'path' => '/^\/Anadirusuario$/',
    'action' => [UsuariosController::class, 'AddAction'],
));
$router->add(array(
    'name' => 'Editarusuario',
    'path' => '/^\/Editarusuario\/\d+$/',
    'action' => [UsuariosController::class, 'EditAction'],
));


// Obtiene la solicitud actual
$request =  $_SERVER['REQUEST_URI']; 

//Debemos declarar estas variables para poder reutilizar los medelos para la API
$request_method="";
$contactosId="";
// Busca la ruta correspondiente a la solicitud
$route = $router->match(request: $request);
if ($route) {
    // Si la ruta existe, se ejecuta el controlador y acción correspondientes
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName($request_method, $contactosId); // Pasar los argumentos necesarios
    $controller->$actionName($request);

} else {
    // Si no se encuentra la ruta, muestra un mensaje de error
    echo "No route";
}