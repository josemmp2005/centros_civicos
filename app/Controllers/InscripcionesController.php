<?php

namespace App\Controllers;
use App\Models\Inscripciones;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \App\Models\Usuarios;
use \Exception;

class InscripcionesController extends BaseController{
    public function IndexAction(){
        $data = array();
        $inscripcion = Inscripciones::getInstancia();
        $inscripciones = $inscripcion->getAll();
        $data['inscripciones'] = $inscripciones;
        $this->renderHTML('inscripciones.php', $data);
    }

    public function GetAction($id=""){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $data = array();
        $inscripcion = Inscripciones::getInstancia();
        $inscripcion = $inscripcion->get($id);
        $data['inscripcion'] = $inscripcion;
        $this->renderHTML('get_inscripcion.php', $data);
    }

    public function EditAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        
        if(isset($_POST["submit"])){
            $solicitante = $_POST["solicitante"];
            $telefono = $_POST["telefono"];
            $email = $_POST["email"];
            $fecha_inscripcion = $_POST["fecha_inscripcion"];
            $estado = $_POST["estado"];
            $actividad_id = $_POST["actividad_id"];
            $inscripcion = Inscripciones::getInstancia();
            $inscripcion->setSolicitante($solicitante);
            $inscripcion->setTelefono($telefono);
            $inscripcion->setEmail($email);
            $inscripcion->setFechaInscripcion($fecha_inscripcion);
            $inscripcion->setEstado($estado);
            $inscripcion->setActividadId($actividad_id);
            $inscripcion->edit($id);
            header(header: 'Location: /inscripciones');
        }
        $data = array();
        $inscripcion = Inscripciones::getInstancia();
        $inscripcion = $inscripcion->get($id);
        $data['inscripcion'] = $inscripcion;
        $this->renderHTML('edit_inscripcion.php', $data);
    }

    public function DeleteAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $inscripcion = Inscripciones::getInstancia();
        $inscripcion->delete($id);
        header('Location: /inscripciones');   
    }

    public function AddAction(){
        if(isset($_POST["anadir"])){
            $solicitante = $_POST["solicitante"];
            $telefono = $_POST["telefono"];
            $email = $_POST["email"];
            $fecha_inscripcion = $_POST["fecha_inscripcion"];
            $estado = $_POST["estado"];
            $actividad_id = $_POST["actividad_id"];
            $inscripcion = Inscripciones::getInstancia();
            $inscripcion->setSolicitante($solicitante);
            $inscripcion->setTelefono($telefono);
            $inscripcion->setEmail($email);
            $inscripcion->setFechaInscripcion($fecha_inscripcion);
            $inscripcion->setEstado($estado);
            $inscripcion->setActividadId($actividad_id);
            $inscripcion->set();
            header('Location: /inscripciones');
        }
        $this->renderHTML('add_inscripcion.php');
    }

    
    private $requestMethod;
    private $inscripcionId;

    private $inscripcion;

    // Funcion que inicializa la clase y le pasa el metodo de la petición y el id del contacto
    public function __construct($requestMethod, $inscripcionId)
    {
        $this->requestMethod = $requestMethod;
        $this->inscripcionId = $inscripcionId;
        $this->inscripcion = Inscripciones::getInstancia();
    }

    /**
     * Funcion que procesa la peticion
     * return: Respuesta de la petición
     */


    // Funcion que procesa la peticion
    public function processRequest(){
        // Conseguir el id del usuario mediante la URL
        $this->usuarioId = explode('/',  $_SERVER['REQUEST_URI'])[3] ?? null; 
        
        // Conseguir el email mediante el token para identificar al usuario
        // Comprobamos si el token está en la cabecera
        $headers = apache_request_headers();
        // Si no está el token en la cabecera, devolvemos un error
        if (!isset($headers['Authorization'])) {
            return $this->notFoundResponse();
        }
        // Si está el token en la cabecera, lo almacenamos en la variable $jwt
        $jwt = str_replace('Bearer ', '', $headers['Authorization']);
        // Guardamos la key de descifrado
        $key = KEY; 
        // Desciframos el token para conseguir el email del usuario
        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            $decoded_array = (array) $decoded;
            $email = $decoded_array['data']->email;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['mensaje' => 'Token inválido', 'error' => $e->getMessage()]);
            exit();
        }
        // Cojemos el id de la inscripción por la url
        $this->inscripcionId = explode('/',  $_SERVER['REQUEST_URI'])[3] ?? null; 
        switch ($this->requestMethod) {
            case 'GET':
                // Si la petición es GET devolvemos una inscripción
                $response = $this->getInscripcion($email);
                break;
            case 'POST':
                // Si la petición es POST creamos una inscripción
                $response = $this->createInscripcion($email);
                break;
            case 'DELETE':
                // Si la petición es DELETE eliminamos una inscripción
                $response = $this->deleteInscripcion($this->inscripcionId, $email);
                break;  
            default:
            // Si no es POST ni DELETE devolvemos un error
            $response = $this->notFoundResponse();
            break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    // Funcion que crea una inscripción 
    private function getInscripcion($email){
        $usuario = Usuarios::getInstancia()->getByEmail($email);
        $id = $usuario->getId();
        $result = $this->inscripcion->getInscripcionesByUserId($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createInscripcion($email){
        // Cojemos el usuario por el email
        $usuario = Usuarios::getInstancia()->getByEmail($email);
        // Guardamos el id del usaurio
        $id = $usuario->getId();
        // Guardamos el cuerpo de la petición en la variable $input
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        // Si el cuerpo de la petición no es válido devolvemos un error
        if (!$this->validateInscripcion($input)) {
            return $this->notFoundResponse();
        }
        // Guardamos el id del usuario en el cuerpo de la petición
        $input['usuario_id'] = $id;
        // Creamos la inscripción
        $this->inscripcion->set($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;    
    }

    // Funcion que valida el cuerpo de la petición
    private function validateInscripcion($input){
        if (!isset($input['solicitante']) || !isset($input['telefono']) || !isset($input['email']) || !isset($input['actividad_id']) || !isset($input['fecha_inscripcion']) || !isset($input['estado'])) {
            return false;
        }
        return true;
    }

    // Funcion que elimina una inscripción
    private function deleteInscripcion($id, $email){
        $usuario = Usuarios::getInstancia()->getByEmail($email);
        $user_id = $usuario->getId();
    
        // Verificar si la inscripción existe y pertenece al usuario autenticado
        $inscripcion = $this->inscripcion->get($id);
        if (!$inscripcion || $inscripcion->getUsuarioId() != $user_id) {
            return $this->notFoundResponse();
        }
    
        // Eliminar la inscripción
        $this->inscripcion->delete($id);
        
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(["mensaje" => "Inscripción eliminada correctamente"]);
        return $response;
    }
    
    // Funcion que devuelve un error
    private function notFoundResponse(){
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

}
