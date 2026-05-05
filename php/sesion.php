
<?php
/*sesion.php*/
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = trim($_POST['correo']);
    $password = $_POST['password'];

    // buscar usuario por correo
    $usuario = $coleccion->findOne([
        "correo" => $correo
    ]);

    // si no existe el usuario
    if (!$usuario) {
        header("Location: ../html/sesion.html?error=usuario");
        exit;
    }

    // verificar contraseña
    if (!password_verify($password, $usuario["password"])) {
        header("Location: ../html/sesion.html?error=password");
        exit;
    }

    // login correcto → iniciar sesión
    session_start();
    $_SESSION["usuario_id"] = $usuario["usuario_id"];
    $_SESSION["nombre"] = $usuario["nombre"];

    // redirigir a home
    header("Location: ../html/homehtml.php");
    exit;
}