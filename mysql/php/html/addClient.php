<?php

/** ADD CLIENT **/

//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
$client_client_name = '';
if(isset($_POST['client_client_name'])){
    $client_client_name = $_POST['client_client_name'];
}
	
$client_country_name = '';
if(isset($_POST['client_country_name'])){
    $client_country_name = $_POST['client_country_name'];
}



// Insert method
$success = $database->addClient($client_client_name, $client_country_name);

// Check result
if ($success){
    echo "Client '{$client_client_name}' successfully added!'";
}
else{
    echo "Error can't insert client '{$client_client_name}'!";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>