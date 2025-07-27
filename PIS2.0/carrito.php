<?php
session_start();
include 'php/conexion.php';
include 'header.php';

// Obtener el carrito de la sesión
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar'])) {
    $id = intval($_POST['eliminar']);
    if(($key = array_search($id, $carrito)) !== false) {
        unset($carrito[$key]);
        $_SESSION['carrito'] = $carrito;
        // Recargar para actualizar la vista
        header("Location: carrito.php");
        exit();
    }
}

if (count($carrito) > 0) {
    $ids = implode(',', array_map('intval', $carrito));
    $sql = "SELECT * FROM cartas WHERE id IN ($ids)";
    $result = $conn->query($sql);
} else {
    $result = false;
}
?>
<main>
    <h1>Carrito de Compras</h1>
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
                        <form method="POST">
                            <button type="submit" name="eliminar" value="<?php echo $carta['id']; ?>">Eliminar</button>
                        </form>
                        <span class="numero abajo"><?php echo htmlspecialchars($carta['id']); ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <form method="POST" action="php/comprar.php">
                    <?php foreach($carrito as $id): ?>
                        <input type="hidden" name="cartas[]" value="<?php echo $id; ?>">
                    <?php endforeach; ?>
                    <button type="submit">Finalizar compra</button>
                </form>
            <?php else: ?>
                <p>Debes <a href="login.php">iniciar sesión</a> para finalizar la compra.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Tu carrito está vacío.</p>
        <?php endif; ?>
    </section>
</main>
<?php include 'footer.php'; ?>