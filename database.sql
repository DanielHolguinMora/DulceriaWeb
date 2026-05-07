CREATE DATABASE IF NOT EXISTS dulceria_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dulceria_db;

CREATE TABLE IF NOT EXISTS categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    imagen_frontal VARCHAR(255) NOT NULL,
    imagen_trasera VARCHAR(255) DEFAULT NULL,
    descripcion TEXT,
    stock INT DEFAULT 0,
    FOREIGN KEY (categoria_id) REFERENCES categoria(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO categoria (nombre) VALUES ('Gomitas'), ('Chocolates'), ('Picantes'), ('Caramelos');

INSERT INTO productos (categoria_id, nombre, precio, imagen_frontal, imagen_trasera, descripcion, stock) VALUES 
(1, 'Ositos de Goma 1kg', 120.00, 'front1.jpg', 'back1.jpg', 'Deliciosos ositos de goma de sabores frutales.', 50),
(2, 'Chocolate Relleno', 85.50, 'front2.jpg', 'back2.jpg', 'Chocolate con leche relleno de caramelo suave.', 30),
(3, 'Tamarindo Picante', 45.00, 'front3.jpg', 'back3.jpg', 'Dulce de tamarindo con un toque de chile.', 100);


INSERT INTO usuarios (username, password) VALUES ('admin', '$2y$10$S9Q.j8R2T/QhWzD5rRk/O.G1fN0yU4W5G1z8iRk/O.G1fN0yU4W5G'); 

UPDATE usuarios SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE username = 'admin';
