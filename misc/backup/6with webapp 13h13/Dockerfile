#!/bin/sh

# starting point for this image is the (latest) mysql image 
# base image
FROM mysql:8.0

# Create the working directory (safer with -p flag)
# best practice
RUN mkdir -p /myapp

# Set a working directory 
# all following commands will be run here
WORKDIR /myapp

# Automatically create a database
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_USER=user
ENV MYSQL_PASSWORD=imse4eva
ENV MYSQL_DATABASE PharmaComp

# Copy the scripts to docker-entrypoint-initdb.d/ which will be
#  automatically exectuted during container startup
#  Make a folder "scripts" which contains
#  * CREATE scripts 
#  * INSERT -> for DEBUGGING
COPY ./scripts /docker-entrypoint-initdb.d
