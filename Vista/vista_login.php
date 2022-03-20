<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>

<body>
    <!-- Vista principal para el login de acceso se solicitan dos campos para el login y se envían
             al controlador ControladorLogin.php para su verificación. -->
    <h2>Página de acceso</h2><br><br>
    <form method="get" action="/controlador_login">
        Introducir usuario:
        <input type="text" name="usuario"><br>
        Introducir contraseña:
        <input type="text" name="pass"><br><br>

        <input type="submit" value="Loging">

    </form>
</body>

</html>