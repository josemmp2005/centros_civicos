<?php

namespace App\Models;

class Inscripciones extends DBAbstractModel
{
    private static $instancia;

    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    public function __construct()
    {
    }
    private $id;
    private $solicitante;
    private $telefono;
    private $email;
    private $actividad_id;
    private $fecha_inscripcion;
    private $estado;
    private $usuario_id;

    // Getters y Setters
    public function getId()
    {
        return $this->id;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }
    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }


    public function getSolicitante()
    {
        return $this->solicitante;
    }
    public function setSolicitante($solicitante)
    {
        $this->solicitante = $solicitante;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getActividadId()
    {
        return $this->actividad_id;
    }
    public function setActividadId($actividad_id)
    {
        $this->actividad_id = $actividad_id;
    }
    public function getFechaInscripcion()
    {
        return $this->fecha_inscripcion;
    }
    public function setFechaInscripcion($fecha_inscripcion)
    {
        $this->fecha_inscripcion = $fecha_inscripcion;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    

    //CRUD vacio
    public function get($id=""){
        $this->query = "SELECT * FROM inscripciones WHERE id = :id";
        $this->parametros["id"] = $id;
        $this->get_results_from_query();
        var_dump($this->rows);
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Inscripción encontrada';
            return $this;
        } else {
            $this->mensaje = 'Inscripción no encontrada';
        }
        return null;
    }

    public function set($input=array()){
        $numeroPlazas = Actividades::getInstancia()->getNumeroPlazas($input["actividad_id"]);
        $numeroInscripciones = $this->getNumeroInscripciones($input["actividad_id"]);

        if($numeroInscripciones >= $numeroPlazas){
            return false;
        }

        $this->query = "INSERT INTO inscripciones(usuario_id, solicitante, telefono, email, actividad_id, fecha_inscripcion, estado) VALUES (:usuario_id, :solicitante, :telefono, :email, :actividad_id, :fecha_inscripcion, :estado)";
        $this->parametros['usuario_id'] = $input['usuario_id'];
        $this->parametros['solicitante'] = $input['solicitante'];
        $this->parametros['telefono'] = $input['telefono'];
        $this->parametros['email'] = $input['email'];
        $this->parametros['actividad_id'] = $input['actividad_id'];
        $this->parametros['fecha_inscripcion'] = $input['fecha_inscripcion'];
        $this->parametros['estado'] = $input['estado'];
        $this->get_results_from_query();
        $this->mensaje = 'Inscripción agregada';
        return $this->rows;
    }

    public function edit($id="")
    {
        $this->query = "UPDATE inscripciones SET solicitante = :solicitante, telefono = :telefono, email = :email, actividad_id = :actividad_id, fecha_inscripcion = :fecha_inscripcion, estado = :estado WHERE id = :id";
        $this->parametros['solicitante'] = $this->solicitante;
        $this->parametros['telefono'] = $this->telefono;
        $this->parametros['email'] = $this->email;
        $this->parametros['actividad_id'] = $this->actividad_id;
        $this->parametros['fecha_inscripcion'] = $this->fecha_inscripcion;
        $this->parametros['estado'] = $this->estado;
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Inscripcion modificada';
        return $this->rows;
    }
    public function delete($id="")
    {
        $this->query = "DELETE FROM inscripciones WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Inscripcion eliminada';
        return $this->rows;
    }

    public function getAll()
    {
        $this->query = "SELECT * FROM inscripciones";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getNumeroInscripciones($id){
        $this->query = "SELECT COUNT(*) as inscripciones FROM inscripciones WHERE actividad_id = :actividad_id";
        $this->parametros['actividad_id'] = $id;
        $this->get_results_from_query();
        return $this->rows[0]['inscripciones'];
    }
        
    public function getInscripcionesByUserId($usuario_id = ""){
        $this->query = "SELECT * FROM inscripciones WHERE usuario_id = :usuario_id";
        $this->parametros['usuario_id'] = $usuario_id;
        $this->get_results_from_query();
        return $this->rows;
    
    }
}