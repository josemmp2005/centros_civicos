<?php

namespace App\Controllers;
use App\Models\CentrosCivicos;

class CentrosCivicosController extends BaseController {
    public function IndexAction(){
        $data = array();
        $centroCivico = CentrosCivicos::getInstancia();
        $centrosCivicos = $centroCivico->getAll();
        $data['centrosCivicos'] = $centrosCivicos;
        $this->renderHTML('centros_civicos.php', $data);
    }

    public function GetAction($id=""){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $data = array();
        $centroCivico = CentrosCivicos::getInstancia();
        $centroCivico = $centroCivico->get($id);
        // var_dump($centroCivico);
        $data['centroCivico'] = $centroCivico;
        $this->renderHTML('get_centro_civico.php', $data);
    }

    public function EditAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        
        if(isset($_POST["submit"])){
            $nombre = $_POST["nombre"];
            $direccion = $_POST["direccion"];
            $telefono = $_POST["telefono"];
            $horario = $_POST["horario"];
            $foto = $_POST["foto"];
            $centroCivico = CentrosCivicos::getInstancia();
            $centroCivico->setNombre($nombre);
            $centroCivico->setDireccion($direccion);
            $centroCivico->setTelefono($telefono);
            $centroCivico->setHorario($horario);
            $centroCivico->setFoto($foto);
            $centroCivico->edit($id);
            header(header: 'Location: /centrosCivicos');
        }
        $data = array();
        $centroCivico = CentrosCivicos::getInstancia();
        $centroCivico = $centroCivico->get($id);
        $data['centroCivico'] = $centroCivico;
        $this->renderHTML('edit_centro_civico.php', $data);
    }

    public function DeleteAction(){
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];
        $centroCivico = CentrosCivicos::getInstancia();
        $centroCivico->delete($id);
        header('Location: /centrosCivicos');   
    }

    public function AddAction(){
        if(isset($_POST["anadir"])){
            $nombre = $_POST["nombre"];
            $direccion = $_POST["direccion"];
            $telefono = $_POST["telefono"];
            $horario = $_POST["horario"];
            $foto = $_POST["foto"];
            $centroCivico = CentrosCivicos::getInstancia();
            $centroCivico->setNombre($nombre);
            $centroCivico->setDireccion($direccion);
            $centroCivico->setTelefono($telefono);
            $centroCivico->setHorario($horario);
            $centroCivico->setFoto($foto);
            $centroCivico->set();
            header('Location: /centrosCivicos');
        }else{
            $this->renderHTML('add_centro_civico.php');   
        }
    }


    // API

    private $requestMethod;
    private $contactosId;

    private $contactos;

    // Funcion que inicializa la clase y le pasa el metodo de la petición y el id del contacto
    public function __construct($requestMethod, $contactosId)
    {
        $this->requestMethod = $requestMethod;
        $this->contactosId = $contactosId;
        $this->contactos = CentrosCivicos::getInstancia();
    }

    /**
     * Funcion que procesa la peticion
     * return: Respuesta de la petición
     */

     // Funcion que procesa la peticion
    public function processRequest(){
        // Cojemos el id del contacto por la url
        $this->contactosId = explode('/',  $_SERVER['REQUEST_URI'])[3] ?? null;
        switch ($this->requestMethod) {
            case 'GET':
                // Si la petición es GET devolvemos el contacto o los contactos
                $response = $this->getCentroCivico($this->contactosId);
                break;
            default:
            // Si no es GET devolvemos un error
            $response = $this->notFoundResponse();
            break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    // Funcion que devuelve un contacto o todos los contactos
    private function getCentroCivico($id){
        if(!$id){
            // Si no hay id devolvemos todos los contactos
            $result = $this->contactos->getAll();
        }else{
            // Si hay id devolvemos el contacto con ese id
            $result = $this->contactos->get($id);
        }
        if (!$result) {
            // Si no hay resultado devolvemos un error
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        // Devolvemos el contacto o los contactos en formato json
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