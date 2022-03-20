<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
    <!-- Vista principal para el login de acceso se solicitan dos campos para el login y se envían
             al controlador ControladorLogin.php para su verificación. -->

    <?php
        include_once("./controller/Controller.php");
        echo "Hola mundo";
        $controlador = new Controller();

        echo "Hola mundo";
        
        if($controlador->isUsuarioLogued()){
            echo "Hola mundo";
            //Esta loguyeado
            echo "Log";
            header("Location: vista/vistas_consultas.php");
            die();
        }

        
    ?>
    <h2>Página de acceso</h2><br><br>
    <form method="post" action="./controller/LoginController.php">
        Introducir usuario:
        <input type="text" name="usuario"><br>
        Introducir contraseña:
        <input type="text" name="password"><br><br>
        <input type="submit" value="Loging">
    </form>
</body>
</html>