#!/usr/bin/env python3

import os
import time
import csv
import logging
import http
import sqlalchemy as sa
#from sqlalchemy import sa.Column, sa.Integer, sa.String, Sa.Table, Sa.ForeignKey, sa.create_engine, sa.MetaData, sa.Text, sa.insert

# Logging
logging.basicConfig(level=logging.INFO)


# Wait for docker network to eventually setup 
#time.sleep(30) # wait for db to be up
              # could be fancier if we tried to connect to the databse via tcp
              # and kept retrying until the connection doesn't get dropped anymore.



#######################
# Database CONNECTION #
#######################

# the database connection
connection_string = os.environ.get('DB_URI', 'sqlite:////data/database.sqlite')

sqlengine = sa.create_engine(connection_string) 




#################
# Create TABLES #
#################

meta = sa.MetaData() # holds all db information

# Build tables
tableT = sa.Table( 'T', meta,
    sa.Column("id", sa.Text()),
    sa.Column("a",  sa.Text()),
    sa.Column("b",  sa.Text()),
    sa.Column("c",  sa.Text()),
)

tableClient = sa.Table('Client', meta,
    sa.Column("ID_client",      sa.Integer(),  primary_key=True), 
    sa.Column("Client_Name",    sa.String(50), nullable=False), 
    sa.Column("Country_Name",   sa.String(25), nullable=False) 
)

#tableClient.create(sqlengine)

tableRegion = sa.Table('Region', meta,
    sa.Column("ID_region",     sa.Integer(),  primary_key=True),  # auto increment ?
    sa.Column("Region_Name",   sa.String(25), nullable=False)
)

tableCountry = Sa.Table('Country', meta,
    sa.Column("Country_Name",  sa.String(25), primary_key=True),  # auto increment ?
    sa.Column("ID_region",     sa.Integer(),  sa.ForeignKey("Region.ID_region"))
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
        insert_stmt = sa.insert(tableT).values(content)
        ret = transaction.execute(insert_stmt)
    logging.info(f'Inserted {ret.rowcount} rows into table {tableT.name}')


### INSERT ###
"""with open("/resources/.csv") as file:
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
        sa.insert_stmt = sa.insert(table).values(content)
        ret = transaction.execute(sa.insert_stmt)
    logging.info(f'Inserted {ret.rowcount} rows into table {table.name}')
"""