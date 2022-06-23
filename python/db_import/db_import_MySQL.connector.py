#!/usr/bin/env python3

import os
import time
import csv
import logging
import mysql.connector as connector

#establishing the connection
connServer = connector.connect(
   user='Username', password='Password', host='Server', database='Name', port=3306
)
conn = connServer

#Creating a cursor object using the cursor() method
cursor = conn.cursor()

#Dropping EMPLOYEE table if already exists.
cursor.execute("DROP TABLE IF EXISTS EMPLOYEE")

#Creating table as per requirement
sql ='''CREATE TABLE EMPLOYEE(
   FIRST_NAME CHAR(20) NOT NULL,
   LAST_NAME CHAR(20),
   AGE INT,
   SEX CHAR(1),
   INCOME FLOAT
)'''
cursor.execute(sql)

#Closing the connection
conn.close()