<?php

namespace Controllers;

use Model\Proyecto;

class TareaController{
    public static function index(){

    }


    public static function crear(){
        if($_SERVER['REQUEST_MEETHOD'] === 'POST'){

            session_start();
            $proyectoId = $_POST['proyectoId'];
            $proyecto = Proyecto::where('url', $proyectoId);
            
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($proyecto);
            } else{
                $respuesta = [
                    'tipo' => 'exito',
                    'mensaje' => 'Tarea agregada correctamente'
                ];
            }
            
        }
    }


    public static function actualizar(){
        if($_SERVER['REQUEST_MEETHOD'] === 'POST'){
            
        }
    }
    


    public static function eliminar(){
        if($_SERVER['REQUEST_MEETHOD'] === 'POST'){
            
        }
    }
}