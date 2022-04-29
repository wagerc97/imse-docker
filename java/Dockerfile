#FROM openjdk:8-jdk-alpine
#RUN addgroup -S spring && adduser -S spring -G spring
#USER spring:spring
#ARG JAR_FILE=target/*.jar
#COPY ${JAR_FILE} app.jar
#ENTRYPOINT ["java","-jar","/app.jar"]



#get the latest java image
#FROM java:8
FROM openjdk:8
COPY . /var/java
WORKDIR /var/java/src

# installs driver to base dir :/
#RUN curl -L -o /mysql-connector-java-5.1.34.jar https://repo1.maven.org/maven2/mysql/mysql-connector-java/5.1.34/mysql-connector-java-5.1.34.jar
#ENV CLASSPATH=/mysql-connector-java-5.1.34.jar:${CLASSPATH}
#CMD echo "hello world"
# compile  java code
CMD javac Main.java
# run java code
RUN java Main


# run.sh
ENTRYPOINT ["run.sh"]


# maven

