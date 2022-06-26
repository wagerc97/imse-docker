import os
# pip install python-dotenv
#from dotenv import load_dotenv
from pathlib import Path
from decouple import config
import mysql.connector as connector



user = config('USER',default='')
password = config('PASSWORD',default='')
host = config('SERVER',default='')
db_name = config('DB_NAME',default='')
port = config('PORT',default='')


#print(user, password, host, db_name, port)

conn = connector.connect(user=user, password=password, host=host, database=db_name, port=port)
cursor = conn.cursor()

filepath = "C:/Users/clemens/VSCodeProjects/imse-docker/python/resources/regions.csv"

count = 0
cursor.execute( 
    #"SHOW TABLES;" 
    "INSERT INTO Region (Region_Name) VALUES ('DACH region');"
    )

print(f"[INFO] {count} records inserted into table Regions {count}")

conn.commit()

#ret = cursor.fetchall()
#print(ret)

cursor.close()
conn.close()

