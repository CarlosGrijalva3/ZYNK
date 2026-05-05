<?php
//logout.php - cerrar sesion
session_start();
session_destroy();

header("Location: ../html/sesionhtml.php");
exit;