#!/usr/bin/env python3

import os
import time
import csv
import logging
import sqlalchemy as sa  # ORM library
import random
import mysql.connector
from mysql.connector import Error



def connect():
    """ Connect to MySQL database """
    conn = None
    try:
        conn = mysql.connector.connect(host='localhost',
                                       database='python_mysql',
                                       user='root',
                                       password='SecurePass1!')
        if conn.is_connected():
            print('Connected to MySQL database')

    except Error as e:
        print(e)

    finally:
        if conn is not None and conn.is_connected():
            conn.close()


if __name__ == '__main__':
    connect()













# Logging
logging.basicConfig(level=logging.INFO)


# Wait for docker network to eventually setup 
time.sleep(5) # wait for db to be up
              # could be fancier if we tried to connect to the databse via tcp
              # and kept retrying until the connection doesn't get dropped anymore.



#######################
# Database CONNECTION #
#######################

# the database connection
connection_string = os.environ.get('DB_URI_SERVER', 'sqlite:////data/database.sqlite')
engine = sa.create_engine(connection_string, echo=False) 
metadata = sa.MetaData() # holds all db information


###################
# Drop all TABLES #
###################
inspector = sa.inspect(engine)
print("First Inspector\n", inspector)

metadata.drop_all(engine, checkfirst=True)
inspector = sa.inspect(engine)
print("Second Inspector\n", inspector)




#################
# Create TABLES #
#################

tablesToCreate = ["Region", "Country", "Client", "Product", "Campaign", "Employee", "Marketing_emp", "Advertises", "General_Manager", "Orders"]
tableIdDictionary = {}

#################################################################################################
#                                                                                               #
### write it like this: https://discuss.dizzycoding.com/how-to-delete-a-table-in-sqlalchemy/  ###
#                                                                                               #
#                                                                                               #
#                                           WHY?                                                #
#                                                                                               #
#################################################################################################


# Test tables
tableT = sa.Table( 'T', metadata,
    sa.Column("id", sa.Text()),
    sa.Column("a",  sa.Text()),
    sa.Column("b",  sa.Text()),
    sa.Column("c",  sa.Text()),
)

tableRegion = sa.Table('Region', metadata,
    sa.Column("ID_region",     sa.Integer(),  primary_key=True),  # auto increment
    sa.Column("Region_Name",   sa.String(25), nullable=False)
)
tableIdDictionary[tableRegion]=1


tableCountry = sa.Table('Country', metadata,
    sa.Column("Country_Name",  sa.String(25), primary_key=True),  # auto increment
    sa.Column("ID_region",     sa.Integer(),  sa.ForeignKey("Region.ID_region"))
)
tableIdDictionary[tableCountry]=1


tableClient = sa.Table('Client', metadata,
    sa.Column("ID_client",      sa.Integer(),  primary_key=True), 
    sa.Column("Client_Name",    sa.String(50), nullable=False), 
    sa.Column("Country_Name",   sa.String(25), nullable=False) 
)
tableIdDictionary[tableClient]=1



# create all tables
metadata.create_all(engine, checkfirst=True)

# connect to database 
db_connection = engine.connect()

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

    with engine.begin() as transaction:
        insert_stmt = sa.insert(tableT).values(content)
        ret = transaction.execute(insert_stmt)
    logging.info(f'Inserted {ret.rowcount} rows into table {tableT.name}')

'''except: 
    print(f"Error while inserting into table {tableT.name}")
    logging.info(f'[LOG] Error: Could not insert into table {tableT.name}')

'''

### INSERT ###

csvList = ["regions", "countries", "client_names", "products", "campaigns", "marketing_occupations", "advertises", "general_managers_id", "order_dates"]


with open("/resources/regions.csv") as file:
    content = csv.reader(file)
    content = [
        {
            'ID_region': autoIncrement(tableRegion),
            'Region_Name': line[0]
        }
        for line in content if line
    ]

    with engine.begin() as transaction:
        insert_stmt = sa.insert( tableRegion ).values(content)
        ret = transaction.execute(insert_stmt)
    logging.info(f'Inserted {ret.rowcount} rows into table { tableRegion.name }')


'''except:
    print(f"Error while inserting into table {tableT.name}")
    logging.info(f'[LOG] Error: Could not insert into table {tableT.name}')
'''


