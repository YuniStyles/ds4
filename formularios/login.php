<?php
/**
 * login.php
 * Formulario de inicio de sesión.
 */
session_start();
require_once '../base_de_datos/conexion.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario  = trim($_POST['usuario']  ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($usuario))  $errores[] = 'El nombre de usuario es obligatorio.';
    if (empty($password)) $errores[] = 'La contraseña es obligatoria.';

    if (empty($errores)) {
        $conn = conectar();
        $stmt = $conn->prepare('SELECT id, password, rol FROM usuarios WHERE usuario = ? AND activo = 1');
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hash, $rol);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                $_SESSION['usuario_id'] = $id;
                $_SESSION['rol']        = $rol;
                header('Location: ../interfaz/index.html');
                exit;
            } else {
                $errores[] = 'Contraseña incorrecta.';
            }
        } else {
            $errores[] = 'Usuario no encontrado.';
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../interfaz/estilos.css">
</head>
<body>
    <div class="contenedor contenedor--pequeño">
        <h1>Iniciar Sesión</h1>

        <?php if ($errores): ?>
            <ul class="mensaje-error">
                <?php foreach ($errores as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario"
                   value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" required autofocus>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Ingresar</button>
        </form>

        <p><a href="../interfaz/index.html">← Volver al inicio</a></p>
    </div>
</body>
</html>
