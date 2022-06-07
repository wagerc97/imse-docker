# IMSE - Information Management and Systems Engineering 
### Goal: 
Create a Docker that hosts a database modelled after business domain, php script for web application and 
a java/python program to populate the db.

### Status quo:
* Docker starts up via base image -> custom image -> container 
* For deployment follow commands in [DEPLOYMENT.txt](./DEPLOYMENT.md)
  * to deploy with LOCAL files: [docker-compose-local.yml](/compose/oraclesql-comp/docker-compose-local.yml)
  * to deploy with REMOTE files: [docker-compose-remote.yml](/compose/oraclesql-comp/docker-compose-remote.yml)
* Tables created and populated with test data (for now #TODO)
* DB and webapp connected, but db content not displayed properly, but some select-statements yield a result that is shown.
* Java code is running on Docker, but no connection to db
---
### TODO ad hoc:
* Fix ``ERROR 12545 : Connect failed because target host or object doesn't exist while trying to connect sqlplus``
  * Given in error log  
    (DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=locahost)(Port=1521))(CONNECT_DATA=(SID=oraclesql8)(CID=(PROGRAM=sqlplus)(HOST=e4eb67d8fa54)(USER=root))))
  * Ich kann mich zwar per sqlplus mit ??? auf dem docker verbinden, aber ich kann im ``SQL>`` nichts machen (Kein Login, etc.)
  * Default $ORACLE_HOME is fine - dont set a new env variable 

* Fix ``ORA-12541: TNS:no listener``  
  * maybe will be resolve with tnsnames.ora...

* Fix ``ORA-12162: TNS:net service name is incorrectly specified.``  
  * Solution: manually create tnsnames.ora path /usr/lib/oracle/19.15/client64/lib/network/admin
  * already wrote copy command in sql/Dockerfile

* Configure sqlnet.ora to use JDBC
* IMPORTANT: Can I even create/host/access a DB via an Oracle instantclient???  
  * https://stackoverflow.com/questions/43012593/how-to-add-a-local-database-by-oracle-instant-client-on-mac
  * the sql scirpts were never executed according to the docker logs
  * Fix? - Try to to upgrade my old oracle sql image -> [Stackoverflow](https://stackoverflow.com/questions/58857476/how-to-use-sqlplus-on-oracle-database-inside-a-docker-container)
  * COPY and RUN 

### TODO general:
* establish connection between java and mysql -> forget it -> soon we will work on MongoDB
    * already adapted docker-compose.yml
    * Java app runs before db is setup
    
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
- webinterface mit db verknüpfen
- daten von SQL auf NoSQL migrieren
- daten in nosql db importieren (java / python)
     - auf knopfdruck <br>
...
- report schreiben
- gui aufpolieren








