#!/usr/bin/env python3

import os
import time
import csv
import logging
import mysql.connector as connector
from mysql.connector import Error
from dropper import drop_all_tables
from decouple import config
import pandas as pd

logging.basicConfig(level=logging.INFO)


#############################
#   ESTABLISH CONNECTION    #
#############################

again = True; retry = 5; attempt = 0
while(again and attempt < retry):
    attempt +=1 
    try:
        user = config('USER',default='')
        password = config('PASSWORD',default='')
        host = config('SERVER',default='')
        db_name = config('DB_NAME',default='')
        port = config('PORT',default='')

        conn = connector.connect( user=user, password=password, host=host, database=db_name, port=port )
        again = False

    except Error as e: 
        print(f"[ERROR]Connection failed! Let's try again [{attempt}] ->", e)
        time.sleep(2)
        again = True

if attempt >= retry:
    print(f"[FATAL ERROR]Tried {retry} times to establish connection to DB. End program.")
    conn.close()
    raise SystemExit

else: 
    again = False
    print("[INFO]Connection to DB successful!")



#####################
#### MAIN METHOD ####
try:
    # Creating a cursor object using the cursor() method
    cursor = conn.cursor()


    ######################
    #   CREATE TABLES    #
    ######################

    def create_tables():
        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS Client(
                ID_client          INTEGER AUTO_INCREMENT,
                Client_Name        VARCHAR(50) NOT NULL,
                Country_Name       VARCHAR(25) NOT NULL, -- FK
                CONSTRAINT PK_client PRIMARY KEY (ID_client)
            );
            '''
        cursor.execute(sql)

        # Dropping table if already exists.
        #cursor.execute("DROP TABLE IF EXISTS Product")

        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS Product(
                ID_product          INTEGER AUTO_INCREMENT,
                Product_Name        VARCHAR(50) UNIQUE NOT NULL,
                Price               DECIMAL(8,2) NOT NULL,
                Indication          VARCHAR(40) NOT NULL, 
                CONSTRAINT PK_product PRIMARY KEY (ID_product)
            );
        '''
        cursor.execute(sql)

        # Dropping table if already exists.
        #cursor.execute("DROP TABLE IF EXISTS Orders")

        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS Orders(
                ID_Orders          INTEGER AUTO_INCREMENT, -- GENERATED BY DEFAULT AS IDENTITY
                --                   (START WITH 1 INCREMENT BY 1), -- simple auto-increment
                ID_Product         INTEGER NOT NULL, -- FK
                ID_Client          INTEGER NOT NULL, -- FK
                Order_Date         DATE    NOT NULL, 
                Quantity           INTEGER NOT NULL,
                CONSTRAINT PK_orders PRIMARY KEY (ID_orders),
                CONSTRAINT quantity_range_check CHECK(Quantity >= 10 AND Quantity <= 999999)
            );
            '''
        cursor.execute(sql)

        # Dropping table if already exists.
        #cursor.execute("DROP TABLE IF EXISTS Campaign")

        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS Campaign(
                ID_Product          INTEGER NOT NULL, -- FK
                Campaign_Name       VARCHAR(40) NOT NULL, -- not UNIQUE because weak entity
                Start_date          DATE NOT NULL,
                End_date            DATE NOT NULL,
                CONSTRAINT PK_campaign PRIMARY KEY (ID_product, Campaign_Name),
                CONSTRAINT camp_date CHECK(Start_date < End_date) -- CHECK CONSTRAINT
            );
            '''
        cursor.execute(sql)

        # Dropping table if already exists.
        #cursor.execute("DROP TABLE IF EXISTS Employee")

        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS Employee(
                ID_employee         INTEGER AUTO_INCREMENT, -- GENERATED BY DEFAULT AS IDENTITY
                --                    (START WITH 1 INCREMENT BY 1),  -- simple auto-increment
                Firstname           VARCHAR(25) NOT NULL,
                Lastname            VARCHAR(25) NOT NULL,
                Gender              VARCHAR(1)  NOT NULL,
                Salary              DECIMAL(8,2) DEFAULT 1500,
                Team_leader         INTEGER, -- FK
                Hire_date           DATE NOT NULL, 
                CONSTRAINT PK_emp PRIMARY KEY (ID_employee),
                CONSTRAINT emp_gender CHECK(Gender IN ('F','M','D')) -- CHECK CONSTRAINT
            );
            '''
        cursor.execute(sql)


        # Dropping table if already exists.
        #cursor.execute("DROP TABLE IF EXISTS Marketing_emp")

        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS Marketing_emp(
                ID_employee     INTEGER, -- FK
                Occupation      VARCHAR(50),
                CONSTRAINT PK_mark PRIMARY KEY (ID_employee)
            );
            '''

        cursor.execute(sql)


        # Dropping table if already exists.
        #cursor.execute("DROP TABLE IF EXISTS Advertises")

        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS Advertises(
                ID_employee         INTEGER, -- FK
                ID_product          INTEGER, -- FK
                CONSTRAINT PK_adv PRIMARY KEY (ID_employee, ID_product)
            );
            '''
        cursor.execute(sql)


        # Dropping table if already exists.
        #cursor.execute("DROP TABLE IF EXISTS General_Manager")

        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS General_Manager(
                ID_employee         INTEGER, -- FK
                ID_region           INTEGER UNIQUE NOT NULL, -- FK 
                CONSTRAINT PK_GM PRIMARY KEY (ID_employee)
            );
            ''' 
        cursor.execute(sql)


        # Dropping table if already exists.
        #    cursor.execute("DROP TABLE IF EXISTS Region")

        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS Region(
                ID_region           INTEGER AUTO_INCREMENT, 
                Region_Name         VARCHAR(25) UNIQUE NOT NULL,
                CONSTRAINT PK_region PRIMARY KEY (ID_region)
            );
            '''
        cursor.execute(sql)


        # Dropping table if already exists.
        #cursor.execute("DROP TABLE IF EXISTS Country")

        # Creating table as per requirement
        sql = '''
            CREATE TABLE IF NOT EXISTS Country(
                Country_Name        VARCHAR(25) NOT NULL, -- PK
                ID_region           INTEGER NOT NULL,  -- FK
                CONSTRAINT PK_country PRIMARY KEY (Country_Name)
            );

            '''
        cursor.execute(sql)
        
### EOF            



    again = True; retry = 5; attempt = 0
    while(again and attempt < retry):
        attempt +=1 
        try:

            create_tables()
            again = False

        except Error as e:
            print("[ERROR]Create tables failed. Drop all tables and create new.", e)
            # if any error occured, all tables will be deleted and the process is repeated
            drop_all_tables()
            time.sleep(1)
            # reapeat the while-loop
            again = True


    if attempt >= retry: 
        print(f"[FATAL ERROR]Tried {retry} times to create tables. End program.")
        cursor.close(); conn.close()
        raise SystemExit

    else: 
        print("[INFO]CREATE TABLES successful!")





    ############################
    #   ALTER FK CONSTRAINTS   #
    ############################



    def alter_FK_constraints():
        sql = '''
            ALTER TABLE Client
                ADD CONSTRAINT FK_client_country
                FOREIGN KEY (Country_Name)
                REFERENCES Country (Country_Name) 
                ON DELETE CASCADE
            '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE Orders                      
            ADD CONSTRAINT FK_orders_product   FOREIGN KEY (ID_product)
            REFERENCES Product (ID_product) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE Orders                      
            ADD CONSTRAINT FK_orders_client FOREIGN KEY (ID_client)
            REFERENCES Client (ID_client) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE Campaign                      
            ADD CONSTRAINT FK_camp_product FOREIGN KEY (ID_product)
            REFERENCES Product (ID_product) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE Employee                      
            ADD CONSTRAINT FK_emp_leader FOREIGN KEY (Team_leader)
            REFERENCES Employee (ID_employee) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE Marketing_emp                      
            ADD CONSTRAINT FK_mark_emp FOREIGN KEY (ID_employee)
            REFERENCES Employee (ID_employee) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE Advertises                    
            ADD CONSTRAINT FK_adv_prod FOREIGN KEY (ID_product)
            REFERENCES Product (ID_product) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE Advertises                     
            ADD CONSTRAINT FK_adv_mark FOREIGN KEY (ID_employee)
            REFERENCES Marketing_emp (ID_employee) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE General_Manager                      
            ADD CONSTRAINT FK_gm_emp FOREIGN KEY (ID_employee)
            REFERENCES Employee (ID_employee) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE General_Manager                      
            ADD CONSTRAINT FK_gm_prod FOREIGN KEY (ID_region)
            REFERENCES Region (ID_region) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)



        sql = '''
        ALTER TABLE Country                 
            ADD CONSTRAINT FK_country_reg FOREIGN KEY (ID_region)
            REFERENCES Region (ID_region) ON DELETE CASCADE
        ;
        '''
        cursor.execute(sql)
### EOF


    again = True; retry = 5; attempt = 0
    while(again and attempt < retry):
        attempt +=1 
        try:

            alter_FK_constraints()
            again = False

        except Error as e:
            print(f"[ERROR]Set FK constraints failed! Let's try again [{attempt}]", e)
            # reapeat the while-loop
            again = True
            time.sleep(1)

            if attempt >= retry-1: 
                print("[ERROR]Last attempt to set FK constraints! Drop all tables. Create new tables.")
                drop_all_tables()
                create_tables()
                time.sleep(3)
        
    if attempt >= retry:
        print(f"[FATAL ERROR]Tried {retry} times to set FK constraints. End program.")
        cursor.close(); conn.close()
        raise SystemExit

    else: 
        print("[INFO]Set FK constraints was successful!")



    ##########################
    #   INSERT INTO TABLES   #
    ##########################

    csvList = ["regions", "countries", "client_names", "products", "campaigns", "marketing_occupations", "advertises", "general_managers_id", "order_dates"]
    print("Current directory:", os.getcwd())

    ''' # my insert notes # 

    Region :            all rows
    Country :           all rows
    Client :            MAKE list of only names, random numbers from countries
    Product :           all rows (no IDs?)
    Campaign :          all rows (BUT prodcut id changed? datatime format?)
    Employee :          all rows
    Marketing_emp :     id_employee+20, occupations from csv
    Advertises :        all rows (BUT id product changed?)
    General_Manager :   all rows 
    Orders :            omg such complicated, need lots of buffers
    '''

    
    if "vscode" in os.getcwd().lower():
        filepath = "C:/Users/clemens/VSCodeProjects/imse-docker/python/resources/regions.csv"
    else: 
        filepath = "/opt/resources/regions.csv"
    with open(filepath) as file:
        count = 0
        content = csv.reader(file)
        for line in content:
            count +=1
            print(line[0])
            cursor.execute(
                #f"INSERT INTO Region (Region_Name) VALUES ('{line[0]}')"
                "INSERT INTO Region (Region_Name) VALUES ('DACH region');"
                )
            print(f"[INFO] {count} records inserted into table Regions {line}")
            break






finally: 
    cursor.close()
    conn.close()
