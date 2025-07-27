<?php
session_start();
include 'conexion.php';

// Solo admin puede subir cartas esto sirve para que el admin las suba dinamicamente
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $rareza = $conn->real_escape_string($_POST['rareza']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $coleccion = $conn->real_escape_string($_POST['coleccion']);

    //aqui la IA movio un poco de cosas no se que nomas
    // Subida de imagen
    $imagen = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagen = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../cartas/" . $imagen);
    }

    $sql = "INSERT INTO cartas (nombre, descripcion, rareza, precio, stock, coleccion, imagen) VALUES ('$nombre', '$descripcion', '$rareza', $precio, $stock, '$coleccion', '$imagen')";
    $conn->query($sql);
    header("Location: ../admin_panel.php");
    exit();
}
?>