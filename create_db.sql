CREATE DATABASE IF NOT EXISTS dulceria;
USE dulceria;

CREATE TABLE admin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL UNIQUE,
  contraseña VARCHAR(255) NOT NULL
);

INSERT INTO admin (email, contraseña) VALUES ('admin@dulceria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

CREATE TABLE categoria (
  id_categoria INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
);

CREATE TABLE marca (
  id_marca INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
);

CREATE TABLE producto (
  id_producto INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL,
  id_categoria INT,
  id_marca INT,
  imagen VARCHAR(255),
  stock INT NOT NULL DEFAULT 0,
  fecha_creacion DATE,
  FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria) ON DELETE SET NULL,
  FOREIGN KEY (id_marca) REFERENCES marca(id_marca) ON DELETE SET NULL
);

CREATE TABLE mensajes_contacto (
  id_mensaje INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  mensaje TEXT NOT NULL,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categoria (nombre) VALUES 
('Chocolates'), 
('Gomitas'), 
('Caramelos');

INSERT INTO marca (nombre) VALUES 
('Hershey'), 
('Vero'), 
('Lucas');

INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_marca, imagen, stock, fecha_creacion) VALUES
('Chocolate Hershey', 'Chocolate con leche', 25.50, 1, 1, 'hershey.jpg', 10, NOW()),
('Gomitas Vero', 'Gomitas ácidas', 15.00, 2, 2, 'gomas.jpg', 20, NOW()),
('Paleta Lucas', 'Paleta de mango con chile', 12.00, 3, 3, 'lucas.jpg', 30, NOW());