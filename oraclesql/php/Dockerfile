# build custom php image from base image php:8.1-apache
FROM php:8.1-apache
RUN apt-get update && apt-get upgrade -y

# install oracle sql extension for php
# enables php to connect to oracle sql db
RUN docker-php-ext-install OCI8

# expose Port
EXPOSE "80"
