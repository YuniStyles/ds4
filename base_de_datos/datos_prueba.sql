-- Datos de prueba
-- Ejecutar después de schema.sql

USE universidad;

-- Usuario administrador (password: admin123)
INSERT INTO usuarios (usuario, password, rol) VALUES
('admin', '$2y$10$EIFo6UcDFQM3v.kwBjVqse8rPVAtPiXrjU5yH1USpvMrPdSRWTqOq', 'admin');

-- Estudiantes de prueba
INSERT INTO estudiantes (cedula, nombre, apellido, correo, telefono, carrera) VALUES
('8-123-456', 'Juan',   'Pérez',    'juan.perez@utp.ac.pa',   '6000-1111', 'Ingeniería en Sistemas'),
('8-234-567', 'María',  'González', 'maria.gonzalez@utp.ac.pa','6000-2222', 'Licenciatura en Informática'),
('8-345-678', 'Carlos', 'Rodríguez','carlos.r@utp.ac.pa',      '6000-3333', 'Ingeniería Industrial');
