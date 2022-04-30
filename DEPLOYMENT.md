### Start Docker container from local repository ###
1. Navigate to whole project folder where docker-compose-local.yml is
2. Build and start container <br>
   ``docker-compose -f docker-compose-local.yml up``

 
Resulting locally hosed [Webapplication](http://127.0.0.1:8000/)

### Start Docker container from remote git repository ###
#### See: https://docs.docker.com/engine/reference/commandline/build/#git-repositories
1. Navigate to project folder where docker-compose-remote.yml is
2. Run the following command in CLI <br>
   ``docker-compose -f docker-compose-remote.yml up``


Resulting locally hosed [Webapplication](http://127.0.0.1:8000/)

---
### Deployment on fresh system with remote repository
On Windows 10-Home OS
- install Docker Desktop
- enable WSL 2 Linux kernel required by Docker Desktop as Docker asks the user (see [Manual](https://docs.microsoft.com/de-de/windows/wsl/install-manual#step-4---download-the-linux-kernel-update-package))
- log into DockerHub through CLI of host pc with arbitrary account <br>
  ``docker login``
- download [docker-compose-remote.yml](docker-compose-remote.yml) from [GitHub directory](https://github.com/wagerc97/imse-docker/blob/master/docker-compose-remote.yml)
- navigate CLI to yml file and compose container <br>
  ``docker-compose -f docker-compose-remote.yml up``
- Resulting locally hosed [Webapplication](http://127.0.0.1:8000/)