<?php

namespace App\Controllers;
use App\Models\Actividades;

class ActividadesController extends BaseController{
    public function IndexAction(){
        $data = array();
        $actividad = Actividades::getInstancia();
        $actividades = $actividad->getAll();
        $data['actividades'] = $actividades;
        $this->renderHTML('actividades.php', $data);
    }

    public function GetAction($id=""){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $data = array();
        $actividad = Actividades::getInstancia();
        $actividad = $actividad->get($id);
        // var_dump($actividad);
        $data['actividad'] = $actividad;
        $this->renderHTML('get_actividad.php', $data);
    }

    public function EditAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        
        if(isset($_POST["submit"])){
            $centro_id = $_POST["centro_id"];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $fecha_inicio = $_POST["fecha_inicio"];
            $fecha_final = $_POST["fecha_final"];
            $horario = $_POST["horario"];
            $plazas = $_POST["plazas"];
            $actividad = Actividades::getInstancia();
            $actividad->setCentroId($centro_id);
            $actividad->setNombre($nombre);
            $actividad->setDescripcion($descripcion);
            $actividad->setFechaInicio($fecha_inicio);
            $actividad->setFechaFinal($fecha_final);
            $actividad->setHorario($horario);
            $actividad->setPlazas($plazas);
            $actividad->edit($id);
            // header('Location: /actividades');
        }
        $data = array();
        $actividad = Actividades::getInstancia();
        $actividad = $actividad->get($id);
        $data['actividad'] = $actividad;
        $this->renderHTML('edit_actividad.php', $data);
    }

    public function DeleteAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $actividad = Actividades::getInstancia();
        $actividad->delete($id);
        header('Location: /actividades');   
    }

    public function AddAction(){
        if(isset($_POST["anadir"])){
            $centro_id = $_POST["centro_id"];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $fecha_inicio = $_POST["fecha_inicio"];
            $fecha_final = $_POST["fecha_final"];
            $horario = $_POST["horario"];
            $plazas = $_POST["plazas"];
            $actividad = Actividades::getInstancia();
            $actividad->setCentroId($centro_id);
            $actividad->setNombre($nombre);
            $actividad->setDescripcion($descripcion);
            $actividad->setFechaInicio($fecha_inicio);
            $actividad->setFechaFinal($fecha_final);
            $actividad->setHorario($horario);
            $actividad->setPlazas($plazas);
            $actividad->set();
            header('Location: /actividades');
        }
        $this->renderHTML('add_actividad.php');
    }


    // API REST
    private $requestMethod;
    private $actividadId;

    private $instalacion;


    // Funcion que inicializa la clase y le pasa el metodo de la petición y el id del contacto
    public function __construct($requestMethod, $actividadesId)
    {
        $this->requestMethod = $requestMethod;
        $this->instlacionesId = $actividadesId;
        $this->instalacion = Actividades::getInstancia();
    }

    /**
     * Funcion que procesa la peticion
     * return: Respuesta de la petición
     */


    // Funcion que procesa la peticion
    public function processRequest(){
        // Cojemos el id del usuario por la url
        $this->actividadId = explode('/',  $_SERVER['REQUEST_URI'])[3] ?? null; 
        // Dependiendo del metodo de la petición hacemos una acción u otra
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getActividad($this->actividadId);
                break;  
            default:
            // Si no se soporta el metodo de la petición devolvemos un error
            $response = $this->notFoundResponse();
            break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    // Funcion que devuelve una respuesta con el usuario
    private function getActividad($id){
        if(!$id){
            // Si no hay id devolvemos todos los usuarios
            $result = $this->instalacion->getAll();
        }else{  
            // Si hay id devolvemos el usuario con ese id
            $result = $this->instalacion->get($id);
        }
        if (!$result) {
            // Si no hay resultado devolvemos un error
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        // Devolvemos el resultado en formato json
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

?>