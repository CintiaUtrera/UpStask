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
        $alertas = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)){
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado){
                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);
                    // actualizar usuario
                    $usuario->guardar();
                    // enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    // imprimir alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');

                } else{
                    Usuario::setAlerta('error', 'el usuario no existe o no esta confirmado');
                    
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);
    }



    public static function reestablecer(Router $router){
        $token = s($_GET['token']);
        $mostrar = true;
        if(!$token) header('Location: /');

        // Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'token no valido');
            $mostrar = false;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // añadir al nuevo password
            $usuario->sincronizar($_POST);
            // validar el password
            $alertas = $usuario->validarPassword();
            if(empty($alertas)){
                // hashear el nuevo password 
                $usuario->hashPassword();
                // eliminar el token
                $usuario->token = null;
                // guardar en la db
                $resultado = $usuario->guardar();
                // redireccionar
                if($resultado){
                    header('Location: /');
                }
            }

        }
        $alertas = Usuario::getAlertas();
        // Render a la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }




    public static function mensaje(Router $router){
        // Render a la vista
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada'
        ]);
    }




    public static function confirmar(Router $router){

        $token = s($_GET['token']);
        if(!$token) header('Location: /');

        // Encontrar al usuario con este token 
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            // no se encontro un usuario con ese token
            Usuario::setAlerta('error', 'token no valido');
        } else {
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);

            // Guadar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu Cuenta',
            'alertas' => $alertas
        ]);
    }
}

