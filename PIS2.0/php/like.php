<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    echo "login";
    exit();
}
// Este codigo fue generado por IA
$id_usuario = $_SESSION['id_usuario'];
$id_carta = intval($_POST['id_carta']);

// Verifica si ya dio like
$sql = "SELECT * FROM likes WHERE id_usuario=$id_usuario AND id_carta=$id_carta";
$res = $conn->query($sql);

if ($res && $res->num_rows > 0) {
    // Quitar like
    $conn->query("DELETE FROM likes WHERE id_usuario=$id_usuario AND id_carta=$id_carta");
    echo "unliked";
} else {
    // Dar like
    $conn->query("INSERT INTO likes (id_usuario, id_carta) VALUES ($id_usuario, $id_carta)");
    echo "liked";
}
exit();
?>