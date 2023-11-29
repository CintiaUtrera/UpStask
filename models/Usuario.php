<?php

namespace Model;

use Model\ActiveRecord;



class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB= ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $token;
    public $confirmado;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? null;
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
    }

    // validacion para cuentas nuevas
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'el nombre del usuario es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'el email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'el Password es obligatorio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'el password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][] = 'los password son diferentes';
        
        }
        return self::$alertas;
    }

}