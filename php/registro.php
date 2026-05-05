<?php
//registro.php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


     // validacion caracter
    if (strlen($nombre) > 50) {
        header("Location: ../html/registrohtml.php?error=nombre_largo");
        exit;
    }
     // validacion contraseña
    if (strlen($passwordPlano) < 8 || strlen($passwordPlano) > 30) {
        header("Location: ../html/registrohtml.php?error=password");
        exit;
    }


    // si existe ese mismo correo
    $correoExistente = $coleccion->findOne(["correo" => $correo]);
    if ($correoExistente) {
        header("Location: ../html/registrohtml.php?error=correo");
        exit;
    }
    // si existe ese mismo  nombre
    $nombreExistente = $coleccion->findOne(["nombre" => $nombre]);
    if ($nombreExistente) {
        header("Location: ../html/registrohtml.php?error=nombre");
        exit;
    }


    // crear usuario
    $usuario = [
        "usuario_id" => uniqid(),
        "nombre" => $nombre,
        "correo" => $correo,
        "password" => $password
    ];

    $coleccion->insertOne($usuario);

    //echo "Usuario registrado";
    header("Location: ../html/sesion.html");
    exit;
}