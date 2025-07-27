<?php
//este es nuestro archivo de conexion con la BDD
$host = "localhost";
$user = "root";
$pass = "admin123";
$dbname = "TecnoCardBDD";

$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar la conexión(codigo nos comprueba si la conexión es exitosa IA)
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>