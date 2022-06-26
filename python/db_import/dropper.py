#!/usr/bin/env python3

import os
import logging
import time
import mysql.connector as connector
from mysql.connector import errorcode
from decouple import config

logging.basicConfig(level=logging.INFO)


user = config('USER',default='')
password = config('PASSWORD',default='')
host = config('SERVER',default='')
db_name = config('DB_NAME',default='')
port = config('PORT',default='')


conn = connector.connect(user=user, password=password, host=host, database=db_name, port=port)


# Creating a cursor object using the cursor() method
cursor = conn.cursor()

def drop_all_tables():
    #####################
    #   DELETE TABLES   #
    #####################

    DROPS={}


    DROPS['Orders'] = ("DROP TABLE IF EXISTS Orders CASCADE;")
    DROPS['Advertises'] = ("DROP TABLE IF EXISTS Advertises CASCADE;;")
    DROPS['Marketing_emp'] = ("DROP TABLE IF EXISTS Marketing_emp CASCADE;")
    DROPS['General_Manager'] = ("DROP TABLE IF EXISTS General_Manager CASCADE;")
    DROPS['Campaign'] = ("DROP TABLE IF EXISTS Campaign CASCADE;")
    DROPS['Product'] = ("DROP TABLE IF EXISTS Product CASCADE;")
    DROPS['Employee'] = ("DROP TABLE IF EXISTS Employee CASCADE;")
    DROPS['Client'] = ("DROP TABLE IF EXISTS Client CASCADE;")
    DROPS['Country'] = ("DROP TABLE IF EXISTS Country CASCADE;")
    DROPS['Region'] = ("DROP TABLE IF EXISTS Region CASCADE;")


    for table_name in DROPS:
        table_description = DROPS[table_name]
        try:
            print("[INFO]Dropping table {}: ".format(table_name), end='')
            cursor.execute(table_description)
        except connector.Error as err:
            if err.errno == errorcode.ER_TABLESPACE_DISCARDED: # error of table does not exist anymore 
                print("[Error in dropper.py]Table does not exists")
            else:
                print(err.msg)
        else:
            print(f"OK, table dropped.")
        finally: 
            pass

try:
    drop_all_tables()

finally: 
    # Clean Up but not part of function
    cursor.close()
    conn.close()

