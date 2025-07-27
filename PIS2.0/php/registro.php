<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verifica si el usuario o correo ya existen
    $sql = "SELECT id FROM usuarios WHERE usuario='$usuario' OR correo='$correo'";
    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        $_SESSION['error_registro'] = "Usuario o correo ya registrado";
        header("Location: ../registro.php");
        exit();
    }

    // Inserta el nuevo usuario
    $sql = "INSERT INTO usuarios (usuario, correo, password, es_admin) VALUES ('$usuario', '$correo', '$password', 0)";
    if ($conn->query($sql)) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['id_usuario'] = $conn->insert_id;
        $_SESSION['es_admin'] = 0;
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['error_registro'] = "Error al registrar usuario";
        header("Location: ../registro.php");
        exit();
    }
}
?>