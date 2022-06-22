#!/usr/bin/env python3

import os
import time
import csv
import logging
import http
#import sqlalchemy as sa
from sqlalchemy import* # Column, Integer, String, Table, ForeignKey

# Logging
logging.basicConfig(level=logging.INFO)


# Wait for docker network to eventually setup 
time.sleep(10) # wait for db to be up
              # could be fancier if we tried to connect to the databse via tcp
              # and kept retrying until the connection doesn't get dropped anymore.



#######################
# Database CONNECTION #
#######################

# the database connection
connection_string = os.environ.get('DB_URI', 'sqlite:////data/database.sqlite')

sqlengine = create_engine(connection_string) 




#################
# Create TABLES #
#################

meta = MetaData(sqlengine) # holds all db information

# Build tables
tableT = Table( 'T', meta,
    Column("id", Text()),
    Column("a",  Text()),
    Column("b",  Text()),
    Column("c",  Text()),
)

tableClient = Table('Client', meta,
    Column("ID_client",      Integer(),  primary_key=True), 
    Column("Client_Name",    String(50), nullable=False), 
    Column("Country_Name",   String(25), nullable=False) 
)

#tableClient.create(sqlengine)

tableRegion = Table('Region', meta,
    Column("ID_region",     Integer(),  primary_key=True),  # auto increment ?
    Column("Region_Name",   String(25), nullable=False)
)

tableCountry = Table('Country', meta,
    Column("Country_Name",  String(25), primary_key=True),  # auto increment ?
    Column("ID_region",     Integer(),  ForeignKey("Region.ID_region"))
)



# create all tables
meta.create_all(sqlengine) 

# connect to database 
db_connection = sqlengine.connect()

# https://www.pythonsheets.com/notes/python-sqlalchemy.html 



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
        insert_stmt = insert(table).values(content)
        ret = transaction.execute(insert_stmt)
    logging.info(f'Inserted {ret.rowcount} rows into table {table.name}')


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
        insert_stmt = insert(table).values(content)
        ret = transaction.execute(insert_stmt)
    logging.info(f'Inserted {ret.rowcount} rows into table {table.name}')
