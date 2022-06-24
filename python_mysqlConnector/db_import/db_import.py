#!/usr/bin/env python3

import os
import time
import csv
import logging
import mysql.connector as connector

# Establishing the connection
sql11Server="sql11.freemysqlhosting.net"
sql11Name="sql11501710"
sql11Username="sql11501710"
sql11Password="11IIzf3ue4"
sql11Port=3306

conn = connector.connect(
   user=sql11Username, password=sql11Password, host=sql11Server, database=sql11Name, port=sql11Port
)

#TODO check connection success?

#Creating a cursor object using the cursor() method
cursor = conn.cursor()




################################
#   CREATE OR REPlACE TABLES   # 
################################
insertCount = 1
try: 
   #Dropping EMPLOYEE table if already exists.
   cursor.execute("DROP TABLE IF EXISTS EMPLOYEE")

   #Creating table as per requirement
   sql ='''
      CREATE TABLE EMPLOYEE(
      FIRST_NAME CHAR(20) NOT NULL,
      LAST_NAME CHAR(20),
      AGE INT,
      SEX CHAR(1),
      INCOME FLOAT
      )'''
   cursor.execute(sql)

except:
   print(f"[ERROR] Table #{insertCount} could not be inserted!")

finally: 
   #Closing the connection
   conn.close()