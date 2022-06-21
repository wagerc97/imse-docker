# Alpine Linux with OpenJDK JRE
FROM openjdk:latest
COPY  ./build/libs /usr/app
WORKDIR /usr/app
ENTRYPOINT ["java", "-jar", "dbFilling.jar"]
