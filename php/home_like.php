<?php
/* home_like.php */
session_start();
require 'conexion.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../html/sesionhtml.php");
    exit;
}

$id = $_GET['id'];
$usuario = $_SESSION["usuario_id"];

// buscar post
$post = $postCollection->findOne([
    "_id" => new MongoDB\BSON\ObjectId($id)
]);

if (!$post) {
    header("Location: ../html/homehtml.php");
    exit;
}

// lista de usuarios que dieron like
$likesUsuarios = $post["likes_usuarios"] ?? [];

if ($likesUsuarios instanceof MongoDB\Model\BSONArray) {
    $likesUsuarios = $likesUsuarios->getArrayCopy();
}

// YA DIO LIKE → quitar
if (in_array($usuario, $likesUsuarios)) {

    $nuevoLikes = max(0, ($post["likes"] ?? 0) - 1);

    $postCollection->updateOne(
        ["_id" => new MongoDB\BSON\ObjectId($id)],
        [
            '$set' => ["likes" => $nuevoLikes],
            '$pull' => ["likes_usuarios" => $usuario]
        ]
    );

// NO HA DADO LIKE → agregar
} else {

    $postCollection->updateOne(
        ["_id" => new MongoDB\BSON\ObjectId($id)],
        [
            '$inc' => ["likes" => 1],
            '$push' => ["likes_usuarios" => $usuario]
        ]
    );
}

header("Location: ../html/homehtml.php");
exit;
/**/ 