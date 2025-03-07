<?php

namespace App\Models;

class Reservas extends DBAbstractModel
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
    
    private $usuario_id;
    private $solicitante;
    private $telefono;
    private $email;
    private $instalacion_id;
    private $fecha_inicio;
    private $fecha_final;
    private $estado;

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
    public function getInstalacionId()
    {
        return $this->instalacion_id;
    }
    public function setInstalacionId($instalacion_id)
    {
        $this->instalacion_id = $instalacion_id;
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
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function get($id=""){
        $this->query = "SELECT * FROM reservas WHERE id = :id";
        $this->parametros["id"] = $id;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Reserva encontrada';
            return $this;
        } else {
            $this->mensaje = 'Reserva no encontrada';
        }
        return null;
    }

    public function set($input=array())
    {
        $this->query = "INSERT INTO reservas(solicitante, telefono, email, instalacion_id, fecha_inicio, fecha_final, estado) VALUES (:solicitante, :telefono, :email, :instalacion_id, :fecha_inicio, :fecha_final, :estado)";
        $this->parametros['solicitante'] = $input['solicitante'];
        $this->parametros['telefono'] = $input['telefono'];
        $this->parametros['email'] = $input['email'];
        $this->parametros['instalacion_id'] = $input['instalacion_id'];
        $this->parametros['fecha_inicio'] = $input['fecha_inicio'];
        $this->parametros['fecha_final'] = $input['fecha_final'];
        $this->parametros['estado'] = $input['estado'];
        $this->get_results_from_query();
        $this->mensaje = 'Reserva creada';
        return $this->rows;
    }

    public function edit($id = "")
    {
        $this->query = "UPDATE reservas SET solicitante = :solicitante, telefono = :telefono, email = :email, instalacion_id = :instalacion_id, fecha_inicio = :fecha_inicio, fecha_final = :fecha_final, estado = :estado WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['solicitante'] = $this->solicitante;
        $this->parametros['telefono'] = $this->telefono;
        $this->parametros['email'] = $this->email;
        $this->parametros['instalacion_id'] = $this->instalacion_id;
        $this->parametros['fecha_inicio'] = $this->fecha_inicio;
        $this->parametros['fecha_final'] = $this->fecha_final;
        $this->parametros['estado'] = $this->estado;
        $this->get_results_from_query();
        $this->mensaje = 'Reserva modificada';
        return $this->rows;
    }

    public function delete($id = "")
    {
        $this->query = "DELETE FROM reservas WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Reserva eliminada';
    }

    public function getAll()
    {
        $this->query = "SELECT * FROM reservas";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getReservasByUserId($usuario_id = ""){
        $this->query = "SELECT * FROM reservas WHERE usuario_id = :usuario_id";
        $this->parametros['usuario_id'] = $usuario_id;
        $this->get_results_from_query();
        return $this->rows;
    }

}


?>