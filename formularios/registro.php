<?php
/**
 * registro.php
 * Formulario de registro de estudiantes.
 */
require_once '../base_de_datos/conexion.php';

$errores = [];
$exito   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula   = trim($_POST['cedula']   ?? '');
    $nombre   = trim($_POST['nombre']   ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $correo   = trim($_POST['correo']   ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $carrera  = trim($_POST['carrera']  ?? '');

    // Validaciones básicas
    if (empty($cedula))   $errores[] = 'La cédula es obligatoria.';
    if (empty($nombre))   $errores[] = 'El nombre es obligatorio.';
    if (empty($apellido)) $errores[] = 'El apellido es obligatorio.';
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El correo electrónico no es válido.';
    }

    if (empty($errores)) {
        $conn = conectar();
        $stmt = $conn->prepare(
            'INSERT INTO estudiantes (cedula, nombre, apellido, correo, telefono, carrera)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('ssssss', $cedula, $nombre, $apellido, $correo, $telefono, $carrera);
        if ($stmt->execute()) {
            $exito = '¡Estudiante registrado exitosamente!';
        } else {
            $errores[] = 'Error al guardar: ' . $conn->error;
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
    <title>Registro de Estudiante</title>
    <link rel="stylesheet" href="../interfaz/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h1>Registro de Estudiante</h1>

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

        <form method="POST" action="registro.php" novalidate>
            <label for="cedula">Cédula *</label>
            <input type="text" id="cedula" name="cedula"
                   value="<?= htmlspecialchars($_POST['cedula'] ?? '') ?>" required>

            <label for="nombre">Nombre *</label>
            <input type="text" id="nombre" name="nombre"
                   value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>

            <label for="apellido">Apellido *</label>
            <input type="text" id="apellido" name="apellido"
                   value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>" required>

            <label for="correo">Correo electrónico *</label>
            <input type="email" id="correo" name="correo"
                   value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>" required>

            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono"
                   value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

            <label for="carrera">Carrera</label>
            <input type="text" id="carrera" name="carrera"
                   value="<?= htmlspecialchars($_POST['carrera'] ?? '') ?>">

            <button type="submit">Registrar</button>
        </form>

        <p><a href="../interfaz/index.html">← Volver al inicio</a></p>
    </div>
</body>
</html>
