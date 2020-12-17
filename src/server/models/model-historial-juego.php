<?php

    require_once '../db/mysql_connection.php';

    class HistorialJuego{

        private $jugador;
        private $opcion;
        private $resultado;
        private $apuesta;
        private $diferencia_dinero;
        
        public function __construct($opcion, $jugador, $resultado, $apuesta, $diferencia_dinero){
            $this->opcion = $opcion;
            $this->jugador = $jugador;
            $this->resultado = $resultado;
            $this->apuesta = $apuesta;
            $this->diferencia_dinero  = $diferencia_dinero;
        }

        public function getOpcion(){
            return $this->opcion;
        }

        public function setOpcion($opcion){
            $this->opcion = $opcion;
        }

        public function getJugador(){
            return $this->jugador;
        }

        public function setJugador($jugador){
            $this->jugador = $jugador;
        }

        public function getResultado(){
            return $this->resultado;
        }

        public function setResultado($resultado){
            $this->resultado = $resultado;
        }

        public function getApuesta(){
            return $this->apuesta;
        }

        public function setApuesta($apuesta){
            $this->apuesta = $apuesta;
        }

        public function getDiferenciaDinero(){
            return $this->diferencia_dinero;
        }

        public function setDiferenciaDinero($diferencia_dinero){
            $this->diferencia_dinero = $diferencia_dinero;
        }

        //Crud
        public function guardarRegistro(){
            $conn = new MysqlConnection();
            $query = "INSERT INTO historial_juegos VALUES(default, 
            $this->jugador, 
            $this->opcion, 
            '$this->resultado', 
            $this->apuesta, 
            $this->diferencia_dinero)";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res; 
        }

        public static function obtenerRegistros(){
            $conn = new MysqlConnection();
            $select = "SELECT h.id_historial, j.usuario_jugador, o.opcion, h.resultado_historial, h.apuesta_historial, h.diferencia_dinero 
            FROM historial_juegos h 
            INNER JOIN jugadores j ON j.id_jugador = h.id_jugador
            INNER JOIN opciones_apuestas o ON o.id_opcion = h.id_opcion";
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

        public static function buscarRegistroJugador($id){
            $conn = new MysqlConnection();
            $select = "SELECT h.id_historial, j.usuario_jugador, o.opcion, h.resultado_historial, h.apuesta_historial, h.diferencia_dinero 
            FROM historial_juegos h 
            INNER JOIN jugadores j ON j.id_jugador = h.id_jugador
            INNER JOIN opciones_apuestas o ON o.id_opcion = h.id_opcion
            WHERE h.id_jugador = $id
            ORDER BY h.id_jugador desc";
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

        public static function buscarRegistro($id){
            $conn = new MysqlConnection();
            $select = "SELECT h.id_historial, j.usuario_jugador, o.opcion, h.resultado_historial, h.apuesta_historial, h.diferencia_dinero 
            FROM historial_juegos h 
            INNER JOIN jugadores j ON j.id_jugador = h.id_jugador
            INNER JOIN opciones_apuestas o ON o.id_opcion = h.id_opcion
            WHERE h.id_historial = $id";
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

        public function modificarRegistro($id){
            $conn = new MysqlConnection();
            $query = "UPDATE historial_juegos SET ";
            
            if(!empty($this->jugador)){
                $query .= ", id_jugador=$this->jugador";
            }
            if(!empty($this->opcion)){
                $query .= ", id_opcion=$this->opcion";
            }
            if(!empty($this->resultado)){
                $query .= ", resultado_historial='$this->resultado'";
            }
            if(!empty($this->apuesta)){
                $query .= ", apuesta_historial=$this->apuesta";
            }
            if(!empty($this->diferencia_dinero) && $this->diferencia_dinero > 0){
                $query .= ", diferencia_dinero=$this->diferencia_dinero";
            }
            $query .= " WHERE id_historial = $id";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res;
        }

        public static function eliminarRegistro($id){
            $conn = new MysqlConnection();
            $query = "DELETE FROM historial_juegos WHERE id_historial = $id";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res;
        }
    }