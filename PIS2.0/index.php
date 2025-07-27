<?php
include 'header.php';
include 'php/conexion.php';

// Filtros
$buscar = isset($_GET['buscar']) ? $conn->real_escape_string($_GET['buscar']) : '';
$rareza = isset($_GET['rareza']) ? $conn->real_escape_string($_GET['rareza']) : '';

// Consulta base
$sql = "SELECT * FROM cartas WHERE 1";
if ($buscar != '') {
    $sql .= " AND nombre LIKE '%$buscar%'";
}
if ($rareza != '') {
    $sql .= " AND rareza = '$rareza'";
}
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_carrito'])) {
    $id_carta = intval($_POST['agregar_carrito']);
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    if (!in_array($id_carta, $_SESSION['carrito'])) {
        $_SESSION['carrito'][] = $id_carta;
    }
    header("Location: index.php");
    exit();
}

$likes_usuario = [];
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $sql_likes = "SELECT id_carta FROM likes WHERE id_usuario = $id_usuario";
    $res_likes = $conn->query($sql_likes);
    if ($res_likes) {
        while ($like = $res_likes->fetch_assoc()) {
            $likes_usuario[] = $like['id_carta'];
        }
    }
}
?>
<main>
    <h1>Galería de Cartas NFT</h1>
    <section id="filtro">
        <form method="GET" action="">
            <input type="text" name="buscar" placeholder="Buscar carta por nombre..." value="<?php echo htmlspecialchars($buscar); ?>">
            <select name="rareza">
                <option value="">Todas las rarezas</option>
                <option value="comun" <?php if($rareza=="comun") echo "selected"; ?>>Común</option>
                <option value="rara" <?php if($rareza=="rara") echo "selected"; ?>>Rara</option>
                <option value="legendaria" <?php if($rareza=="legendaria") echo "selected"; ?>>Legendaria</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>
    </section>
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
                        <p>Stock: <?php echo (int)$carta['stock']; ?></p>
                        <form method="POST" style="display:inline;">
                            <button type="submit" name="agregar_carrito" value="<?php echo $carta['id']; ?>">Agregar al carrito</button>
                        </form>
                        <button class="like-btn" data-id="<?php echo $carta['id']; ?>">
                            <?php echo (in_array($carta['id'], $likes_usuario)) ? '💖 Liked' : '❤️ Like'; ?>
                        </button>
                        <span class="numero abajo"><?php echo htmlspecialchars($carta['id']); ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No se encontraron cartas.</p>
        <?php endif; ?>
    </section>
</main>
<script>
document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const id = this.getAttribute('data-id');
        fetch('php/like.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id_carta=' + encodeURIComponent(id)
        })
        .then(res => res.text())
        .then(data => {
            if(data === 'login') {
                alert('Debes iniciar sesión para dar like.');
            } else if(data === 'liked') {
                this.textContent = '💖 Liked';
            } else if(data === 'unliked') {
                this.textContent = '❤️ Like';
            }
        }.bind(this));
    });
});
</script>
<?php include 'footer.php'; ?>