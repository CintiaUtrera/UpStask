<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {

    public static function login(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }

    // Funcion LOGOUT
    public static function logout(Router $router){
    

        // Render a la vista
        $router->render('auth/', [

        ]);
    }

    // Funcion CREAR
    public static function crear(Router $router){
        $alertas = [];
        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            $existeUsuario = Usuario::where('email', $usuario->email);

            if(empty($alertas)){
                if($existeUsuario){
                    Usuario::setAlerta('error', 'el usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else{
                    // Hashear password
                    $usuario->hashPassword();

                    //elimiinar password2
                    unset($usuario->password2);

                    //Generar el token
                    $usuario->crearToken();
                    
                    // crear nuevo usuario
                    $resultado = $usuario->guardar();

                    //Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea tu cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router){
        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password'
        ]);
    }


    public static function reestablecer(Router $router){
        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        // Render a la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password'
        ]);
    }

    public static function mensaje(Router $router){
        // Render a la vista
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada'
        ]);
    }

    public static function confirmar(Router $router){
        // Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu Cuenta'
        ]);
    }



}

