  <!--sesionhtml.php-->

  <!DOCTYPE html>
  <html lang="es">
  <head>
  <meta charset="UTF-8">
  <title>Login</title>

  <link rel="stylesheet" href="../css/estilos.css">
  </head>

    <body class="login-bg">

    <div class="container">
      <h2>login</h2>

      <!-- ERRORES -->
      <?php $error = $_GET['error'] ?? null; ?>
      <?php if ($error == "usuario") { ?>
        <div class="error">Usuario no encontrado</div>
      <?php } ?>

      <?php if ($error == "password") { ?>
        <div class="error">Contraseña incorrecta</div>
      <?php } ?>

      
      <form action="../php/sesion.php" method="POST"><!-- Formulario de inicio de sesión -->
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button class="btn-login" type="submit">entrar</button>
      </form>

      <a href="../html/registrohtml.php">crear cuenta</a>
    </div>

    </body>
  </html>