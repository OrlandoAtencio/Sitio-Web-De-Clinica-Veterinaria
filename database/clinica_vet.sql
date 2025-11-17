-- -----------------------------------------------------------
-- Crear base de datos
-- -----------------------------------------------------------
CREATE DATABASE IF NOT EXISTS clinica_vet;
USE clinica_vet;

-- -----------------------------------------------------------
-- Tabla de usuarios (login del sistema)
-- -----------------------------------------------------------
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'veterinario', 'asistente') DEFAULT 'veterinario',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------------
-- Tabla de pacientes
-- -----------------------------------------------------------
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raza VARCHAR(100),
    edad INT,
    sexo ENUM('M', 'H'),
    nombre_dueno VARCHAR(150),
    telefono_dueno VARCHAR(20),
    direccion TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------------
-- Tabla de consultas (historial de citas del paciente)
-- -----------------------------------------------------------
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    fecha DATETIME NOT NULL,
    motivo TEXT,
    diagnostico TEXT,
    tratamiento TEXT,
    costo DECIMAL(10,2),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_consulta_paciente
        FOREIGN KEY (id_paciente)
        REFERENCES pacientes(id)
        ON DELETE CASCADE
);
