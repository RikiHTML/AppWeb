<?php
session_start();
include 'php/conexion.php';
include 'header.php';
//Bienvenida al panel de administración
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: index.php");
    exit();
}
// Consultar las cartas
// Asegúrate de que la tabla 'cartas' existe y tiene los campos necesarios
$sql = "SELECT * FROM cartas";
$result = $conn->query($sql);
?>
<main>
    <h1>Panel de Administración</h1>
    <a href="subir_carta.php">Agregar nueva carta</a>
    <table border="1" cellpadding="8" style="margin-top:20px;">
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Rareza</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
        <?php while($carta = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $carta['id']; ?></td>
            <td><img src="cartas/<?php echo htmlspecialchars($carta['imagen']); ?>" width="60"></td>
            <td><?php echo htmlspecialchars($carta['nombre']); ?></td>
            <td><?php echo htmlspecialchars($carta['rareza']); ?></td>
            <td>$<?php echo number_format($carta['precio'],2); ?></td>
            <td><?php echo (int)$carta['stock']; ?></td>
            <td>
                <!-- Aqui se puede editar o eliminar cartas -->
                <a href="editar_carta.php?id=<?php echo $carta['id']; ?>">Editar</a> |
                <a href="eliminar_carta.php?id=<?php echo $carta['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta carta?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>
<?php include 'footer.php'; ?>