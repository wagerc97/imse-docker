Docker Readme

### Create Container ### 
1.	Navigate to right folder:
		$ cd /dockerprojects/imse/
		
1.1 Build the image (ony my PC -> terminal must be in dir of 	
		Dockerfile !!!)
		$ docker build . -f Dockerfile -t custom_mysql
		
		(optional) Check images
		$ docker images
		
		(optional) Look at Dockerfile:
		$ Get-Content /dockerprojects/imse/Dockerfile 
		
2.	Build the container from this image (-d for detached mode -> supress logs)
		$ docker-compose -f docker-compose-so.yml up
		

### Use existing Container ###
1.  Start official docker-application to make Docker Daemon available

2.  Open Terminal

3.  docker run --name custom_mysql_cont -e MYSQL_ROOT_PASSWORD=imse4eva -d mysql
    >> b18a0eb4151fd5f7af5804c881aff60657a4263de183eb06209a5576bf5bbb03
		
4.  (optional) Check running containers
    $ docker ps
		
5.  Query the DB inside the docker.

5.1 Enter the docker:
    $ docker exec -it imse_mysql_dev_1 bash

5.2	Log into mysql
		$ mysql -uroot -p
		password: imse4eva
		
5.3	MySQL commands:
		mysql> show databases;
		mysql> use PharmaComp;
		mysql> show tables;
		