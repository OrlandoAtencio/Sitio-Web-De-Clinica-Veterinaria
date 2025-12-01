<?php
// index.php
// Redirige al login principal del sistema.
// Cambia 'login.php' si tu archivo de login tendrá otro nombre o ruta.

header("Location: login.php");
exit;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <!-- Fallback visual / meta por si no se procesa PHP por alguna razón -->
  <meta http-equiv="refresh" content="2; url=login.php" />
  <title>CLINICAVET</title>
</head>
<body>
  <p>Redirigiendo al sistema... Si no eres redirigido automáticamente, <a href="src/pages/llogin.html">haz clic aquí</a>.</p>
</body>
</html>
