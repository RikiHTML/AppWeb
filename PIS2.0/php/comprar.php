<?php
//Referencia a la conexion
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cartas'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $cartas = $_POST['cartas'];
    $errores = [];

    foreach ($cartas as $id_carta) {
        $id_carta = intval($id_carta);
        $sql = "SELECT stock FROM cartas WHERE id=$id_carta";
        $res = $conn->query($sql);
        if ($res && $row = $res->fetch_assoc()) {
            if ($row['stock'] > 0) {
                $conn->query("UPDATE cartas SET stock = stock - 1 WHERE id=$id_carta");
                $conn->query("INSERT INTO cartas_usuario (id_usuario, id_carta) VALUES ($id_usuario, $id_carta)");
            } else {
                $errores[] = $id_carta;
            }
        }
    }
    // Vacía el carrito por si el UR se arrepiente de comprar
    $_SESSION['carrito'] = [];
    if (empty($errores)) {
        header("Location: ../galeria_personal.php");
    } else {
        $_SESSION['error_compra'] = "Algunas cartas no tenían stock.";
        header("Location: ../carrito.php");
    }
    exit();
}
header("Location: ../carrito.php");
exit();
?>