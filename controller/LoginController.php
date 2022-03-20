<?php
    session_start();

    include_once("./Controller.php");

    if(!isset($_POST)){
        echo "Error";
        die();
    }

    var_dump($_SESSION);

    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $controlador = new Controller();

    if($controlador->verificarUsuarioNoExiste($usuario)){
        //El usuario existe
        echo "Usuario no existe";
        die();
    }


    $resultado = $controlador->loguear($usuario, $password);


    if($resultado == 0){
        var_dump($_SESSION);
        header("Location: /vista/vista_consultas.php", true);
        die();
    }else{
        var_dump($_SESSION);
        echo $resultado;
    }

    