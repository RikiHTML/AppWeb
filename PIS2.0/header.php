<?php
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TecnoCard - Tienda de Cartas NFT</title>
    <link rel="stylesheet" href="css/estilos.css">
    //Aqui tenemos a mi fondo de la Web(se va a modificar a futuro)
    <link rel="icon" href="img/fondo.png">
    <!-- Puedes agregar Bootstrap si lo necesitas -->
</head>
<body style="background-image: url('img/fondo.png'); background-size: cover;">
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Galería</a></li>
                <li><a href="galeria_personal.php">Mi colección</a></li>
                <li><a href="reventa_galeria.php">Reventa</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <?php if (isset($_SESSION['es_admin']) && $_SESSION['es_admin']): ?>
                    <li><a href="admin_panel.php">Admin</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li><a href="php/logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar sesión</a></li>
                    <li><a href="registro.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>