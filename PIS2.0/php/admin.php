<?php
//Esto es para hacer referencia al documento php de conexion a la BDD
session_start();
include 'conexion.php';

// Estas son las credenciales del Admin y el tiene acceso especial a poder subir y editar cartas dinamicamente
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: ../index.php");
    exit();
}

// Lógica para mostrar todas las cartas y permitir editar/eliminar
$sql = "SELECT * FROM cartas";
$result = $conn->query($sql);
?>
<?php include '../header.php'; ?>
<main>
    <h1>Panel de Administración</h1>
    <a href="../subir_carta.php">Agregar nueva carta</a>
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
            <td><img src="../cartas/<?php echo htmlspecialchars($carta['imagen']); ?>" width="60"></td>
            <td><?php echo htmlspecialchars($carta['nombre']); ?></td>
            <td><?php echo htmlspecialchars($carta['rareza']); ?></td>
            <td>$<?php echo number_format($carta['precio'],2); ?></td>
            <td><?php echo (int)$carta['stock']; ?></td>
            <td>
                <a href="../editar_carta.php?id=<?php echo $carta['id']; ?>">Editar</a> |
                <a href="../eliminar_carta.php?id=<?php echo $carta['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta carta?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>
<?php include '../footer.php'; ?>