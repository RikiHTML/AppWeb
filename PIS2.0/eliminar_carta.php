<?php
session_start();
include 'php/conexion.php';

if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Opcional: eliminar la imagen del servidor si lo deseas
    $sql_img = "SELECT imagen FROM cartas WHERE id = $id";
    $res_img = $conn->query($sql_img);
    if ($res_img && $row = $res_img->fetch_assoc()) {
        $img_path = "cartas/" . $row['imagen'];
        if (file_exists($img_path)) {
            unlink($img_path);
        }
    }
    // Eliminar la carta
    $conn->query("DELETE FROM cartas WHERE id = $id");
}
header("Location: admin_panel.php");
exit();
?>