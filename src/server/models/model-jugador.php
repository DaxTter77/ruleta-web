<?php

    require_once '../db/mysql_connection.php';

    class Jugador{

        private $nombre;
        private $usuario;
        private $clave;
        private $correo;
        private $dinero;
        private $admin;
        
        public function __construct($nombre, $usuario, $clave, $correo, $dinero = 15000.0, $admin = 0){
            $this->nombre = strtoupper($nombre);
            $this->usuario = $usuario;
            $this->clave = $clave;
            $this->correo = $correo;
            $this->dinero  = $dinero;
            $this->admin  = $admin;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
        }

        public function getUsuario(){
            return $this->usuario;
        }

        public function setUsuario($usuario){
            $this->usuario = $usuario;
        }

        public function getClave(){
            return $this->clave;
        }

        public function setClave($clave){
            $this->clave = $clave;
        }

        public function getCorreo(){
            return $this->correo;
        }

        public function setCorreo($correo){
            $this->correo = $correo;
        }

        public function getDinero(){
            return $this->dinero;
        }

        public function setDinero($dinero){
            $this->dinero = $dinero;
        }

        public function getAdmin(){
            return $this->admin;
        }

        public function setAdmin($admin){
            $this->admin = $admin;
        }

        //Crud
        public function guardarJugador(){
            $conn = new MysqlConnection();
            $query = "INSERT INTO jugadores VALUES(default, 
            '$this->nombre', 
            '$this->usuario', 
            '$this->clave', 
            '$this->correo'";
            if(!empty($this->dinero) ) {
                $query .= ", $this->dinero";
            }else{
                $query .= ", default";
            }
            if(!empty($this->admin) ) {
                $query .= ", $this->admin";
            }else{
                $query .= ", default";
            }
            $query .= ")";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res; 
        }

        public static function obtenerUsuarios(){
            $conn = new MysqlConnection();
            $select = "SELECT * FROM jugadores";
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

        public static function buscarUsuario($id){
            $conn = new MysqlConnection();
            $select = "SELECT * FROM jugadores WHERE id_jugador = $id";
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

        public static function buscarPorCorreo($correo){
            $conn = new MysqlConnection();
            $select = "SELECT * FROM jugadores WHERE correo_electronico_jugador = '$correo'";
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

        public static function buscarPorUsuario($usuario){
            $conn = new MysqlConnection();
            $select = "SELECT * FROM jugadores WHERE usuario_jugador = '$usuario'";
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

        public static function dineroUsuario($id){
            $conn = new MysqlConnection();
            $select = "SELECT dinero_jugador FROM jugadores WHERE id_jugador = $id";
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

        public function modificarJugador($id){
            $conn = new MysqlConnection();
            $query = "UPDATE jugadores SET ";
            
            if(!empty($this->nombre)){
                $query .= "nombre_jugador='$this->nombre'";
            }
            if(!empty($this->usuario)){
                $query .= ", usuario_jugador='$this->usuario'";
            }
            if(!empty($this->clave)){
                $query .= ", clave_jugador='$this->clave'";
            }
            if(!empty($this->correo)){
                $query .= ", correo_electronico_jugador='$this->correo'";
            }
            if(!empty($this->dinero) && $this->dinero > 0){
                $query .= ", dinero_jugador=$this->dinero";
            }
            if(!empty($this->admin) && $this->admin > 0){
                $query .= ", admin_jugador=$this->admin";
            }
            $query .= " WHERE id_jugador = $id";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res;
        }

        public static function adicionarDinero($id, $dinero){
            $conn = new MysqlConnection();
            $query = "UPDATE jugadores SET dinero_jugador = dinero_jugador + $dinero";
            $query .= " WHERE id_jugador = $id";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res;
        }

        public static function verificarUsuario($correo, $clave){
            $conn = new MysqlConnection();
            $select = "SELECT * FROM jugadores WHERE correo_electronico_jugador = '$correo' and clave_jugador = '".md5($clave)."'";
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

        public static function eliminarJugador($id){
            $conn = new MysqlConnection();
            $query = "DELETE FROM jugadores WHERE id_jugador = $id";
            $res = $conn->ejecutar($query);
            $conn->cerrar();
            return $res;
        }
    }