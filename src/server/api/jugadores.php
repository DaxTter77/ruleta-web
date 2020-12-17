<?php
    header("Content-Type: application/json");
    require_once '../models/model-jugador.php';
    require_once '../models/validacionesToken.php';

    if($_SERVER['REQUEST_METHOD'] != "POST" && !validacionToken::validacionToken()){
        return;
    }
    //Recibir peticiones del usuario
    switch($_SERVER['REQUEST_METHOD']){
        case 'POST':
            
            $_POST = json_decode(file_get_contents('php://input'), true);
            $respuesta = [];
            $jugador = new Jugador($_POST['nombre'], $_POST['usuario'], md5($_POST['clave']), $_POST['correo'], $_POST['dinero']);
            $respuesta['error'] = "";
            if(!empty($jugador->getCorreo()) &&count($jugador->buscarPorCorreo($jugador->getCorreo())) > 0){
                $respuesta['error'] .= "<li>El correo ya existe</li>";
                $respuesta['codigoResultado'] = 0;
            }
            if(!empty($jugador->getUsuario()) && count($jugador->buscarPorUsuario($jugador->getUsuario())) > 0){
                $respuesta['error'] .= "<li>El usuario ya existe</li>";
                $respuesta['codigoResultado'] = 0;
            }
            if(isset($respuesta['codigoResultado']) && $respuesta['codigoResultado'] == 0){
                echo json_encode($respuesta);
                return;
            }
            $res = $jugador->guardarJugador();
            unset($_POST['clave']);
            $respuesta['codigoResultado'] = 1;
            $respuesta['datos_creados'] = $_POST;
            echo json_encode($respuesta);
        break;
        case 'GET':
            $respuesta = [];
            if(isset($_GET['id'])){    
                $respuesta['datos'] = Jugador::buscarUsuario($_GET['id']);
            }else{
                $respuesta['datos'] = Jugador::obtenerUsuarios();
            }
            echo json_encode($respuesta);
        break;
        case 'PUT':
            
            $_POST = json_decode(file_get_contents('php://input'), true);
            $respuesta = [];
            $respuesta['error'] = "";
            
            if(isset($_GET['dineroAdd']) && $_GET['dineroAdd'] == "true"){
                if(isset($_POST['dinero']) && intval($_POST['dinero']) > 0){
                    $res = Jugador::adicionarDinero($_GET['id'], $_POST['dinero']);
                }else{
                    $respuesta['error'] = "<li>El dinero esta en negativos</li>";
                    $respuesta['codigoResultado'] = 0;
                    echo json_encode($respuesta);
                    return;
                }
            }else{
                $jugador = new Jugador($_POST['nombre'], $_POST['usuario'], null, $_POST['correo'], $_POST['dinero']);

                if($_GET['newUsuario']){
                    if(!empty($jugador->getUsuario()) && count($jugador->buscarPorUsuario($jugador->getUsuario())) > 0){
                        $respuesta['error'] .= "<li>El usuario ya existe</li>";
                        $respuesta['codigoResultado'] = 0;
                    }
                }
                if(!empty($jugador->getDinero()) && $jugador->getDinero() > 0){
                    $respuesta['error'] .= "<li>El dinero esta en negativos</li>";
                    $respuesta['codigoResultado'] = 0;
                }
                if(isset($respuesta['codigoResultado']) && $respuesta['codigoResultado'] == 0){
                    echo json_encode($respuesta);
                    return;
                }
    
                $res = $jugador->modificarJugador($_GET['id']);
                unset($_POST['clave']);
            }
            
            $respuesta['codigoResultado'] = $res;
            $respuesta['datos_actualizados'] = $_POST;
            $respuesta['id_actualizado'] = $_GET['id'];
            echo json_encode($respuesta);
        break;
        case 'DELETE':
            $respuesta = [];
            $res = Jugador::eliminarJugador($_GET['id']);
            $respuesta['codigoResultado'] = $res;
            $respuesta['id_eliminado'] = $_GET['id'];
            echo json_encode($respuesta);
        break;
    }