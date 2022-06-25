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

conn = connector.connect(
    user=user, password=password, host=host, database=db_name, port=port
)


conn.close()

