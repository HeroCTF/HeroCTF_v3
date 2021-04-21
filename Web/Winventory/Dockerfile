FROM php:7.2-apache

RUN apt update
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY ./src/ /var/www/html
COPY ./flag.txt /client_accounting_secret.txt
RUN chmod 444 /client_accounting_secret.txt