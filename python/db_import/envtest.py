import os
# pip install python-dotenv
#from dotenv import load_dotenv
from pathlib import Path

#dotenv_path = Path('../.env')
#load_dotenv(dotenv_path=dotenv_path)

#SHIT = os.getenv('../.env','SERVERUSER')

SHIT = os.environ.get('SERVERUSER')
print(SHIT)



#print(var.env.sql11Server)