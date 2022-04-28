## /imse
### Goal: 
Create a Docker that hosts a database, php script for web application and a java program to populate the db.

### Status quo:
* Docker starts up via base image -> custom image -> container 
* For deployment follow commands in [DEPLOYMENT.txt](./DEPLOYMENT.txt)
* Tables created and populated with test data (for now #TODO)
* DB and webapp connected, but db content not displayed properly, but some select-statements yield a result that is shown.
---
### TODOs:
* establish connection between java and mysql 
    * already adapted docker-compose.yml
        * for LOCAL: [docker-compose-local.yml](docker-compose-local.yml)
        * for REMOTE: [docker-compose-remote.yml](docker-compose-remote.yml)
    * TestConnection class in java created 
    
