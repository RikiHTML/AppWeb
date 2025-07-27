<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'php/conexion.php';

if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $rareza = $conn->real_escape_string($_POST['rareza']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $coleccion = $conn->real_escape_string($_POST['coleccion']);

    // Subida de imagen
    $imagen = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagen = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['imagen']['tmp_name'], "cartas/" . $imagen);
    }

    $sql = "INSERT INTO cartas (nombre, descripcion, rareza, precio, stock, coleccion, imagen) VALUES ('$nombre', '$descripcion', '$rareza', $precio, $stock, '$coleccion', '$imagen')";
    $conn->query($sql);
    header("Location: admin_panel.php");
    exit();
}
?>
<?php include 'header.php'; ?>
<main>
    <h1>Agregar Nueva Carta</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>
        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea><br>
        <label>Rareza:</label>
        <select name="rareza" required>
            <option value="comun">Común</option>
            <option value="rara">Rara</option>
            <option value="legendaria">Legendaria</option>
        </select><br>
        <label>Precio:</label>
        <input type="number" name="precio" min="0" step="0.01" required><br>
        <label>Stock:</label>
        <input type="number" name="stock" min="0" required><br>
        <label>Colección:</label>
        <input type="text" name="coleccion"><br>
        <label>Imagen:</label>
        <input type="file" name="imagen" accept="image/*" required><br>
        <button type="submit">Agregar carta</button>
    </form>
</main>
<?php include 'footer.php'; ?>