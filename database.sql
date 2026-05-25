
CREATE DATABASE IF NOT EXISTS dulceria_db;
USE dulceria_db;

CREATE TABLE IF NOT EXISTS categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS marca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    marca_id INT DEFAULT NULL,
    nombre VARCHAR(255) NOT NULL,
    imagen_frontal VARCHAR(255) NOT NULL,
    imagen_trasera VARCHAR(255) DEFAULT NULL,
    descripcion TEXT DEFAULT NULL,
    likes INT DEFAULT 0,
    FOREIGN KEY (categoria_id) REFERENCES categoria(id) ON DELETE CASCADE,
    FOREIGN KEY (marca_id) REFERENCES marca(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios (username, password) VALUES 
('frankmanager38', '$2y$10$YQANdc5VZVDCBB1tUNQgcu6OT69GQ3q.pjCFeRuUJFP.9M1jEyUhu');

INSERT INTO categoria (nombre) VALUES 
('Chocolates'), ('Gomitas'), ('Paletas'), ('Picositos'), ('Tamarindo');

INSERT INTO marca (nombre) VALUES 
('Hershey´s'), ('Snickers'), ('M&M´s'), ('Carlos V'), ('Trident'), ('De La Rosa'), ('Ricolino');
