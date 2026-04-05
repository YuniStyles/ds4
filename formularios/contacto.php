<?php
/**
 * contacto.php
 * Formulario de contacto / mensajes.
 */
require_once '../base_de_datos/conexion.php';

$errores = [];
$exito   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = trim($_POST['nombre']  ?? '');
    $correo  = trim($_POST['correo']  ?? '');
    $asunto  = trim($_POST['asunto']  ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (empty($nombre))  $errores[] = 'El nombre es obligatorio.';
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El correo electrónico no es válido.';
    }
    if (empty($mensaje)) $errores[] = 'El mensaje no puede estar vacío.';

    if (empty($errores)) {
        $conn = conectar();
        $stmt = $conn->prepare(
            'INSERT INTO contacto (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)'
        );
        $stmt->bind_param('ssss', $nombre, $correo, $asunto, $mensaje);
        if ($stmt->execute()) {
            $exito = '¡Mensaje enviado correctamente!';
        } else {
            $errores[] = 'Error al enviar el mensaje: ' . $conn->error;
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
    <title>Contacto</title>
    <link rel="stylesheet" href="../interfaz/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h1>Contáctanos</h1>

        <?php if ($exito): ?>
            <p class="mensaje-exito"><?= htmlspecialchars($exito) ?></p>
        <?php endif; ?>

        <?php if ($errores): ?>
            <ul class="mensaje-error">
                <?php foreach ($errores as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="POST" action="contacto.php" novalidate>
            <label for="nombre">Nombre *</label>
            <input type="text" id="nombre" name="nombre"
                   value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>

            <label for="correo">Correo electrónico *</label>
            <input type="email" id="correo" name="correo"
                   value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>" required>

            <label for="asunto">Asunto</label>
            <input type="text" id="asunto" name="asunto"
                   value="<?= htmlspecialchars($_POST['asunto'] ?? '') ?>">

            <label for="mensaje">Mensaje *</label>
            <textarea id="mensaje" name="mensaje" rows="5" required><?= htmlspecialchars($_POST['mensaje'] ?? '') ?></textarea>

            <button type="submit">Enviar mensaje</button>
        </form>

        <p><a href="../interfaz/index.html">← Volver al inicio</a></p>
    </div>
</body>
</html>
