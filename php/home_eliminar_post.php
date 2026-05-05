<?php
session_start();
require 'conexion.php';

$id = $_GET['id'];

// buscar el post antes de borrarlo
$post = $postCollection->findOne([
    "_id" => new MongoDB\BSON\ObjectId($id),
    "usuario_id" => $_SESSION["usuario_id"]
]);

if (!$post) {
    die("No autorizado");
}

// obtener tags del post
$tags = $post["tags"] ?? [];

if ($tags instanceof MongoDB\Model\BSONArray) {
    $tags = $tags->getArrayCopy();
}

// 🔥 restar usos
foreach ($tags as $tagId) {

    $tagCollection->updateOne(
        ["tag_id" => $tagId],
        ['$inc' => ["usos" => -1]]
    );

    // opcional: eliminar si llega a 0
    $tagCollection->deleteOne([
        "tag_id" => $tagId,
        "usos" => 0
    ]);
}

// eliminar post
$postCollection->deleteOne([
    "_id" => new MongoDB\BSON\ObjectId($id),
    "usuario_id" => $_SESSION["usuario_id"]
]);

header("Location: ../html/homehtml.php");
exit;
?>