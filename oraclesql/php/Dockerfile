# build custom php image from base image...
# php:8.1-apache -> php only
#FROM php:8.1-apache

# adrianharabula/php7-with-oci8 -> php with oci8 extension
FROM adrianharabula/php7-with-oci8

#RUN apt-get update && apt-get upgrade -y

# install oracle sql extension for php
# OCI8 enables php to connect to oracle sql db
#TODO: install an extension
# TODO: ideas
# 1) download OCI8 manually - place it in /oraclesql/php/ext - docker-php-ext-install installs from dir
# 2) use different php image with pecl as it is easier to install stuff with it


#RUN docker-php-ext-install OCI8
#RUN docker-php-ext-configure oci8

# expose Port
EXPOSE "80"
