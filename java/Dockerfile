#FROM java:8
FROM openjdk:8
#COPY . /var/java
COPY /java /var/java
WORKDIR /var/java/src

# installs driver to base dir :/
RUN curl -L -o /mysql-connector-java-5.1.34.jar https://repo1.maven.org/maven2/mysql/mysql-connector-java/5.1.34/mysql-connector-java-5.1.34.jar
ENV CLASSPATH=/mysql-connector-java-5.1.34.jar:${CLASSPATH}

# run.sh
CMD ["./run.sh"]
