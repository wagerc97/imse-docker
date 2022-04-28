#!/bin/sh

# starting point for this image is the (latest) mysql image 
FROM mysql

# Create the working directory (safer with -p flag)
#RUN mkdir -p /docker/src/app

# Set a working directory 
# all other command will take place here
#WORKDIR usr/src/app/

# Automatically create a database
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_PASSWORD=imse4eva
ENV MYSQL_DATABASE PharmaComp

# Copy the scripts to docker-entrypoint-initdb.d/ which will be
#  automatically exectuted during container startup
#  Make a folder "scripts" which contains
#  * the DROP and CREATE scripts 
#  * optionally INSERT for debugging 
COPY ./scripts /docker-entrypoint-initdb.d

#ADD scripts/DROP_PharmaComp.sql /docker-entrypoint-initdb.d/
#ADD scripts/CREATE_PharmaComp.sql /docker-entrypoint-initdb.d/

RUN chown -R mysql:mysql /docker-entrypoint-initdb.d/

# Execute command after container startup
#CMD ["mysqld", "--character-set-server=utf8mb4", "--collation-server=utf8mb4_unicode_ci"]

#CMD ["mysqld", "DROP_PharmaComp.sql"] 
#CMD ["mysqld", "CREATE_PharmaComp.sql"] 
