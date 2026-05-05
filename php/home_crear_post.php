<?php
/* home_crear_post.php */
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $texto = trim($_POST['post_']);
    $tagsTexto = $_POST['tags'];

    // límite del post
    if (strlen($texto) > 300) {
        die("Texto muy largo");
    }

    // convertir tags a array
    $tagsArray = array_map('trim', explode(",", $tagsTexto));

    $tagsIds = [];

    foreach ($tagsArray as $tag) {

        if ($tag !== "") {

            // límite de caracteres por tag
            $tag = substr($tag, 0, 18);
            $tag = strtolower($tag);

            // buscar si ya existe
            $tagExistente = $tagCollection->findOne([
                "nombre_tag" => $tag
            ]);

            if ($tagExistente) {

                // 🔥 SI YA EXISTE → aumentar usos
                $tagCollection->updateOne(
                    ["tag_id" => $tagExistente["tag_id"]],
                    ['$inc' => ["usos" => 1]]
                );

                $tagsIds[] = $tagExistente["tag_id"];

            } else {

                // 🔥 NUEVO TAG
                $nuevoTagId = uniqid("t");

                $tagCollection->insertOne([
                    "tag_id" => $nuevoTagId,
                    "nombre_tag" => $tag,
                    "usos" => 1
                ]);

                $tagsIds[] = $nuevoTagId;
            }
        }
    }

    // quitar repetidos
    $tagsIds = array_unique($tagsIds);

    // guardar post
    $post = [
        "usuario_id" => $_SESSION["usuario_id"],
        "post_" => $texto,
        "fecha" => date("Y-m-d"),
        "likes" => 0,
        "likes_usuarios" => [],
        "tags" => $tagsIds
    ];

    $postCollection->insertOne($post);

    header("Location: ../html/homehtml.php");
    exit;
}