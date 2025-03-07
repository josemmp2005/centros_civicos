<?php

namespace App\Controllers;
use App\Models\Reservas;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \App\Models\Usuarios;
use \Exception;

class ReservasController extends BaseController{
    public function IndexAction(){
        $data = array();
        $reserva = Reservas::getInstancia();
        $reservas = $reserva->getAll();
        $data['reservas'] = $reservas;
        $this->renderHTML('reservas.php', $data);
    }

    public function GetAction($id=""){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $data = array();
        $reserva = Reservas::getInstancia();
        $reserva = $reserva->get($id);
        // var_dump($reserva);
        $data['reserva'] = $reserva;
        $this->renderHTML('get_reserva.php', $data);
    }

    public function EditAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        
        if(isset($_POST["submit"])){
            $solicitante = $_POST["solicitante"];
            $telefono = $_POST["telefono"];
            $email = $_POST["email"];
            $instalacion_id = $_POST["instalacion_id"];
            $fecha_inicio = $_POST["fecha_inicio"];
            $fecha_final = $_POST["fecha_final"];
            $estado = $_POST["estado"];
            $reserva = Reservas::getInstancia();
            $reserva->setSolicitante($solicitante);
            $reserva->setTelefono($telefono);
            $reserva->setEmail($email);
            $reserva->setInstalacionId($instalacion_id);
            $reserva->setFechaInicio($fecha_inicio);
            $reserva->setFechaFinal($fecha_final);
            $reserva->setEstado($estado);
            $reserva->edit($id);
            header('Location: /reservas');
        }
        $data = array();
        $reserva = Reservas::getInstancia();
        $reserva = $reserva->get($id);
        $data['reserva'] = $reserva;
        $this->renderHTML('edit_reserva.php', $data);
    }

    public function DeleteAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $reserva = Reservas::getInstancia();
        $reserva->delete($id);
        header('Location: /reservas');   
    }

    public function AddAction(){
        if(isset($_POST["submit"])){
            $solicitante = $_POST["solicitante"];
            $telefono = $_POST["telefono"];
            $email = $_POST["email"];
            $instalacion_id = $_POST["instalacion_id"];
            $fecha_inicio = $_POST["fecha_inicio"];
            $fecha_final = $_POST["fecha_final"];
            $estado = $_POST["estado"];
            $reserva = Reservas::getInstancia();
            $reserva->setSolicitante($solicitante);
            $reserva->setTelefono($telefono);
            $reserva->setEmail($email);
            $reserva->setInstalacionId($instalacion_id);
            $reserva->setFechaInicio($fecha_inicio);
            $reserva->setFechaFinal($fecha_final);
            $reserva->setEstado($estado);
            $reserva->set();        }
        $this->renderHTML('add_reserva.php');
    }

    private $requestMethod;
    private $reservaId;

    private $reserva;

    public function __construct($requestMethod, $reservasId)
    {
        $this->requestMethod = $requestMethod;
        $this->instlacionesId = $reservasId;
        $this->reserva = Reservas::getInstancia();
    }

    /**
     * Funcion que procesa la peticion
     * return: Respuesta de la petición
     */


    public function processRequest(){
        $headers = apache_request_headers();
        if (!isset($headers['Authorization'])) {
            return $this->notFoundResponse();
        }
        $jwt = str_replace('Bearer ', '', $headers['Authorization']);
        $key = KEY; // Clave de encriptación
        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            $decoded_array = (array) $decoded;
            $email = $decoded_array['data']->email;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['mensaje' => 'Token inválido', 'error' => $e->getMessage()]);
            exit();
        }
        $this->reservaId = explode('/',  $_SERVER['REQUEST_URI'])[3] ?? null; 
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->createReserva($email);
                break;
            case 'GET':
                $response = $this->getReserva($email);
                break;
            case 'DELETE':
                $response = $this->deleteReserva($this->reservaId, $email);
                break;  
            default:
            $response = $this->notFoundResponse();
            break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
    private function createReserva($email){
        $usuario = Usuarios::getInstancia()->getByEmail($email);
        $id = $usuario->getId();
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateReserva($input)) {
            return $this->notFoundResponse();
        }
        $input['usuario_id'] = $id;
        $this->reserva->set($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;    
    }
    private function validateReserva($input){
        if (!isset($input['solicitante']) || !isset($input['telefono']) || !isset($input['email']) || !isset($input['instalacion_id']) || !isset($input['fecha_inicio']) || !isset($input['fecha_final']) || !isset($input['estado'])) {
            return false;
        }
        return true;
    }
    private function getReserva($email){
        $usuario = Usuarios::getInstancia()->getByEmail($email);
        $id = $usuario->getId();
        $result = $this->reserva->getReservasByUserId($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
    
    private function deleteReserva($id, $email){
        $usuario = Usuarios::getInstancia()->getByEmail($email);
        $user_id = $usuario->getId();
    
        // Verificar si la reserva existe y pertenece al usuario autenticado
        $reserva = $this->reserva->get($id);
        if (!$reserva || $reserva->getUsuarioId() != $user_id) {
            return $this->notFoundResponse();
        }
    
        // Eliminar la reserva
        $this->reserva->delete($id);
        
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(["mensaje" => "Reserva eliminada correctamente"]);
        return $response;
    }
    
    private function notFoundResponse(){
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

}