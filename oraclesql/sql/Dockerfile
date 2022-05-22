# only oracle w/ sqlplus, no oci support
#FROM oraclelinux:8

# some package with sqlplus and OCI support (from Oracle's GitHub)
FROM ghcr.io/oracle/oraclelinux8-instantclient:19

# for OCI (from Dockerhub?)
#FROM oracle/instantclient:21

# Automatically create a database
ENV MYSQL_ROOT_PASSWORD=imse4eva
ENV MYSQL_USER=devuser
ENV MYSQL_PASSWORD=devpass
ENV MYSQL_DATABASE PharmaComp

COPY scripts /docker-entrypoint-initdb.d
