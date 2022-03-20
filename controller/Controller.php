<?php
    

    class Controller{

        private $MYSQL_DB = "act14";
        private $MYSQL_HOST = "127.0.0.1";
        private $MYSQL_USER = "root";
        private $MYSQL_PASSWORD = "usuario";

        private $conexion;

        public function __construct() {
            //session_start();
            $this->conexion = new mysqli($this->MYSQL_HOST, $this->MYSQL_USER, $this->MYSQL_PASSWORD, $this->MYSQL_DB);
        }

        public function registrar($usuario, $password){
            //Debemos de encriptar la contraseña
            $passwordEcriptada = hash("sha256", $password);
            if(!$this->verificarUsuarioNoExiste($usuario)){
                return false;
            }

            $valor = $this->conexion->query("INSERT INTO usuarios VALUES (null, '".$usuario."', '".$passwordEcriptada."', null, null)");
            if(!$valor){
                echo $this->conexion->error;
            }
        }

        public function loguear($usuario, $password){
            //Vamos a mirar si las contraseñas son validas
            $encriptarPassword = hash("sha256", $password);
            $usuarioObtenido = $this->getUsuario($usuario);
            if(sizeof($usuarioObtenido) < 1){
                return -1;
            }

            if($encriptarPassword !== $usuarioObtenido[2]){
                //No es la misma contraseña
                return -2;
            }

            //Si llega aqui es que todo ha ido correcto por lo que le creamos un token

            $token = $this->crearToken();
            if($this->updateToken($usuario, $token)){
                return 0;
            }else{
                return -3;
            }
        }

        public function updateToken($usuario, $token){
            $resultado = $this->conexion->query("UPDATE usuarios SET `token` = '".$token."' WHERE `nombreUsuario` = '".$usuario."'");
            if(!$resultado){
                return $this->conexion->error;
            }
            return true;
        }

        public function crearToken(){
            //session_start();
            $randomUid = uniqid("tkn_", true);
            $_SESSION["token"] = $randomUid;
            return $randomUid;
        }

        public function getUsuario($usuario){
            $resultado = $this->conexion->query("SELECT * FROM usuarios WHERE `nombreUsuario` = '".$usuario."'");
            if(!$resultado){
                return $this->conexion->error;
            }
            $resultadoReal = $resultado->fetch_row();

            return $resultadoReal;
        }

        public function verificarUsuarioNoExiste($usuario){
            $resultado = $this->conexion->query("SELECT COUNT(*) FROM usuarios WHERE `nombreUsuario` = '".$usuario."'");
            $resultadoReal = $resultado->fetch_row();

            if($resultadoReal[0] > 0){
                echo $resultadoReal[0];
                return false;
            }
            return true;
        }

        public function isUsuarioLogued()
        {
            //session_start();
            if(!isset($_SESSION["token"])){
                //No tiene token
                return false;
            }


            $resultado = $this->conexion->query("SELECT COUNT(*) FROM usuarios WHERE `token` = '".$_SESSION["token"]."'");
            $resultadoReal = $resultado->fetch_row();
            if($resultadoReal > 0){
                return true;
            }
            return false;
        }
    }