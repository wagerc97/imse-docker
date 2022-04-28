<!--------------------------------------------------
	DatabaseHelper.php
from YouTube
----------------------------------------------------> 

<?php

// turn of all warnings
//warning_reporting(0);

//---------------------------------------------------
//------------------- CONNECTION --------------------
//---------------------------------------------------
//CONNECT

// Since the connection details are constant, define them as const
// We can refer to constants like e.g. DatabaseHelper::username
	
	// to connect to oracle database + oracle username + oracle PW
//const host = 'db';  //service name from docker-compose.yml
//const username = 'devuser'; // use a + your matriculation number  
//const password = 'devpass'; // use your oracle db password
//const db = 'PharmaComp';  // database name
$host = 'db';  //service name from docker-compose.yml
$user = 'devuser'; // use a + your matriculation number  
$password = 'devpass'; // use your oracle db password
$db = 'PharmaComp';  // database name

//const con_string = null;  //on almighty "lab" is sufficient
// Webaddress: http://127.0.0.1:8000/index.php 


// Since we need only one connection object, it can be stored in a member variable.
// $conn is set in the constructor.
$conn = null;
$conn = new mysqli($host, $user, $password, $db);

//check if the connection object is != null
if ($conn->connect_error) {
    die('Connect Error: ' . $conn->connect_error);
}

echo "Successfully connected to MYSQL!";

?>