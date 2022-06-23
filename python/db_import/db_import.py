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
time.sleep(10) # wait for db to be up
              # could be fancier if we tried to connect to the databse via tcp
              # and kept retrying until the connection doesn't get dropped anymore.



#######################
# Database CONNECTION #
#######################

# the database connection
connection_string = os.environ.get('DB_URI', 'sqlite:////data/database.sqlite')
sqlengine = sa.create_engine(connection_string) 
meta = sa.MetaData() # holds all db information

autoIncrementScore = 1


#################
# Create TABLES #
#################

tablesToCreate = ["Region", "Country", "Client", "Product", "Campaign", "Employee", "Marketing_emp", "Advertises", "General_Manager", "Orders"]
# https://stackoverflow.com/questions/33053241/sqlalchemy-if-table-does-not-exist
#allTableCreations = [meta.tables.keys()]
for t in meta.tables.keys():  # traverse over all tables in metaData
    if not sqlengine.dialect.has_table(sqlengine, tablesToCreate[]):  # If table don't exist, Create.
        meta = sa.MetaData(sqlengine)

        # Create a table with the appropriate Columns
        Table(Variable_tableName, metadata,
            Column('Id', Integer, primary_key=True, nullable=False), 
            Column('Date', Date), Column('Country', String),
            Column('Brand', String), Column('Price', Float))
        # Implement the creation
meta.create_all()


# Build tables
tableT = sa.Table( 'T', meta,
    sa.Column("id", sa.Text()),
    sa.Column("a",  sa.Text()),
    sa.Column("b",  sa.Text()),
    sa.Column("c",  sa.Text()),
)

tableRegion = sa.Table('Region', meta,
    sa.Column("ID_region",     sa.Integer(),  primary_key=True),  # auto increment ?
    sa.Column("Region_Name",   sa.String(25), nullable=False)
)
#tables_dict.add(tableRegion:autoIncrementScore)

tableCountry = sa.Table('Country', meta,
    sa.Column("Country_Name",  sa.String(25), primary_key=True),  # auto increment ?
    sa.Column("ID_region",     sa.Integer(),  sa.ForeignKey("Region.ID_region"))
)

tableClient = sa.Table('Client', meta,
    sa.Column("ID_client",      sa.Integer(),  primary_key=True), 
    sa.Column("Client_Name",    sa.String(50), nullable=False), 
    sa.Column("Country_Name",   sa.String(25), nullable=False) 
)



# create all tables
meta.create_all(sqlengine) 

# connect to database 
db_connection = sqlengine.connect()

time.sleep(5)

# https://www.pythonsheets.com/notes/python-sqlalchemy.html 




##############################
# Database HELPER functions  #
##############################

# temporary --> define with tables above
tables_ID_dict = { #key=table : value=autoIncrementScore
    tableRegion : autoIncrementScore, 
    tableCountry : autoIncrementScore,
    tableClient : autoIncrementScore,
    "Product" : autoIncrementScore,
    "Campaign" : autoIncrementScore,
    "Employee" : autoIncrementScore,
    "Marketing_emp" : autoIncrementScore,
    "Advertises" : autoIncrementScore,
    "General_Manager" : autoIncrementScore,
    "Orders" : autoIncrementScore
    }



def autoIncrement(tableName):
    autoIncrementScore = tables_ID_dict[tableName] # store current value
    tables_ID_dict[tableName] += 1
    return autoIncrementScore
    




###############################
# Database INSERT statements  #
###############################
"""
# order of insertion #
Region
Country
Client
Product
Campaign
Employee
Marketing_emp
Advertises
General_Manager
Orders
"""

### TEST ###
try:
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
    for tableName in tables_ID_dict.keys():

        with open("/resources/regions.csv") as file:
            content = csv.reader(file)
            content = [
                {
                    'ID_region': autoIncrement(tableName),
                    'Region_Name': line[0]
                }
                for line in content if line
            ]

            with sqlengine.begin() as transaction:
                insert_stmt = sa.insert( tableName ).values(content)
                ret = transaction.execute(insert_stmt)
            logging.info(f'Inserted {ret.rowcount} rows into table { tableName.name }')
        break 
    # db_import    | [parameters: (1, 'DACH Region', 2, 'British Isles', 3, 'BeNeLux states', 4, 'Nordic Region', 5, 'CEE

except:

