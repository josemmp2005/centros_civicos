<?php

namespace App\Models;

use App\Models\Actividades;
use App\Models\Instalaciones;

class CentrosCivicos extends DBAbstractModel
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
    private $nombre;
    private $direccion;
    private $telefono;
    private $horario;
    private $foto;
    private $instalaciones = array();
    private $actividades = array();

    // Getters y Setters
    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function getHorario()
    {
        return $this->horario;
    }
    public function setHorario($horario)
    {
        $this->horario = $horario;
    }
    public function getFoto()
    {
        return $this->foto;
    }
    public function setFoto($foto)
    {
        $this->imagen = $foto;
    }

    //CRUD
    public function get($id = ''){
        
        $this->query = "SELECT * FROM centros_civicos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Centro Civico encontrado';
        } else {
            $this->mensaje = 'Centro Civico no encontrado';
        }
        // var_dump($this->rows[0]);
        
        $centroCivico = $this->rows[0] ?? null;   
        
        $centroCivico["actividades"] = Actividades::getInstancia()->get($id);
        $centroCivico["instalaciones"] = Instalaciones::getInstancia()->get($id);

        return $centroCivico ?? null;


    }
    public function set()
    {
        $this->query = "INSERT INTO centros_civicos(nombre, direccion, telefono, horario, foto) VALUES (:nombre, :direccion, :telefono, :horario, :foto)";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['direccion'] = $this->direccion;
        $this->parametros['telefono'] = $this->telefono;
        $this->parametros['horario'] = $this->horario;
        $this->parametros['foto'] = $this->foto;
        $this->get_results_from_query();
        $this->mensaje = 'Centro Civico agregado';
        return $this->rows;
    }
    public function edit($id="")
    {
        $this->query = "UPDATE centros_civicos SET nombre = :nombre, direccion = :direccion, telefono = :telefono, horario = :horario, foto = :imagen WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['direccion'] = $this->direccion;
        $this->parametros['telefono'] = $this->telefono;
        $this->parametros['horario'] = $this->horario;
        $this->parametros['foto'] = $this->foto;
        $this->get_results_from_query();
        $this->mensaje = 'Centro Civico modificado';
        return $this->rows;
    }
    public function delete($id="")
    {
        $this->query = "DELETE FROM centros_civicos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Centro Civico eliminado';
        return $this->rows;
    }
    
    public function getAll()
    {
        $this->query = "SELECT * FROM centros_civicos";
        $this->get_results_from_query();
        
        $centrosCivicos = [];
        foreach ($this->rows as $centroCivico) {
            $id = $centroCivico['id'];
            $centroCivico["actividades"] = Actividades::getInstancia()->get($id);
            $centroCivico["instalaciones"] = Instalaciones::getInstancia()->get($id);
            $centrosCivicos[] = $centroCivico;
        }
        return $centrosCivicos;
    }
}
?>