<?php
//conexion.php
require __DIR__ . '/../vendor/autoload.php';

$uri = "mongodb+srv://cadagral3_db_user:WYaTsC5otfnzgOYf@cluster0.hxwkzhj.mongodb.net/ReadSocialDB?retryWrites=true&w=majority";
//poner la carpeta de ReadSocialDB

try {
    $cliente = new MongoDB\Client($uri);

    $db = $cliente->ReadSocialDB;//nombre de la base de datos

    // colecciones
    $coleccion = $db->usuarios;
    $postCollection = $db->post;
    $tagCollection = $db->tags; // 🔥 NUEVO

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}