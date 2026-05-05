<!--registrohtml.php-->
<?php $error = $_GET['error'] ?? null; ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro</title>

<link rel="stylesheet" href="../css/estilos.css">
</head>

<body class="registro-bg">

<div class="container">

  <h2>Registro</h2>

   <!-- MENSAJES DE ERROR -->
 
  <?php if ($error == "nombre_largo") { ?>
  <div class="error">El nombre no puede pasar de 50 caracteres</div>
  <?php } ?>

  <?php if ($error == "password") { ?>
  <div class="error">La contraseña debe tener entre 8 y 30 caracteres</div>
  <?php } ?>



  <form action="../php/registro.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required maxlength="50">
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Contraseña" required minlength="8" maxlength="30">
    <button class="btn-registro" type="submit">Registrarse</button>
  </form>

  <a href="../html/sesionhtml.php">Inicia sesión</a>
</div>

</body>

</html>
