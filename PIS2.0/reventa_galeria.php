<?php
session_start();
include 'php/conexion.php';
include 'header.php';

// Consulta ejemplo (ajusta según tu tabla de reventa)
$sql = "SELECT r.*, c.* FROM reventa r JOIN cartas c ON r.id_carta = c.id";
$result = $conn->query($sql);
?>
<main>
    <h1>Cartas en Reventa</h1>
    <section id="galeria">
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="cartas-grid">
                <?php while($carta = $result->fetch_assoc()): ?>
                    <div class="carta">
                        <span class="numero"><?php echo htmlspecialchars($carta['id_carta']); ?></span>
                        <img src="cartas/<?php echo htmlspecialchars($carta['imagen']); ?>" alt="<?php echo htmlspecialchars($carta['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($carta['nombre']); ?></h3>
                        <p class="rareza"><?php echo htmlspecialchars($carta['rareza']); ?></p>
                        <p><?php echo htmlspecialchars($carta['descripcion']); ?></p>
                        <p>Precio reventa: $<?php echo number_format($carta['precio_reventa'], 2); ?></p>
                        <span class="numero abajo"><?php echo htmlspecialchars($carta['id_carta']); ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No hay cartas en reventa.</p>
        <?php endif; ?>
    </section>
</main>
<?php include 'footer.php'; ?>