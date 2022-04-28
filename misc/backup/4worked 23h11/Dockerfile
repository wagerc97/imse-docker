#!/bin/sh

# starting point for this image is the (latest) mysql image 
# base image
FROM mysql

# Create the working directory (safer with -p flag)
# best practice
#RUN mkdir -p /usr/src/app

# Set a working directory 
# all other command will take place here
#WORKDIR usr/src/app/

# Automatically create a database
ENV MYSQL_ROOT_PASSWORD=root
#ENV MYSQL_USER=user
ENV MYSQL_PASSWORD=imse4eva
ENV MYSQL_DATABASE PharmaComp

# Copy the scripts to docker-entrypoint-initdb.d/ which will be
#  automatically exectuted during container startup
#  Make a folder "scripts" which contains
#  * the DROP and CREATE scripts 
#  * optionally INSERT for debugging 
COPY ./scripts /docker-entrypoint-initdb.d

RUN chown -R mysql:mysql /docker-entrypoint-initdb.d/
