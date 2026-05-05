<?php
/*perfilhtml.php*/
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: sesionhtml.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Perfil</title>
<link rel="stylesheet" href="../css/perfil.css">
</head>

<body>

<!-- NAV (igual que home) -->
<div class="nav">

  <a href="perfilhtml.php">
    <img src="../imgs/icon_home/user6.png" class="icon">
  </a>
  <a href="homehtml.php">
    <img src="../imgs/icon_home/chat12.png" class="icon">
  </a>
  <a href="homehtml.php">
    <img src="../imgs/icon_home/home6.png" class="icon">
  </a>

</div>
 
<div class="espacio-nav"></div>


<!-- espacio para que no tape el nav -->
 <div class="perfil-card">

    <h2 class="bienvenida">
      <span class="titulo">Perfil:</span>
      <span class="nombre"><?php echo $_SESSION["nombre"]; ?></span>
    </h2>

    <div class="logout">
      <a href="../php/logout.php">
        <span>Cerrar sesión</span>
      </a>
    </div>

  </div>

</body>

</html>