<?php
session_start();
include 'conexion.php';
//Aqui tenemos el codigo de inicio de sesion


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE (usuario='$usuario' OR correo='$usuario') LIMIT 1";
    $res = $conn->query($sql);

    if ($res && $res->num_rows == 1) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['id_usuario'] = $user['id'];
            $_SESSION['es_admin'] = $user['es_admin'];
            header("Location: ../index.php");
            exit();
        }
    }
    // Si falla
    $_SESSION['error_login'] = "Usuario o contraseña incorrectos";
    header("Location: ../login.php");
    exit();
}
?>