<?php

namespace App\Models;

class Actividades extends DBAbstractModel
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
    private $centro_id;
    private $nombre;
    private $descripcion;
    private $fecha_inicio;
    private $fecha_final;
    private $horario;
    private $plazas;

    // Getters y Setters
    public function getId()
    {
        return $this->id;
    }
    public function getCentroId()
    {
        return $this->centro_id;
    }
    public function setCentroId($centro_id)
    {
        $this->centro_id = $centro_id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }
    public function getFechaFinal()
    {
        return $this->fecha_final;
    }
    public function setFechaFinal($fecha_final)
    {
        $this->fecha_final = $fecha_final;
    }
    public function getHorario()
    {
        return $this->horario;
    }
    public function setHorario($horario)
    {
        $this->horario = $horario;
    }
    public function getPlazas()
    {
        return $this->plazas;
    }
    public function setPlazas($plazas)
    {
        $this->plazas = $plazas;
    }

    // CRUD
    public function get($id="") 
    {
        $this->query = "SELECT * FROM actividades WHERE id = :id";
        $this->parametros["id"] = $id;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Actividad encontrada';
        } else {
            $this->mensaje = 'Actividad no encontrada';
        }
        return $this->rows[0] ?? null;
    }
    
    public function set()
    {
        $this->query = "INSERT INTO actividades(centro_id, nombre, descripcion, fecha_inicio, fecha_final, horario, plazas) VALUES (:centro_id, :nombre, :descripcion, :fecha_inicio, :fecha_final, :horario, :plazas)";
        $this->parametros['centro_id'] = $this->centro_id;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['fecha_inicio'] = $this->fecha_inicio;
        $this->parametros['fecha_final'] = $this->fecha_final;
        $this->parametros['horario'] = $this->horario;
        $this->parametros['plazas'] = $this->plazas;
        $this->get_results_from_query();
        $this->mensaje = 'Actividad añadida';
        return $this->rows;
    }

    public function edit($id="")
    {
        $this->query="UPDATE actividades SET centro_id=:centro_id, nombre=:nombre, descripcion=:descripcion, fecha_inicio=:fecha_inicio, fecha_final=:fecha_final, horario=:horario, plazas=:plazas WHERE id=:id";
        $this->parametros['id'] = $id;
        $this->parametros['centro_id'] = $this->centro_id;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['fecha_inicio'] = $this->fecha_inicio;
        $this->parametros['fecha_final'] = $this->fecha_final;
        $this->parametros['horario'] = $this->horario;
        $this->parametros['plazas'] = $this->plazas;
        $this->get_results_from_query();
        $this->mensaje = 'Actividad modificada';
        var_dump($this->rows);
        return $this->rows;
    }
    public function delete($id="")
    {
        $this->query = "DELETE FROM actividades WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Actividad eliminada';
        return $this->rows;
    }

    public function getAll()
    {
        $this->query = "SELECT * FROM actividades";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getNumeroPlazas($id=""){
        $this->query = "SELECT plazas FROM actividades WHERE id = :actividad_id";
        $this->parametros['actividad_id'] = $id;
        $this->get_results_from_query();
        return $this->rows[0]['plazas'];
    }
}