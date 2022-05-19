<?php

//		DELETE EMPLOYEE

//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variable id from POST request
$del_id_employee = '';
if(isset($_POST['del_id_employee'])){
    $del_id_employee = $_POST['del_id_employee'];
}

// Delete method
$error_code = $database->deleteEmployee($del_id_employee);

// Check result
if ($error_code == 1){
    echo "Employee with ID: '{$del_id_employee}' successfully deleted!'";
}
else{
    echo "Error can't delete Employee with ID: '{$del_id_employee}'. Errorcode: {$error_code}";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>