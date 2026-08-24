CREATE DATABASE negocioseguro;
USE negocioseguro;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50),
    clave VARCHAR(50)
);

INSERT INTO usuarios (usuario, clave) VALUES
('admin', 'admin123'),
('jperez', 'miclave2024');

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    precio DECIMAL(10,2),
    descripcion TEXT
);

INSERT INTO productos (nombre, precio, descripcion) VALUES
('Pan francés', 3000, 'Pan artesanal recién horneado'),
('Torta de chocolate', 45000, 'Torta de chocolate para 8 personas'),
('Croissant', 4500, 'Croissant de mantequilla');

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    producto_id INT,
    cantidad INT,
    total DECIMAL(10,2),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);