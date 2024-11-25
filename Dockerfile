FROM php:8.1-apache

# Instalar extensiones necesarias para PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql