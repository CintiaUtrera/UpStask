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
    public $password_actual;
    public $password_nuevo;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }


    // validar el login de usuarios
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'el email es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'email no válido';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'el Password es obligatorio';
        }
        return self::$alertas;
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

        // Valida un email
        public function validarEmail(){
            if(!$this->email){
                self::$alertas['error'][] = 'El email es obligatorio';
            }
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                self::$alertas['error'][] = 'email no válido';
            }
            return self::$alertas;
        }


        // valida el password
        public function validarPassword(){
            if(strlen($this->password) < 6){
                self::$alertas['error'][] = 'el password debe contener al menos 6 caracteres';
            }
            if($this->password !== $this->password2){
                self::$alertas['error'][] = 'los password son diferentes';
            
            }
            return self::$alertas;
        }


        public function validar_perfil(){
            if(!$this->nombre){
                self::$alertas['error'][] = 'El nombre es obligatorio';
            }
            if(!$this->email){
                self::$alertas['error'][] = 'El email es obligatorio';
            }

            return self::$alertas;
        }



        public  function nuevo_password() : array {
            if(!$this->password_actual){
                self::$alertas['error'][] = 'el passwoord actual no puede ir vacio';
            }
            if(!$this->password_nuevo){
                self::$alertas['error'][] = 'el passwoord nuevo no puede ir vacio';
            }
            if(strlen($this->password_nuevo) < 6 ){
                self::$alertas['error'][] = 'el passwoord debe contener al menos 6 caracteres';
            }
            return self::$alertas;
        }


        // comprobar el password
        public function comprobar_password() : bool {
            return password_verify($this->password_actual, $this->password );
        }


        //Hashea el password
        public function hashPassword() : void {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }



        // generar un token
        public function crearToken() : void {
            $this->token = uniqid();
        }
}