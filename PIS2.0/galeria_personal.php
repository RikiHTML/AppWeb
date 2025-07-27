<?php
session_start();
include 'php/conexion.php';
include 'header.php';
//Bievenido a la galería personal
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
// Consultar las cartas del usuario
$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT c.* FROM cartas_usuario cu 
        JOIN cartas c ON cu.id_carta = c.id 
        WHERE cu.id_usuario = $id_usuario";
$result = $conn->query($sql);
?>
<main>
    <h1>Mi Colección</h1>
    <section id="galeria">
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="cartas-grid">
                <?php while($carta = $result->fetch_assoc()): ?>
                    <div class="carta">
                        <span class="numero"><?php echo htmlspecialchars($carta['id']); ?></span>
                        <img src="cartas/<?php echo htmlspecialchars($carta['imagen']); ?>" alt="<?php echo htmlspecialchars($carta['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($carta['nombre']); ?></h3>
                        <p class="rareza"><?php echo htmlspecialchars($carta['rareza']); ?></p>
                        <p><?php echo htmlspecialchars($carta['descripcion']); ?></p>
                        <p>Precio: $<?php echo number_format($carta['precio'], 2); ?></p>
                        <form method="POST" action="php/reventa.php">
                            <input type="hidden" name="id_carta" value="<?php echo $carta['id']; ?>">
                            <input type="number" name="precio_reventa" min="1" step="0.01" placeholder="Precio reventa" required>
                            <button type="submit" name="reventa">Poner en reventa</button>
                        </form>
                        <span class="numero abajo"><?php echo htmlspecialchars($carta['id']); ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No tienes cartas en tu colección.</p>
        <?php endif; ?>
    </section>
</main>
<?php include 'footer.php'; ?>