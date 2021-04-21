FROM php:7.2-apache

RUN apt update
RUN docker-php-ext-install mysqli pdo pdo_mysql

ADD ./src/ /var/www/html/
RUN cp /var/www/html/login.php cp /var/www/html/login.php.bak