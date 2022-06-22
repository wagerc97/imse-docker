#!/usr/bin/env python3

import os
import time
import csv
import logging
import http
import sqlalchemy as sa
from sqlalchemy import Column, Integer, String, Table


# Logging
logging.basicConfig(level=logging.INFO)
connection_string = os.environ.get('DB_URI', 'sqlite:////data/database.sqlite')


# Wait for docker network to eventually setup 
time.sleep(3) # wait for db to be up
              # could be fancier if we tried to connect to the databse via tcp
              # and kept retrying until the connection doesn't get dropped anymore.

# ???
# server = http.server.HTTPServer(('0.0.0.0', 80))


#################
# Create TABLES #
#################

meta = sa.MetaData() # holds all db information

# Build tables
tableT = Table(
    'T', meta,
    Column("id", sa.Text()),
    Column("a",  sa.Text()),
    Column("b",  sa.Text()),
    Column("c",  sa.Text()),
)

tableClient = Table(
    'Client', meta,
    Column("ID_client",      Integer(),  primary_key=True), 
    Column("Client_Name",    String(50), nullable=False), 
    Column("Country_Name",   String(25), nullable=False) 
)

tableRegion = Table(
    'Region', meta,
    Column("ID_region",     Integer(),  primary_key=True),  # auto increment 
    Column("Region_Name",   String(25), nullable=False)
)

tableCountry = Table(
    'Country', meta,
    Column("Country_Name",  String(25),  primary_key=True),  # auto increment 
    Column("ID_region",     Integer(), nullable=False)
)



#######################
# Database CONNECTION #
#######################

# the database connection
sqlengine = sa.create_engine(connection_string) 

# create all tables
meta.create_all(sqlengine) 

# connect to database 
db_connection = sqlengine.connect()



###############################
# Database INSERT statements  #
###############################

### TEST ###
with open("/csv/test.csv") as file:
    content = csv.reader(file)
    content = [
        {
            'id': line[0],
            'a': line[1],
            'b': line[2],
            'c': line[3],
        }
        for line in content if line
    ]

    with sqlengine.begin() as transaction:
        insert_stmt = sa.insert(table).values(content)
        ret = transaction.execute(insert_stmt)
    logging.info(f'Inserted {ret.rowcount} rows into {table.name}')


### INSERT ###
with open("/resources/.csv") as file:
    content = csv.reader(file)
    content = [
        {
            'id': line[0],
            'a': line[1],
            'b': line[2],
            'c': line[3],
        }
        for line in content if line
    ]

    with sqlengine.begin() as transaction:
        insert_stmt = sa.insert(table).values(content)
        ret = transaction.execute(insert_stmt)
    logging.info(f'Inserted {ret.rowcount} rows into {table.name}')
