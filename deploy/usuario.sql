CREATE USER 'negocioseguro_app'@'localhost' IDENTIFIED BY 'ClaveSegura123!';
GRANT SELECT, INSERT, UPDATE ON compraseguras.* TO 'negocioseguro_app'@'localhost';
