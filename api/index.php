<?php
// 
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
use App\Controllers\AuthController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//API
// Ponemos las cabeceras

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

// Manejar solicitudes OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$request_method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_METHOD'];

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $request);

// Si existe recuperamos el id
$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

if ($request == '/api/login' || $request == '/api/login/') {
    $auth = new AuthController($request_method);
    if (!$auth->LoginFromRequest()) {
        http_response_code(401);
        echo json_encode(["message" => "Credenciales incorrectas"]);
        exit();
    }
}


// Decodificamos el token
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

// Inicializamos el token como null
$jwt = null;

// Verificamos si el header tiene el formato correcto
if (!empty($authHeader)) {
    $arr = explode(" ", $authHeader);
    if (count($arr) === 2 && strtolower($arr[0]) === 'bearer') {
        $jwt = $arr[1];
    }
}

$auth = false;

if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, new Key(KEY, 'HS256'));
        $auth = true;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode([
            "message" => "Acceso denegado",
            "error" => $e->getMessage()
        ]);
        exit();
    }
}

$router = new Router();

// Peticion
// Definimos rutas válidas
// Tenemos en cuenta que una misma ruta ejecuta distintas acciones
$router->add(array(
    "name" => "register",
    "path" => "/^\/api\/register$/",
    "action" => UsuariosController::class,
    "public" => true
));
$router->add(array(
    "name" => "token_refresh",
    "path" => "/^\/api\/token\/refresh$/",
    "action" => UsuariosController::class,
    "public" => false
));
$router->add(array(
    "name" => "user_control",
    "path" => "/^\/api\/user$/",
    "action" => UsuariosController::class,
    "public" => false
));

$router->add(array(
    "name" => "centrosCivicos",
    "path" => "/^\/api\/centros(\/[0-9]+)?$/",
    "action" => CentrosCivicosController::class,
    "public" => true
));
$router->add(array(
    "name" => "instalaciones_centro_civico",
    "path" => "/^\/api\/(centros\/\d+\/)?instalaciones$/",
    "action" => InstalacionesController::class,
    "public" => true
));

$router->add(array(
    "name" => "actividades_centro_civico",
    "path" => "/^\/api\/(centros\/\d+\/)?actividades$/",
    "action" => ActividadesController::class,
    "public" => true
));
$router->add(array(
    "name" => "reserva",
    "path" => "/^\/api\/reservas(\/\d+)?$/",
    "action" => ReservasController::class,
    "public" => false
));

$router->add(array(
    "name" => "nueva_inscripcion",
    "path" => "/^\/api\/inscripciones(\/\d+)?$/",
    "action" => InscripcionesController::class,
    "public" => false
));

$route = $router->match($request);
if ($route){
    $controllerName = $route['action'];
    $controller = new $controllerName($request_method, $userId);
    if($route['public'] == false && !$auth){
        echo json_encode(array(
            "message" => "Acceso denegado"
        ));
        exit(http_response_code(401));
    }
    $controller->processRequest();
} else{
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    echo json_encode($response);
}

