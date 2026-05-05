<?php
/*home_actualizar_post.php*/
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $texto = trim($_POST['post_']);

    if (strlen($texto) > 300) {
        exit;
    }

    $postCollection->updateOne(
        [
            "_id" => new MongoDB\BSON\ObjectId($id),
            "usuario_id" => $_SESSION["usuario_id"]
        ],
        [
            '$set' => [
                "post_" => $texto,
                "fecha" => date("Y-m-d")
            ]
        ]
    );
}