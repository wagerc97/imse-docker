# IMSE - Information Management and Systems Engineering 
### Goal: 
Create a Docker that hosts a database modelled after business domain, php script for web application and 
a java/python program to populate the db.

### Status quo:
* Docker starts up via base image -> custom image -> container 
* For deployment follow commands in [DEPLOYMENT.txt](./DEPLOYMENT.md)
  * to deploy with LOCAL files: [docker-compose-local.yml](/compose/oraclesql-comp/docker-compose-local.yml)
  * to deploy with REMOTE files: [docker-compose-remote.yml](/compose/oraclesql-comp/docker-compose-remote.yml)
* DB can be setup and is populated on docker startup.
* ok also der php Part kann auf die DB zugreifen wenn die server credentials im Klartext hard coded sind. Aber das ist doof und ich kanns nicht auf Github sharen.
---
    
---
### Next steps after meeting 07.06.2022
# Schlachtplan
- [Claas] noSql design von Claas in MongoDB implementieren --> fertige aber leere DB  
- [Claas] DB befüllen mit Testdaten --> Gefühl für Daten bekommen und 
- [Claas] mongoDB auf docker container setzen  

  
- [Clemens] ORacle sql auf docker fertig bauen --> moodle und Prof helfen 
- [Clemens] Daten import 
- [Clemens] Main Use Cases implementieren
--- 
- [ ? ] db_import auf Knopfdruck in gui ausführen und nicht beim Docker startup (siehe Moodle Forum)


---
- webinterface mit db verknüpfen
- daten von SQL auf NoSQL migrieren
- daten in nosql db importieren (java / python)
     - auf knopfdruck <br>
...
- report schreiben
- gui aufpolieren








