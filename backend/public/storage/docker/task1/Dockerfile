# Файл Dockerfile-app

# Используем PHP 5.6 с Apache в качестве базового образа
FROM php:7.3-apache

# Подключаем модуль Apache Rewrite
RUN cd /etc/apache2/mods-enabled && \
    ln -s ../mods-available/rewrite.load

# Устанавливаем требуемые расширения PHP
# -- GD
RUN apt-get update && \
    apt-get install -y libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ && \
    docker-php-ext-install -j$(nproc) gd
# -- mysql
RUN docker-php-ext-install -j$(nproc) mysqli pdo_mysql
