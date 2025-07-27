<?php
// Cerrar sesión y redirigir al inicio
session_start();
session_destroy();
header("Location: ../index.php");
exit();
?>