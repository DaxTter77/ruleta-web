<?php

    require_once '../db/mysql_connection.php';

    class OpcionApuesta{

        private $opcion;
        private $porcentaje;
        
        public function __construct($opcion, $porcentaje){
            $this->opcion = $opcion;
            $this->porcentaje = $porcentaje;
        }

        public function getOpcion(){
            return $this->opcion;
        }

        public function setOpcion($opcion){
            $this->opcion = $opcion;
        }

        public function getPorcentaje(){
            return $this->porcentaje;
        }

        public function setPorcentaje($porcentaje){
            $this->porcentaje = $porcentaje;
        }

        //Crud
        public function guardarOpcion(){
            $conn = new MysqlConnection();
            $query = "INSERT INTO opciones_apuestas VALUES(default, 
            '$this->opcion', 
            $this->porcentaje)";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res; 
        }

        public static function obtenerOpciones(){
            $conn = new MysqlConnection();
            $select = "SELECT * FROM opciones_apuestas";
            $rs = $conn->ejecutar($select);
            $conn->cerrar();
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $datos = [];
                while ($row = $rs->fetch_assoc()) {
                    $datos[] = $row;
                }
                
            }else{
                return null;
            }
            return $datos;
        }

        public static function buscarOpcion($id){
            $conn = new MysqlConnection();
            $select = "SELECT * FROM opciones_apuestas WHERE id_opcion = $id";
            $rs = $conn->ejecutar($select);
            $conn->cerrar();
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                return $rs->fetch_assoc(); 
                
            }else{
                return null;
            }
        }

        public static function obtenerPorcentaje(){
            $conn = new MysqlConnection();
            $select = "SELECT SUM(porcentaje_opcion) as suma_porcentaje FROM opciones_apuestas";
            $rs = $conn->ejecutar($select);
            $conn->cerrar();
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                return $rs->fetch_assoc(); 
                
            }else{
                return null;
            }
        }

        public function modificarOpcion($id){
            $conn = new MysqlConnection();
            $query = "UPDATE opciones_apuestas SET opcion='$this->opcion'";
            if(!empty($this->porcentaje)){
                $query .= ", porcentaje_opcion='$this->porcentaje'";
            }
            $query .= " WHERE id_opcion = $id";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res;
        }

        public static function eliminarOpcion($id){
            $conn = new MysqlConnection();
            $query = "DELETE FROM opciones_apuestas WHERE id_opcion = $id";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res;
        }
    }