<?php
session_start();
include 'header.php';
?>
<main>
    <h1>Iniciar Sesión</h1>
    <?php if (isset($_SESSION['error_login'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error_login']; unset($_SESSION['error_login']); ?></p>
    <?php endif; ?>
    <form method="POST" action="php/login.php">
        <label>Usuario o correo:</label>
        <input type="text" name="usuario" required><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Iniciar sesión</button>
    </form>
    <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
</main>
<?php include 'footer.php'; ?>