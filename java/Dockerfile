#!/bin/sh

#get the latest java image
FROM java:8

COPY . /var/java

WORKDIR /var/java/src

RUN javac Main.java

#CMD ["java", "-classpath", "mysql-connector-java-5.1.6.jar:.","DockerConnectMySQL"]
CMD ["java", "-classpath", "mysql-connector-java-5.1.6.jar:.","Main"]

