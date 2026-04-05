-- Base de datos: universidad
-- Configuración para XAMPP / MySQL

CREATE DATABASE IF NOT EXISTS universidad
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE universidad;

-- Tabla de estudiantes
CREATE TABLE IF NOT EXISTS estudiantes (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    cedula      VARCHAR(20)  NOT NULL UNIQUE,
    nombre      VARCHAR(100) NOT NULL,
    apellido    VARCHAR(100) NOT NULL,
    correo      VARCHAR(150) NOT NULL UNIQUE,
    telefono    VARCHAR(20),
    carrera     VARCHAR(100),
    fecha_reg   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de usuarios (acceso al sistema)
CREATE TABLE IF NOT EXISTS usuarios (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    usuario     VARCHAR(80)  NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    rol         ENUM('admin','estudiante') DEFAULT 'estudiante',
    activo      TINYINT(1)   DEFAULT 1,
    creado_en   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de contacto / mensajes
CREATE TABLE IF NOT EXISTS contacto (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(150) NOT NULL,
    correo      VARCHAR(150) NOT NULL,
    asunto      VARCHAR(200),
    mensaje     TEXT         NOT NULL,
    enviado_en  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
