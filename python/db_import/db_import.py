#!/usr/bin/env python3

import os
import time
import csv
import logging
import http
import sqlalchemy as sa

logging.basicConfig(level=logging.INFO)
connection_string = os.environ.get('DB_URI', 'sqlite:////data/database.sqlite')

time.sleep(3) # wait for db to be up
              # could be fancier if we tried to connect to the databse via tcp
              # and kept retrying until the connection doesn't get dropped anymore.

# server = http.server.HTTPServer(('0.0.0.0', 80))

meta = sa.MetaData() # holds all db information
table = sa.Table(
    'T', meta,
    sa.Column("id", sa.Text()),
    sa.Column("a", sa.Text()),
    sa.Column("b", sa.Text()),
    sa.Column("c", sa.Text()),
)
sqlengine = sa.create_engine(connection_string) # the database connection
meta.create_all(sqlengine) # create all tables

db_connection = sqlengine.connect()

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
