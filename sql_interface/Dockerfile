# build custom php image from base image php:8.1-apache
FROM php:8.1-apache
RUN apt-get update && apt-get upgrade -y

#install mysql extension for php (enables their communication)
RUN docker-php-ext-install mysqli
