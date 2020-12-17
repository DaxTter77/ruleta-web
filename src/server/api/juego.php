<?php

    header("Content-Type: application/json");
    require_once '../models/model-opcion-apuesta.php';
    require_once '../models/model-historial-juego.php';
    require_once '../models/model-jugador.php';
    require_once '../models/validacionesToken.php';

    //if(!validacionToken::validacionToken()){
        //return;
    //}

    switch($_SERVER['REQUEST_METHOD']){
        case 'POST':
            $_POST = json_decode(file_get_contents('php://input'), true);
            $respuesta = [];
            $datos = [];
            $id_jugador = $_COOKIE['id'];
            $dineroBase = Jugador::dineroUsuario($id_jugador);
            if(isset($_POST['dinero']) && !empty($_POST['dinero'])){
                $dinero = intval($dineroBase["dinero_jugador"]);
                $apuesta = 0;
                if($dinero > 1000){
                    $apuesta = $dinero * (rand(11, 19) / 100);
                    $dinero -= $apuesta;
                }else if($dinero > 0 && $dinero <= 1000){
                    $apuesta = $dinero;
                    $dinero -= $apuesta;
                }else{
                    $respuesta["codigoResultado"] = 0;
                    $respuesta["mensaje"] = "Fondos insuficientes";
                    echo json_encode($respuesta);
                    return;
                }

                if(isset($_POST['opcion']) && !empty($_POST['opcion']) && $apuesta > 0){
                    $opcion = OpcionApuesta::buscarOpcion($_POST['opcion']);
                    $opciones = OpcionApuesta::obtenerOpciones();
                    $suma_probabilidad = 0;
                    $random = mt_rand(0, 99) / mt_rand(1, 9);
                    $ganador = [];
                    foreach ($opciones as $op) {
                        $suma_probabilidad += floatval($op['porcentaje_opcion']);
                        if($op['id_opcion'] == 1){
                            if($random <= $suma_probabilidad  && $random >= 0){
                                $ganador = $op;
                                $ganadora = $op['opcion'];
                                break;
                            }
                        }else if($random <= $suma_probabilidad){
                            $ganador = $op;
                            $ganadora = $op['opcion'];
                            break;
                        }
                    }
                    $diferencia_dinero = 0;
                    if($ganador['id_opcion'] == $opcion['id_opcion']){
                        // Ya que en la documentación se toma especificamente el valor que debe dar cada opción se setea, de lo contrario se podría buscar otra opción
                        if($ganador['opcion'] == 'Verde'){
                            $diferencia_dinero = $apuesta * 10;
                        }else if($ganador['opcion'] == 'Rojo' || $ganador['opcion'] == 'Negro'){
                            $diferencia_dinero = $apuesta * 2;
                        }
                        $dinero += $diferencia_dinero;
                        $resultado = "Ha ganado";
                    }else{
                        $diferencia_dinero -= $apuesta;
                        $resultado = "Ha perdido";
                    }

                    $historial = new HistorialJuego($opcion['id_opcion'], $id_jugador, $resultado, $apuesta, $diferencia_dinero);
                    Jugador::adicionarDinero($id_jugador, $diferencia_dinero);
                    $historial->guardarRegistro();
                    $respuesta['codigoResultado'] = 1;
                    $respuesta['resultado'] = $resultado;
                    $respuesta['opcion'] = $opcion['opcion'];
                    $respuesta['ganador'] = $ganadora;
                    $respuesta['apuesta'] = $apuesta;
                    $respuesta['diferencia_dinero'] = $diferencia_dinero;

                }else{
                    $respuesta["mensaje"] = "Opcion no detectada y/o Apuesta en ceros";
                    echo json_encode($respuesta);
                    return;
                }
            }else{
                $respuesta["mensaje"] = "No hay dinero";
                echo json_encode($respuesta);
                return;
            }
            echo json_encode($respuesta);

        break;
    }