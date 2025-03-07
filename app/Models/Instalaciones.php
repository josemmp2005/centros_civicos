<?php

namespace App\Models;

class Instalaciones extends DBAbstractModel{
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
    private $capacidad_max;

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
    public function getCapacidadMax()
    {
        return $this->capacidad_max;
    }
    public function setCapacidadMax($capacidad_max)
    {
        $this->capacidad_max = $capacidad_max;
    }

    // CRUD 
    public function get($id="")
    {
        $this->query = "SELECT id, centro_id, nombre, descripcion, capacidad_max FROM instalaciones WHERE id = :id";
        $this->parametros["id"] = $id;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Instalaciones encontrada';
        } else {
            $this->mensaje = 'Instalaciones no encontrada';
        }
        return $this->rows[0] ?? null;
    }

    public function set()
    {
        $this->query = "INSERT INTO instalaciones(centro_id, nombre, descripcion, capacidad_max) VALUES (:centro_id, :nombre, :descripcion, :capacidad_max)";
        $this->parametros['centro_id'] = $this->centro_id;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['capacidad_max'] = $this->capacidad_max;
        $this->get_results_from_query();
        $this->mensaje = 'Instalaciones agregada';
        return $this->rows;
    }
    public function edit($id = '')
    {
        $this->query = "UPDATE instalaciones SET centro_id = :centro_id, nombre = :nombre, descripcion = :descripcion, capacidad_max = :capacidad_max WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['centro_id'] = $this->centro_id;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['capacidad_max'] = $this->capacidad_max;
        $this->get_results_from_query();
        $this->mensaje = 'Instalaciones modificada';
        return $this->rows;
    }
    public function delete($id='')
    {
        $this->query = "DELETE FROM instalaciones WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Instalaciones eliminada';
        return $this->rows;
    }
    public function getAll()
    {
        $this->query = "SELECT id, centro_id, nombre, descripcion, capacidad_max FROM instalaciones";
        $this->get_results_from_query();
        return $this->rows;
    }
}

?>