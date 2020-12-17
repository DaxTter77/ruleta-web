<?php
    session_start();
    class validacionToken{

        public function __construct(){
            
        }
        
        public static function validacionToken(){
            if(!isset($_SESSION["token"]) || !isset($_COOKIE["token"])){
                $respuesta["error"] = "No autenticado";
                echo json_encode($respuesta);
                return false;
            }
            if(!$_SESSION["token"] == $_COOKIE["token"]){
                $respuesta["error"] = "No autenticado";
                echo json_encode($respuesta);
                return false;
            }
            return true;
        }
    }