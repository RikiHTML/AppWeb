<?php
session_start();
include 'header.php';
?>
<main>
    <h1>Registro de Usuario</h1>
    <?php if (isset($_SESSION['error_registro'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error_registro']; unset($_SESSION['error_registro']); ?></p>
    <?php endif; ?>
    <form method="POST" action="php/registro.php">
        <label>Usuario:</label>
        <input type="text" name="usuario" required><br>
        <label>Correo:</label>
        <input type="email" name="correo" required><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</main>
<?php include 'footer.php'; ?>