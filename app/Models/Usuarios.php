<?php

namespace App\Models;

class Usuarios extends DBAbstractModel
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
    private $email;
    private $password;

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
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    //CRUD vacio
    public function get($id = "")
    {
        $this->query = "SELECT * FROM usuarios WHERE id = :id";
        $this->parametros["id"] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }


    public function toArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,  
            'email' => $this->email,
            'password' => $this->password,
        ];
    }


    public function set($input=array()){
        $this->query = "INSERT INTO usuarios(nombre, email, password) VALUES (:nombre, :email, :password)";
        $this->parametros['nombre'] = $input['nombre'];
        $this->parametros['email'] = $input['email'];
        $this->parametros['password'] = $input['password'];
        $this->get_results_from_query();
        $this->mensaje = 'Usuario agregado';
        return $this->rows;
    }   
    
    public function edit($input=[]){
        $this->query = "UPDATE usuarios SET nombre = :nombre, password = :password WHERE email = :email";
        $this->parametros['nombre'] = $input['nombre'];
        $this->parametros['password'] = $input['password'];
        $this->get_results_from_query();
        $this->mensaje = 'Usuario modificado';
        return $this->rows;
    }

    public function delete($id=""){
        $this->query = "DELETE FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario eliminado';
        return $this->rows;
    }
    public function getAll(){
        $this->query = "SELECT * FROM usuarios";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getByEmail($email){
        $this->query = "SELECT * FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Usuario encontrado';
            return $this;
        } else {
            $this->mensaje = 'Usuario no encontrado';
        }
        return null;
    }

    public function deleteByEmail($email){
        $this->query = "DELETE FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario eliminado';
        return $this->rows;
    }

    public function login($email, $password) {
        $this->query = "SELECT id, email FROM usuarios WHERE email = :email AND password = :password";
        $this->parametros['email'] = $email;
        $this->parametros['password'] = $password;
        $this->get_results_from_query();
    
        return $this->rows[0] ?? null;
    }
}