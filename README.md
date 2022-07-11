# IMSE docker project
## Project for 052400 VU Information Management & Systems Engineering (2022S)

---

## Introduction
The web application centers around a company and enables not only registration of products and clients but also gives insight on the company's business. For detailed information on the domain see the submitted PDF file “M1_FILLIES_WAGER_IMSE_SS22_corrected.pdf”.

---

# System deployment
## Required libraries (automatically installed on Docker)
- 	Flask: Python Based mini-Webframework
- 	MongoDB: Database Server
- 	Pymongo: Database Connector (to establish connectiong between MongoDB and Flask)
- 	HTML5 (jinja2): For Form and Table
- mysqli: for communication between PHP and MySQL
- mysql-connector: for communication between Python and MySQL

## Start Docker container 
1. Navigate to the project folder where docker-compose.yaml lies
2. Build and start container <br>
   ``docker-compose up --build``

The resulting Webapplication hosts the NoSQL interface on http://127.0.0.1:5000/ and the SQL interface on http://127.0.0.1:8000/. Open these addresses in a Webbrowser.    

---
## Deployment on Windows system 

On Windows 10-Home OS
- install Docker Desktop
- enable WSL 2 Linux kernel required by Docker Desktop as Docker asks the user (see [Manual](https://docs.microsoft.com/de-de/windows/wsl/install-manual#step-4---download-the-linux-kernel-update-package))
- log into DockerHub through CLI of host pc with arbitrary account 
  ``docker login`` and enter your credientials 
- download project folder 
- navigate CLI to project folder and compose container 
  ``docker-compose up --build``

