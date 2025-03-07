<?php

namespace App\Controllers;
use App\Models\Instalaciones;

class InstalacionesController extends BaseController{
    public function IndexAction(){
        $data = array();
        $instalacion = Instalaciones::getInstancia();
        $instalaciones = $instalacion->getAll();
        $data['instalaciones'] = $instalaciones;
        $this->renderHTML('instalaciones.php', $data);
    }

    public function GetAction($id=""){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $data = array();
        $instalacion = Instalaciones::getInstancia();
        $instalacion = $instalacion->get($id);
        // var_dump($instalacion);
        $data['instalacion'] = $instalacion;
        $this->renderHTML('get_instalacion.php', $data);
    }

    public function EditAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        
        if(isset($_POST["submit"])){
            $centro_id = $_POST["centro_id"];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $capacidad_max = $_POST["capacidad_max"];
            $instalacion = Instalaciones::getInstancia();
            $instalacion->setCentroId($centro_id);
            $instalacion->setNombre($nombre);
            $instalacion->setDescripcion($descripcion);
            $instalacion->setCapacidadMax($capacidad_max);
            $instalacion->edit($id);
            header(header: 'Location: /instalaciones');
        }
        $data = array();
        $instalacion = Instalaciones::getInstancia();
        $instalacion = $instalacion->get($id);
        $data['instalacion'] = $instalacion;
        $this->renderHTML('edit_instalacion.php', $data);
    }

    public function DeleteAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $instalacion = Instalaciones::getInstancia();
        $instalacion->delete($id);
        header('Location: /instalaciones');   
    }

    public function AddAction(){
        if(isset($_POST["anadir"])){
            $centro_id = $_POST["centro_id"];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $capacidad_max = $_POST["capacidad_max"];
            $instalacion = Instalaciones::getInstancia();
            $instalacion->setCentroId($centro_id);
            $instalacion->setNombre($nombre);
            $instalacion->setDescripcion($descripcion);
            $instalacion->setCapacidadMax($capacidad_max);
            $instalacion->set();
            header('Location: /instalaciones');
        }
        $this->renderHTML('add_instalacion.php');
    }


    private $requestMethod;
    private $instalacionId;

    private $instalacion;

    public function __construct($requestMethod, $instlacionesId)
    {
        $this->requestMethod = $requestMethod;
        $this->instlacionesId = $instlacionesId;
        $this->instalacion = Instalaciones::getInstancia();
    }

    /**
     * Funcion que procesa la peticion
     * return: Respuesta de la petición
     */


    // Funcion que procesa la peticion
    public function processRequest(){
        // Cojemos el id de la instalación por la url
        $this->instalacionId = explode('/',  $_SERVER['REQUEST_URI'])[3] ?? null; 
        switch ($this->requestMethod) {
            case 'GET':
                // Devolvemos la instalación
                $response = $this->getInstalacion($this->instalacionId);
                break;  
            default:
            // Si no se encuentra la petición devolvemos un error
            $response = $this->notFoundResponse();
            break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    // Funcion que devuelve la instalación
    private function getInstalacion($id){
        if(!$id){
            // Si no hay id devolvemos todas las instalaciones
            $result = $this->instalacion->getAll();
        }else{  
            // Si hay id devolvemos la instalación
            $result = $this->instalacion->get($id);
        }
        if (!$result) {
            // Si no hay resultado devolvemos un error
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    // Funcion que devuelve un error
    private function notFoundResponse(){
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

} 
