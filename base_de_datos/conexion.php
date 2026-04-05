<?php
/**
 * conexion.php
 * Configuración de conexión a MySQL con XAMPP.
 * Incluir este archivo en cada formulario PHP.
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // usuario por defecto en XAMPP
define('DB_PASS', '');           // contraseña por defecto en XAMPP (vacía)
define('DB_NAME', 'universidad');

function conectar(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}
