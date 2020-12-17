<?php

    require_once '../../config/config.php';

    class MysqlConnection{

        private $conn = null;

        public function __construct(){
            $this->conn = new mysqli(HOST, USER, PASS, DB);
            $this->conn->set_charset(CHARSET);
            
        }

        public function comprobarConn(){
            if ($this->conn->connect_errno) {
                printf("Connect failed: %s\n", $this->conn->connect_error);
                exit();
            }
            echo 'Connection succesfully';
        }

        public function ejecutar($query){
            $res = $this->conn->query($query);
            if($this->conn->error){
                printf("Error message: %s\n", $this->conn->error);
            }
            return $res;
        }

        public function cerrar(){
            $this->conn->close();
        }
    }