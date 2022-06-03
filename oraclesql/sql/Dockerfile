# base image
FROM oraclelinux:8

# Automatically create a database
ENV ORACLE_ROOT_PASSWORD=imse4eva
ENV ORACLE_USER=devuser
ENV ORACLE_PASSWORD=devpass
ENV ORACLE_DATABASE PharmaComp

COPY scripts /docker-entrypoint-initdb.d
