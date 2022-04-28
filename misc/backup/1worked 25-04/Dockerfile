# starting point for this image is the (latest) mysql image 
FROM mysql

# Create a working directory 
#WORKDIR /dockerprojects/imse

# Automatically create a database
ENV MYSQL_DATABASE PharmaComp

# Copy the scripts to docker-entrypoint-initdb.d/ which will be
# automatically exectuted during container startup
# Make a folder "scripts" which contains
# - the DROP and CREATE scripts 
# - optionally INSERT for debugging 
COPY ./scripts/ /docker-entrypoint-initdb.d/