<?php

/** UPDATE EMPLOYEE **/

//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
$up_id_employee = '';
if(isset($_POST['up_id_employee'])){
    $up_id_employee = $_POST['up_id_employee'];
}

$up_firstname = '';
if(isset($_POST['up_firstname'])){
    $up_firstname = $_POST['up_firstname'];
}

$up_lastname = '';
if(isset($_POST['up_lastname'])){
    $up_lastname = $_POST['up_lastname'];
}
	
$up_gender = '';
if(isset($_POST['up_gender'])){
    $up_gender = $_POST['up_gender'];
}
	
$up_salary = '';
if(isset($_POST['up_salary'])){
    $up_salary = $_POST['up_salary'];
}
	
$up_team_leader = '';
if(isset($_POST['up_team_leader'])){
    $up_team_leader = $_POST['up_team_leader'];
}



// Update method
$success = $database->updateEmployee
($up_id_employee, $up_firstname, $up_lastname, $up_gender, $up_salary, $up_team_leader);

// Check result
if ($success){
    echo "Employee '{$up_id_employee}' successfully updated!";
}
else{
    echo "Error can't update Employee '{$up_id_employee}'! Errorcode: {$error_code}";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>