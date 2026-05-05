<?php
/*home_editar_post.php*/
session_start();
require 'conexion.php';

$id = $_GET['id'];

$post = $postCollection->findOne([
    "_id" => new MongoDB\BSON\ObjectId($id),
    "usuario_id" => $_SESSION["usuario_id"]
]);

if (!$post) {
    die("No autorizado");
}

// convertir tags
$tags = $post["tags"] ?? [];
if ($tags instanceof MongoDB\Model\BSONArray) {
    $tags = $tags->getArrayCopy();
}
$tagsTexto = implode(", ", $tags);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Post</title>
</head>

<body>

<h2>Editar Post</h2>

<form action="home_actualizar_post.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <textarea name="post_" required maxlength="300"><?php echo $post["post_"]; ?></textarea>

    <input type="text" name="tags" value="<?php echo $tagsTexto; ?>">

    <button type="submit">Guardar cambios</button>
</form>

</body>
</html>