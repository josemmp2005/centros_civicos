<?php
    namespace App\Controllers;
    use App\Models\Usuarios;
    use \Firebase\JWT\JWT;
    use \Firebase\JWT\Key;
    use \Exception;
    
    
    require_once "../bootstrap.php";
    class UsuariosController extends BaseController {
        public function IndexAction(){
            $data = array();
            $usuario = Usuarios::getInstancia();
            $usuarios = $usuario->getAll();
            $data['usuarios'] = $usuarios;
            $this->renderHTML('usuarios.php', $data);
        }

        public function GetAction($id=""){
            $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
            $data = array();
            $usuario = Usuarios::getInstancia();
            $usuario = $usuario->get($id);
            $data['usuario'] = $usuario;
            $this->renderHTML('get_usuario.php', $data);
        }

        public function EditAction(){
            $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
            
            if(isset($_POST["submit"])){
                $nombre = $_POST["nombre"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $usuario = Usuarios::getInstancia();
                $usuario->setNombre($nombre);
                $usuario->setEmail($email);
                $usuario->setPassword($password);
                $usuario->edit($id);
                header('Location: /usuarios');
            }
            $data = array();
            $usuario = Usuarios::getInstancia();
            $usuario = $usuario->get($id);
            $data['usuario'] = $usuario;
            $this->renderHTML('edit_usuario.php', $data);
        }

        public function DeleteAction(){
            $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
            $usuario = Usuarios::getInstancia();
            $usuario->delete($id);
            header('Location: /usuarios');   
        }

        public function AddAction(){
            if(isset($_POST["submit"])){
                $nombre = $_POST["nombre"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $usuario = Usuarios::getInstancia();
                $usuario->setNombre($nombre);
                $usuario->setEmail($email);
                $usuario->setPassword($password);
                $usuario->set();
                header('Location: /usuarios');
            }
            $this->renderHTML('add_usuario.php');
        }
        

        
    private $requestMethod;
    private $usuarioId;

    private $usuario;

    public function __construct($requestMethod, $usuariosId)
    {
        $this->requestMethod = $requestMethod;
        $this->instlacionesId = $usuariosId;
        $this->usuario = Usuarios::getInstancia();
    }

    /**
     * Funcion que procesa la peticion
     * return: Respuesta de la petición
     */


    public function processRequest(){

        // Conseguir el email mediante el token para identificar al usuario
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {

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
        }
        
        $this->usuarioId = explode('/',  $_SERVER['REQUEST_URI'])[3] ?? null; 
        

        $request = explode('/',  $_SERVER['REQUEST_URI'])[2];
        switch ($this->requestMethod) {
            case 'POST':
                if($request == "register"){
                    $response = $this->createUsuario();
                    break;
                }if($request == "token"){
                    $response = $this->tokenRefresh($email);
                    break;
                }
                $response = $this->notFoundResponse();
                break;
            case 'GET':
                $response = $this->getUsuario($email);
                break;
            case 'PUT':
                $response = $this->updateUsuario($email);
                break;
            case 'DELETE':
                $response = $this->deleteUsuario($email);
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

    private function createUsuario(){
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateUsuario($input)) {
            return $this->notFoundResponse();
        }
        $this->usuario->set($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;    
    }
    
    private function tokenRefresh($email){
        $key = KEY;
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; 
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => array(
                'email' => $email
            )
        );

        $jwt = JWT::encode($payload, $key, 'HS256');
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(array('token' => $jwt));
        return $response;
    }

    private function validateUsuario($input){
        if (!isset($input['nombre']) || !isset($input['email']) || !isset($input['password'])) {
            return false;
        }
        return true;
    }
    private function getUsuario($email){
        $result = $this->usuario->getByEmail($email);
   
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(value: $result->toArray());
        return $response;
    }

    private function deleteUsuario($email){
        $result = $this->usuario->deleteByEmail($email);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 204 No Content';
        $response['body'] = null;
        return $response;
    }
    
    private function updateUsuario($email) {
        $usuario = Usuarios::getInstancia()->getByEmail($email);
        if (!$usuario) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    
        $input['nombre'] = $input['nombre'] ?? $usuario->getNombre();
        $input['password'] = $input['password'] ?? $usuario->getPassword();
        $this->usuario->edit($input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }
    private function notFoundResponse(){
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

        
    } 
?>