<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

// Comprar carta de reventa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comprar_reventa'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $id_reventa = intval($_POST['id_reventa']);

    // Obtener datos de la carta en reventa
    $sql = "SELECT id_carta FROM reventa WHERE id = $id_reventa";
    $res = $conn->query($sql);
    if ($res && $row = $res->fetch_assoc()) {
        $id_carta = $row['id_carta'];
        // Agregar la carta al usuario comprador
        $conn->query("INSERT INTO cartas_usuario (id_usuario, id_carta) VALUES ($id_usuario, $id_carta)");
        // Eliminar la carta de la tabla reventa
        $conn->query("DELETE FROM reventa WHERE id = $id_reventa");
    }
    header("Location: ../reventa_galeria.php");
    exit();
}

// Poner carta en reventa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['poner_reventa'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $id_carta = intval($_POST['id_carta']);
    $precio = floatval($_POST['precio']);

    // Verificar que el usuario sea dueño de la carta
    $sql = "SELECT * FROM cartas_usuario WHERE id_usuario = $id_usuario AND id_carta = $id_carta";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        // La carta pertenece al usuario, proceder con la reventa
        $conn->query("INSERT INTO reventa (id_carta, id_usuario, precio) VALUES ($id_carta, $id_usuario, $precio)");
        // Eliminar la carta de la tabla cartas_usuario
        $conn->query("DELETE FROM cartas_usuario WHERE id_usuario = $id_usuario AND id_carta = $id_carta");
    }
    header("Location: ../galeria_personal.php");
    exit();
}
?>
<form method="POST" action="php/reventa.php">
    <input type="hidden" name="comprar_reventa" value="1">
    <input type="hidden" name="id_reventa" value="<?php echo $carta['id']; ?>">
    <button type="submit">Comprar</button>
</form>
<form method="POST" action="php/reventa.php">
    <input type="hidden" name="poner_reventa" value="1">
    <input type="hidden" name="id_carta" value="<?php echo $carta['id']; ?>">
    <input type="number" name="precio" min="1" step="0.01" placeholder="Precio reventa" required>
    <button type="submit">Poner en reventa</button>
</form>