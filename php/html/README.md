# Connection settings
To change the php connection between Docker and Server:  
Comment in / out the connection variables in [DatabaseHelper.php](./DatabaseHelper.php) in lines 34 to 39.  
Also you will need the server credentials stored in a secret ``.env`` file. 
