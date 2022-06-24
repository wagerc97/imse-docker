#!/usr/bin/env python3

import os
import time
import csv
import logging
import mysql.connector as connector
from mysql.connector import errorcode



# Logging
logging.basicConfig(level=logging.INFO)


# Wait for docker network to eventually setup
# time.sleep(5)


# Establishing the connection
sql11Server = "sql11.freemysqlhosting.net"
sql11Name = "sql11501710"
sql11Username = "sql11501710"
sql11Password = "11IIzf3ue4"
sql11Port = 3306

conn = connector.connect(
    user=sql11Username, password=sql11Password, host=sql11Server, database=sql11Name, port=sql11Port
)

# TODO check connection success?

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
          print("[SUCCESS IN dropper.py]OK, table dropped.")


cursor.close()
conn.close()

