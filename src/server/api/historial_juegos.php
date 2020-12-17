<?php
    header("Content-Type: application/json");
    require_once '../models/model-historial-juego.php';
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
            $registro = new HistorialJuego($_POST['jugador'], $_POST['opcion'], $_POST['resultado'], $_POST['apuesta'], $_POST['diferencia']);
            $res = $registro->guardarRegistro();
            $respuesta = [];
            $respuesta['respuesta'] = $res;
            $respuesta['datos_creados'] = $_POST;
            echo json_encode($respuesta);
        break;
        case 'GET':
            $respuesta = [];
            if(isset($_GET['id'])){    
                if($_GET['jugador']){
                    $respuesta['datos'] = HistorialJuego::buscarRegistroJugador($_GET['id']);
                }else{
                    $respuesta['datos'] = HistorialJuego::buscarRegistro($_GET['id']);
                }
            }else{
                $respuesta['datos'] = HistorialJuego::obtenerRegistros();
            }
            echo json_encode($respuesta);
        break;
        case 'PUT':
            if(empty($_POST)){
                $_POST = json_decode(file_get_contents('php://input'), true);
            }
            $registro = new HistorialJuego($_POST['jugador'], $_POST['opcion'], $_POST['resultado'], $_POST['apuesta'], $_POST['diferencia']);
            $res = $registro->modificarRegistro($_GET['id']);
            $respuesta = [];
            $respuesta['respuesta'] = $res;
            $respuesta['datos_actualizados'] = $_POST;
            $respuesta['id_actualizado'] = $_GET['id'];
            echo json_encode($respuesta);
        break;
        case 'DELETE':
            $respuesta = [];
            $res = HistorialJuego::eliminarRegistro($_GET['id']);
            $respuesta['respuesta'] = $res;
            $respuesta['id_eliminado'] = $_GET['id'];
            echo json_encode($respuesta);
        break;
    }