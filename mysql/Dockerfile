# base image
FROM mysql:8.0
WORKDIR ../mysql

# Automatically create a database
ENV MYSQL_ROOT_PASSWORD=imse4eva
ENV MYSQL_USER=devuser
ENV MYSQL_PASSWORD=devpass
ENV MYSQL_DATABASE PharmaComp

COPY ./scripts /docker-entrypoint-initdb.d
