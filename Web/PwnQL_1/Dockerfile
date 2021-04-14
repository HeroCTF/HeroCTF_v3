FROM php:7.2-apache

RUN apt update
RUN docker-php-ext-install mysqli pdo pdo_mysql

ADD ./src/ /var/www/html/
