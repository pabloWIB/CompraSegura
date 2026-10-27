FROM php:8.3-apache
RUN docker-php-ext-install mysqli pdo_mysql
COPY deploy/php.ini /usr/local/etc/php/conf.d/compraseguras.ini
COPY conexion.php registro.php login.php buscar_producto.php pedido.php /var/www/html/
