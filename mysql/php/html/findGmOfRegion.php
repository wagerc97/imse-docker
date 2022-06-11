<?php

/** Find the GM of given region **/

//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
$regionname = '';
if(isset($_POST['regionname'])){
    $regionname = $_POST['regionname'];
}


// Call seach function in DatabaseHelper
$success = $database->selectTheGM($regionname);

// Check result
if ($success){
    echo "The GM of region '{$regionname}' is '{$success}'!'";
}
else{
    echo "Error can't find any results for region '{$regionname}'!";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>