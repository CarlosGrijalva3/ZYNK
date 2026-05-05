<?php
/*homehtml.php*/
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: sesionhtml.php");
    exit;
}

require '../php/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Home</title>
<link rel="stylesheet" href="../css/home.css">
</head>

<body>

<!-- NAV -->
<div class="nav">

  <a href="perfilhtml.php">
    <img src="../imgs/icon_home/user9.png" class="icon">
  </a>
  <a href="homehtml.php">
    <img src="../imgs/icon_home/chat77.png" class="icon">
  </a>
  <a href="">
    <img src="../imgs/icon_home/home6.png" class="icon">
  </a>

</div>



<div class="espacio-nav"></div>


<!-- BOTÓN -->
<button class="btn-float" onclick="abrirModal()">
  <img src="../imgs/icon_home/add2.png" class="icon-btn">
</button>

<!-- MODAL -->
<div id="modal" class="modal">
  <div class="modal-content">
    <!-- x - pop de "+"✖ -->
    <span class="cerrar" onclick="cerrarModal()"></span>

    <h3><?php echo $_SESSION["nombre"]; ?></h3>

    <form action="../php/home_crear_post.php" method="POST">
      <textarea name="post_" maxlength="300" required></textarea>
      <input type="text" name="tags" maxlength="18" placeholder="#">
      <button type="submit">Publicar</button>
    </form>
  </div>
</div>

<!-- POSTS -->
<div class="contenedor-posts">

<?php
$posts = $postCollection->find([], ["sort" => ["_id" => -1]]);

foreach ($posts as $p) {

    // USUARIO
    $usuarioPost = $coleccion->findOne([
        "usuario_id" => $p["usuario_id"]
    ]);

    $nombreUsuario = $usuarioPost["nombre"] ?? "Usuario";

    // TAGS
    $tags = $p["tags"] ?? [];

    if ($tags instanceof MongoDB\Model\BSONArray) {
        $tags = $tags->getArrayCopy();
    }

    $tagsNombres = [];

    foreach ($tags as $tagId) 
    {
        $tagData = $tagCollection->findOne([
            "tag_id" => $tagId
        ]);

        $tagsNombres[] = $tagData
            ? "#" . $tagData["nombre_tag"]
            : "#" . $tagId;
    }

    // LIKE (activo o no)
    $likesUsuarios = $p["likes_usuarios"] ?? [];

    if ($likesUsuarios instanceof MongoDB\Model\BSONArray) {
        $likesUsuarios = $likesUsuarios->getArrayCopy();
    }

    $dioLike = in_array($_SESSION["usuario_id"], $likesUsuarios);
?>

<div class="post">

  <!-- HEADER -->
  <div class="post-header">
    <div>
      <strong><?php echo $nombreUsuario; ?></strong>
      <small><?php echo date("d/m/Y", strtotime($p["fecha"])); ?></small>
    </div>

    <?php if ($p["usuario_id"] == $_SESSION["usuario_id"]) { ?>

      <a class="delete-btn" href="../php/home_eliminar_post.php?id=<?php echo $p["_id"]; ?>">
        <img src="../imgs/icon_home/delete3.png" class="icon-small">
      </a>

    <?php } ?>
  </div>

  <!-- TEXTO -->
  <p>
    <span id="texto-<?php echo $p["_id"]; ?>">
      <?php echo $p["post_"]; ?>
    </span>

    <?php if ($p["usuario_id"] == $_SESSION["usuario_id"]) { ?>
      <span id="edit-btn-<?php echo $p['_id']; ?>" class="edit-inline"
        onclick="editarPost('<?php echo $p['_id']; ?>', `<?php echo addslashes($p['post_']); ?>`)">
        <img src="../imgs/icon_home/edit4.png" class="icon-small">
      </span>
    <?php } ?>
  </p>

  <!-- FOOTER -->
  <div class="post-footer">

    <span class="tags">
      <?php echo implode(" ", $tagsNombres); ?>
    </span>

    <!-- LIKE -->
    <a href="../php/home_like.php?id=<?php echo $p["_id"]; ?>" class="like-btn">
      <img src="../imgs/icon_home/<?php echo $dioLike ? 'heart2.png' : 'heart1.png'; ?>" class="icon-small">
      <?php echo $p["likes"]; ?>
    </a>

  </div>

</div>

<?php } ?>

</div>

<!-- JS -->
<script>
const modal = document.getElementById("modal");

function abrirModal() {
  modal.style.display = "flex";
  document.body.style.overflow = "hidden";
}

function cerrarModal() {
  modal.style.display = "none";
  document.body.style.overflow = "auto";
}

window.onclick = function(e) {
  if (e.target == modal) cerrarModal();
}

// EDITAR
function editarPost(id, texto) {
  const contenedor = document.getElementById("texto-" + id);
  const botonEditar = document.getElementById("edit-btn-" + id);

  if (botonEditar) botonEditar.style.display = "none";

  contenedor.innerHTML = `
    <div class="edit-container">
      <textarea id="edit-${id}" class="edit-box">${texto}</textarea>

      <div class="edit-actions">
        <button class="btn-cancel" onclick="cancelarEdit('${id}', \`${texto}\`)">Cancelar</button>
        <button class="btn-save" onclick="guardarPost('${id}')">Guardar</button>
      </div>
    </div>
  `;
}

function cancelarEdit(id, texto) {
  const contenedor = document.getElementById("texto-" + id);
  const botonEditar = document.getElementById("edit-btn-" + id);

  contenedor.innerHTML = texto;

  if (botonEditar) botonEditar.style.display = "inline";
}

function guardarPost(id) {
  const nuevoTexto = document.getElementById("edit-" + id).value;

  fetch("../php/home_actualizar_post.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `id=${id}&post_=${encodeURIComponent(nuevoTexto)}`
  })
  .then(() => location.reload());
}


</script>

</body>
</html>