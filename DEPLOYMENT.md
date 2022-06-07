# DEPLOYMENT
## Start Docker container from local repository ###
1. Navigate to whole project folder where docker-compose-local.yml is
2. Build and start container <br>
   ``docker-compose -f docker-compose-local.yml up``

 
Resulting locally hosed [Webapplication](http://127.0.0.1:8000/)

## Start Docker container from remote git repository ###
#### See: https://docs.docker.com/engine/reference/commandline/build/#git-repositories
1. Navigate to project folder where docker-compose-remote.yml is
2. Run the following command in CLI <br>
   ``docker-compose -f docker-compose-remote.yml up``


Resulting locally hosed [Webapplication](http://127.0.0.1:8000/)

---
## Deployment on fresh system with remote repository
On Windows 10-Home OS
- install Docker Desktop
- enable WSL 2 Linux kernel required by Docker Desktop as Docker asks the user (see [Manual](https://docs.microsoft.com/de-de/windows/wsl/install-manual#step-4---download-the-linux-kernel-update-package))
- log into DockerHub through CLI of host pc with arbitrary account <br>
  ``docker login`` <br> and enter your credientials 
- download [docker-compose-remote.yml](compose/oraclesql-comp/docker-compose-remote.yml) from [GitHub directory](https://github.com/wagerc97/imse-docker/tree/master/compose)
- navigate CLI to yml file and compose container <br>
  ``docker-compose -f docker-compose-remote.yml up``
- Resulting locally hosed [Webapplication](http://127.0.0.1:8000/)

---
## Check system commands
### Oracle SQL

1. open terminal
2. type ``docker ps`` to check which containers are running right now
3. type either  
   `` docker exec -it oraclesql8 bash``  
      you are now in the db-docker (...sql8 is the container name)
4. Check if listeners are up and running  
  ``lsnrctl status`` -> bash: lsnrctl: command not found
6. Navigate with sqlplus --> following: https://docs.oracle.com/cd/A97630_01/win.920/a95490/username.html   
   1. To starts SQL*Plus without a database connection: ``sqlplus /NOLOG``  

Tried to fix the ORA-12162 error: http://www.dba-oracle.com/t_ora_12162_tns_net_service_name.htm
> ORACLE_HOME=/u01/oracle; export ORACLE_HOME  
> ORACLE_SID=asdb; export ORACLE_SID

Cannot connect though:
sqlplus connect sys as sysdba -> 
#
#
> sqlplus /nolog  
>> enter SQL cli 

> sqlplus devuser/devpass@IMSEDB 
>> really nothing happens...no commands work anymore

> **SQL>** connect sys as sysdba  
>> Enter password: ...?

> **SQL>** SELECT TABLESPACE_NAME FROM USER_TABLESPACES;  
> Oracle uses shemas and not databases like mysql.
>> SP2-0640: Not connected  
>> -> because "The Oracle Listener process was not successfully created.
This error indicates that the TNSNAMES.ora file was not created during the installation process.
"


5. Some commands to look through the DBMS:   
   If the tables are filled, the DB setup was successful!  
   1. To enter sqlplus CLI: ``sqlplus /NOLOG``

---
``[root@e4eb67d8fa54 lib]# ls``
>glogin.sql         libclntsh.so.11.1  libclntsh.so.19.1      libipc1.so   libocci.so.19.1  liboramysql19.so  network         xstreams.jar
libclntsh.so       libclntsh.so.12.1  libclntshcore.so       libmql1.so   libociei.so      libsqlplus.so     ojdbc8.jar
libclntsh.so.10.1  libclntsh.so.18.1  libclntshcore.so.19.1  libnnz19.so  libocijdbc19.so  libsqlplusic.so   ottclasses.zip

``[root@e4eb67d8fa54 lib]# pwd``
>/lib/oracle/19.15/client64/lib


***********************************************************************  

>Fatal NI connect error 12545, connecting to:
(DESCRIPTION=(ADDRESS=(PROTOCOL=beq)(PROGRAM=/u01/oracle/product/PharmaComp/bin/oracle)(ARGV0=oracleorcl)(ARGS='(DESCRIPTION=(LOCAL=YES)(ADDRESS=(PROTOCOL=beq)))')(DETAC
H=NO))(CONNECT_DATA=(CID=(PROGRAM=sqlplus)(HOST=e4eb67d8fa54)(USER=root))))

>VERSION INFORMATION:
TNS for Linux: Version 19.0.0.0.0 - Production
Oracle Bequeath NT Protocol Adapter for Linux: Version 19.0.0.0.0 - Production
TCP/IP NT Protocol Adapter for Linux: Version 19.0.0.0.0 - Production
Version 19.15.0.0.0
Time: 05-JUN-2022 19:10:48
Tracing not turned on.
Tns error struct:
ns main err code: 12545

>TNS-12545: Message 12545 not found; No message file for product=network, facility=TNS
ns secondary err code: 12560
nt main err code: 515

>TNS-00515: Message 515 not found; No message file for product=network, facility=TNS
nt secondary err code: 2
nt OS err code: 0


``[root@e4eb67d8fa54 trace]# pwd``  
>/root/oradiag_root/diag/clients/user_root/host_4135610220_110/trace  


``[root@e4eb67d8fa54 admin]# more README``
>============================================================================
This is the default directory for Oracle Network and Oracle Client
configuration files. You can place files such as tnsnames.ora, sqlnet.ora
and oraaccess.xml in this directory.
NOTE:
If you set an environment variable TNS_ADMIN to another directory containing
configuration files, they will be used instead of the files in this default
directory.
============================================================================

``[root@e4eb67d8fa54 admin]# pwd``
>/usr/lib/oracle/19.15/client64/lib/network/admin













---
---
---

### MYSQL

1. open terminal
2. type ``docker ps`` to check which containers are running right now
3. type either  
   `` docker exec -it mysql8 bash``  
   you are now in the db-docker (...sql8 is the container name)
4. login into the database with   
   ``mysql -uroot -pimse4eva``  
5. Some commands to look through the DBMS:
   If the tables are filled, the DB setup was successful!
   1. ``show databases``
   2. ``use [database name]``
   3. ``show tables;``
   4. ``SELECT * FROM Product;``