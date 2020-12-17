<?php
    session_start();
    header("Content-Type: application/json");
    require_once '../models/model-jugador.php';
    if(empty($_POST)){
        $_POST = json_decode(file_get_contents('php://input'), true);
    }
    switch($_SERVER['REQUEST_METHOD']){
        case 'POST':
            //Verificar si el usuario existe
            $jugador = Jugador::verificarUsuario($_POST['correo'], $_POST['clave']);
            $resultado = [];
            if($jugador){
                //echo '{"codigoResultado" : 1, "mensaje": "Usuario autenticado", "token" : "'.sha1(uniqid(rand(), true)).'"}';
                $token = sha1(uniqid(rand(), true));
                $resultado['codigoResultado'] = 1;
                $resultado['mensaje'] = "Usuario autenticado";
                $resultado['admin'] = $jugador['admin_jugador'];
                //Valido si el usuario que ingresó es un admin, si es así en el token agrego un 1 al final si lo es, de lo contrario pongo un 0
                $resultado['token'] = ($resultado['admin'] == 1) ? $token."1" : $token."0";

                $_SESSION["token"] = $resultado['token'];
                setcookie('token', $resultado['token'], time() + (60*60*24*31), '/');
                setcookie('id', $jugador['id_jugador'], time() + (60*60*24*31), '/');
                setcookie('usuario', $jugador['usuario_jugador'], time() + (60*60*24*31), '/');
                setcookie('dinero', $jugador['dinero_jugador'], time() + (60*60*24*31), '/');
                setcookie('correo', $jugador['correo_electronico_jugador'], time() + (60*60*24*31), '/');
            }else{
                //echo '{"codigoResultado" : 0, "mensaje": "Correo electronico/Clave incorrectos", }';
                $resultado['codigoResultado'] = 0;
                $resultado['mensaje'] = "Correo electronico/Clave incorrectos";
                setcookie('token', '', time()-1, '/');
                setcookie('id', '', time()-1, '/');
                setcookie('usuario', '', time()-1, '/');
                setcookie('dinero', '', time()-1, '/');
                setcookie('correo', '', time()-1, '/');
            }
            echo json_encode($resultado);
        break;
    }