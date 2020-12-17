<?php
    header("Content-Type: application/json");
    require_once '../models/model-opcion-apuesta.php';
    require_once '../models/validacionesToken.php';

    if(!validacionToken::validacionToken()){
        return;
    }
    //Recibir peticiones del usuario
    switch($_SERVER['REQUEST_METHOD']){
        case 'POST':
            if(empty($_POST)){
                $_POST = json_decode(file_get_contents('php://input'), true);
            }
            $opcion = new OpcionApuesta($_POST['opcion'], $_POST['porcentaje']);
            $res = $opcion->guardarOpcion();
            $respuesta = [];
            $respuesta['respuesta'] = $res;
            $respuesta['datos_creados'] = $_POST;
            echo json_encode($respuesta);
        break;
        case 'GET':
            $respuesta = [];
            if(isset($_GET['id'])){    
                $respuesta['datos'] = OpcionApuesta::buscarOpcion($_GET['id']);
            }else if(isset($_GET['porcentaje'])){
                $respuesta['suma_porcentajes'] = OpcionApuesta::obtenerPorcentaje();
            }else{
                $respuesta['datos'] = OpcionApuesta::obtenerOpciones();
            }
            echo json_encode($respuesta);
        break;
        case 'PUT':
            if(empty($_POST)){
                $_POST = json_decode(file_get_contents('php://input'), true);
            }
            $opcion = new OpcionApuesta($_POST['opcion'], $_POST['porcentaje']);
            $res = $opcion->modificarOpcion($_GET['id']);
            $respuesta = [];
            $respuesta['respuesta'] = $res;
            $respuesta['datos_actualizados'] = $_POST;
            $respuesta['id_actualizado'] = $_GET['id'];
            echo json_encode($respuesta);
        break;
        case 'DELETE':
            $respuesta = [];
            $res = OpcionApuesta::eliminarOpcion($_GET['id']);
            $respuesta['respuesta'] = $res;
            $respuesta['id_eliminado'] = $_GET['id'];
            echo json_encode($respuesta);
        break;
    }