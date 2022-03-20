<?php
    

    class MySQLController{

        private $MYSQL_DB = "act14";
        private $MYSQL_HOST = "localhost";
        private $MYSQL_USER = "root";
        private $MYSQL_PASSWORD = "usuario";

        private $conexion;

        public function __construct() {
            $this->conexion = new mysqli($this->MYSQL_HOST, $this->MYSQL_USER, $this->MYSQL_PASSWORD, $this->MYSQL_DB);
        }

        public function registrar($usuario, $password){
            //Debemos de encriptar la contraseña
            $passwordEcriptada = hash("sha256", $password);
            if(!$this->verificarUsuarioNoExiste($usuario)){
                return false;
            }

            $this->conexion->query("INSERT INTO usuarios VALUES (null, ".$usuario.", ".$passwordEcriptada.")");

        }

        public function verificarUsuarioNoExiste($usuario){
            $resultado = $this->conexion->query("SELECT COUNT(*) FROM usuarios WHERE `nombreUsuario` = ".$usuario);
            $resultadoReal = $resultado->fetch_row();
            if($resultadoReal > 0){
                return false;
            }
            return true;
        }

        public function isUsuarioLogued()
        {
            session_start();
            if(!isset($_SESSION["token"])){
                //No tiene token
                return false;
            }

            $resultado = $this->conexion->query("SELECT COUNT(*) FROM usuarios WHERE `token` = ".$_SESSION["token"]);
            $resultadoReal = $resultado->fetch_row();
            if($resultadoReal > 0){
                return true;
            }
            return false;
        }
    }