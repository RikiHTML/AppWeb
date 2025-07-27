<?php
session_start();
include 'php/conexion.php';

if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin_panel.php");
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM cartas WHERE id = $id";
$res = $conn->query($sql);
$carta = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $rareza = $conn->real_escape_string($_POST['rareza']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $coleccion = $conn->real_escape_string($_POST['coleccion']);

    // Si se sube una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagen = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['imagen']['tmp_name'], "cartas/" . $imagen);
        // Elimina la imagen anterior
        if (file_exists("cartas/" . $carta['imagen'])) {
            unlink("cartas/" . $carta['imagen']);
        }
        $conn->query("UPDATE cartas SET imagen='$imagen' WHERE id=$id");
    }

    $conn->query("UPDATE cartas SET nombre='$nombre', descripcion='$descripcion', rareza='$rareza', precio=$precio, stock=$stock, coleccion='$coleccion' WHERE id=$id");
    header("Location: admin_panel.php");
    exit();
}
?>
<?php include 'header.php'; ?>
<main>
    <h1>Editar Carta</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($carta['nombre']); ?>" required><br>
        <label>Descripción:</label>
        <textarea name="descripcion" required><?php echo htmlspecialchars($carta['descripcion']); ?></textarea><br>
        <label>Rareza:</label>
        <select name="rareza" required>
            <option value="comun" <?php if($carta['rareza']=="comun") echo "selected"; ?>>Común</option>
            <option value="rara" <?php if($carta['rareza']=="rara") echo "selected"; ?>>Rara</option>
            <option value="legendaria" <?php if($carta['rareza']=="legendaria") echo "selected"; ?>>Legendaria</option>
        </select><br>
        <label>Precio:</label>
        <input type="number" name="precio" min="0" step="0.01" value="<?php echo $carta['precio']; ?>" required><br>
        <label>Stock:</label>
        <input type="number" name="stock" min="0" value="<?php echo $carta['stock']; ?>" required><br>
        <label>Colección:</label>
        <input type="text" name="coleccion" value="<?php echo htmlspecialchars($carta['coleccion']); ?>"><br>
        <label>Imagen:</label>
        <input type="file" name="imagen" accept="image/*"><br>
        <button type="submit">Guardar cambios</button>
    </form>
</main>
<?php include 'footer.php'; ?>