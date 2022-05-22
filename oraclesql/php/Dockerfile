# build custom php image from base image php:8.1-apache
FROM php:8.1-apache
RUN apt-get update && apt-get upgrade -y

#install mysql extension for php
#Oracle Call Interface (OCI)
RUN docker-php-ext-install oci8

#expose Port
EXPOSE "80"
