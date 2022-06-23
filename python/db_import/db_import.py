#!/usr/bin/env python3

import os
import time
import csv
import logging
#from regex import P
#import http
#from pyrsistent import T
import sqlalchemy as sa  # ORM library
import random

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
connection_string = os.environ.get('DB_URI_SERVER', 'sqlite:////data/database.sqlite')
sqlengine = sa.create_engine(connection_string, echo=False) 
meta = sa.MetaData() # holds all db information


###################
# Drop all TABLES #
###################

meta.drop_all(sqlengine, checkfirst=True)

#################
# Create TABLES #
#################

tablesToCreate = ["Region", "Country", "Client", "Product", "Campaign", "Employee", "Marketing_emp", "Advertises", "General_Manager", "Orders"]
tableIdDictionary = {}


# Test tables
tableT = sa.Table( 'T', meta,
    sa.Column("id", sa.Text()),
    sa.Column("a",  sa.Text()),
    sa.Column("b",  sa.Text()),
    sa.Column("c",  sa.Text()),
)

tableRegion = sa.Table('Region', meta,
    sa.Column("ID_region",     sa.Integer(),  primary_key=True),  # auto increment
    sa.Column("Region_Name",   sa.String(25), nullable=False)
)
tableIdDictionary[tableRegion]=1


tableCountry = sa.Table('Country', meta,
    sa.Column("Country_Name",  sa.String(25), primary_key=True),  # auto increment
    sa.Column("ID_region",     sa.Integer(),  sa.ForeignKey("Region.ID_region"))
)
tableIdDictionary[tableCountry]=1


tableClient = sa.Table('Client', meta,
    sa.Column("ID_client",      sa.Integer(),  primary_key=True), 
    sa.Column("Client_Name",    sa.String(50), nullable=False), 
    sa.Column("Country_Name",   sa.String(25), nullable=False) 
)
tableIdDictionary[tableClient]=1



# create all tables
meta.create_all(sqlengine, checkfirst=True)

# connect to database 
db_connection = sqlengine.connect()

time.sleep(5)

# https://www.pythonsheets.com/notes/python-sqlalchemy.html 




##############################
# Database HELPER functions  #
##############################


def autoIncrement(tableName):
    autoIncrementScore = tableIdDictionary[tableName] # store current value
    tableIdDictionary[tableName] += 1  # increment
    return autoIncrementScore
    
random.seed(42)


###############################
# Database INSERT statements  #
###############################

''' # my insert notes

    tableRegion :       all rows
    tableCountry :      all rows
    tableClient :         MAKE list of only names, random numbers from countries
    "Product" :         all rows (no IDs?)
    "Campaign" :        all rows (BUT prodcut id changed? datatime format?)
    "Employee" :        all rows
    "Marketing_emp" :     id_employee+20, occupations from csv
    "Advertises" :      all rows (BUT id product changed?)
    "General_Manager" : all rows 
    "Orders" :            omg such complicated, need lots of buffers
'''


### TEST ###
try:
    with open("/csv/test.csv") as file:
        content = csv.reader(file)
        content = [
            {
                'id': line[0],
                'a':  line[1],
                'b':  line[2],
                'c':  line[3],
            }
            for line in content if line
        ]

        with sqlengine.begin() as transaction:
            insert_stmt = sa.insert(tableT).values(content)
            #ret = transaction.execute(insert_stmt)
        #logging.info(f'Inserted {ret.rowcount} rows into table {tableT.name}')

except: 
    print(f"Error while inserting into table {tableT.name}")
    logging.info(f'[LOG] Error: Could not insert into table {tableT.name}')



### INSERT ###

csvList = ["regions", "countries", "client_names", "products", "campaigns", "marketing_occupations", "advertises", "general_managers_id", "order_dates"]

try:
    for table in tableIdDictionary.keys():

        with open("/resources/regions.csv") as file:
            content = csv.reader(file)
            content = [
                {
                    'ID_region': autoIncrement(table),
                    'Region_Name': line[0]
                }
                for line in content if line
            ]

            with sqlengine.begin() as transaction:
                insert_stmt = sa.insert( table ).values(content)
                ret = transaction.execute(insert_stmt)
            logging.info(f'Inserted {ret.rowcount} rows into table { table.name }')
        break 
    # db_import    | [parameters: (1, 'DACH Region', 2, 'British Isles', 3, 'BeNeLux states', 4, 'Nordic Region', 5, 'CEE

except:
    print(f"Error while inserting into table {tableT.name}")
    logging.info(f'[LOG] Error: Could not insert into table {tableT.name}')
