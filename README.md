## /imse
### Goal: 
Create a Docker that hosts a database, php script for web application and a java program to populate the db.

### Status quo:
* Docker starts up via base image -> custom image -> container 
* For deployment follow commands in [DEPLOYMENT.txt](./DEPLOYMENT.txt)
  * for LOCAL: [docker-compose-local.yml](docker-compose-local.yml)
  * for REMOTE: [docker-compose-remote.yml](docker-compose-remote.yml)
* Tables created and populated with test data (for now #TODO)
* DB and webapp connected, but db content not displayed properly, but some select-statements yield a result that is shown.
* Java code is running on Docker, but no connection to db
---
### TODOs:
* establish connection between java and mysql -> forget it -> soon we will work on MongoDB
    * already adapted docker-compose.yml
    * Java app runs befor db is setup
    
---
### Next steps after meeting 29.04.2022
-	noSql design in MongoDB implementieren
-	mongoDB docker container
-	webinterface mit db verknüpfen
-	daten generieren für nosql
-	daten in nosql db importieren (java / python)
     - auf knopfdruck <br>
...
-	report schreiben
-	gui aufpolieren