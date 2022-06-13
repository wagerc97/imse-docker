# base image
FROM mysql:8.0

# Automatically create a database
ENV MYSQL_ROOT_PASSWORD=imse4eva
ENV MYSQL_USER=devuser
ENV MYSQL_PASSWORD=devpass
ENV MYSQL_DATABASE PharmaComp

#WORKDIR /mysql/sql/
COPY scripts /docker-entrypoint-initdb.d
