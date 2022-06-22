<?php

//		DELETE CLIENT

//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variable id from POST request
$del_id_client = '';
if(isset($_POST['del_id_client'])){
    $del_id_client = $_POST['del_id_client'];
}

// Delete method
$error_code = $database->deleteClient($del_id_client);

// Check result
if ($error_code == 1){
    echo "Client with ID: '{$del_id_client}' successfully deleted!'";
}
else{
    echo "Error can't delete Client with ID: '{$del_id_client}'. Errorcode: {$error_code}";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>