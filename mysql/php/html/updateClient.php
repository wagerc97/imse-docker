<?php

/** UPDATE CLIENT **/

//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
$up_id_client = '';
if(isset($_POST['up_id_client'])){
    $up_id_client = $_POST['up_id_client'];
}

$up_client_name = '';
if(isset($_POST['up_client_name'])){
    $up_client_name = $_POST['up_client_name'];
}
	
$up_client_country = '';
if(isset($_POST['up_client_country'])){
    $up_client_country = $_POST['up_client_country'];
}



// Update method
$success = $database->updateClient($up_id_client, $up_client_name, $up_client_country);

// Check result
if ($success){
    echo "Client '{$up_id_client}' successfully updated! New name is '{$up_client_name}' and country is '{$up_client_country}'.";
}
else{
    echo "Error can't update Client '{$up_id_client}'! Errorcode: {$error_code}";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>