<?php

/** ADD EMPLOYEE **/

//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
$add_firstname = '';
if(isset($_POST['add_firstname'])){
    $add_firstname = $_POST['add_firstname'];
}
	
$add_lastname = '';
if(isset($_POST['add_lastname'])){
    $add_lastname = $_POST['add_lastname'];
}
	
$add_gender = '';
if(isset($_POST['add_gender'])){
    $add_gender = $_POST['add_gender'];
}

$add_salary = '';
if(isset($_POST['add_salary'])){
    $add_salary = $_POST['add_salary'];
}

$add_team_leader = '';
if(isset($_POST['add_team_leader'])){
    $add_team_leader = $_POST['add_team_leader'];
}

$add_hire_date = '';
if(isset($_POST['add_hire_date'])){
    $add_hire_date = $_POST['add_hire_date'];
}


// Insert method
$success = $database->addEmployee
($add_firstname, $add_lastname, $add_gender, $add_salary, $add_team_leader, $add_hire_date);

// Check result
if ($success){
    echo "Employee '{$add_firstname}' '{$add_lastname}' successfully added!'";
}
else{
    echo "Error can't insert Employee '{$add_firstname}' '{$add_lastname}'!";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>