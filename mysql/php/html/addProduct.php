<?php

/** ADD PRODUCT **/

//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
/*
$id_product = '';
if(isset($_POST['id_product'])){
    $id_product = $_POST['id_product'];
}
*/
$product_name = '';
if(isset($_POST['product_name'])){
    $product_name = $_POST['product_name'];
}
$price = '';
if(isset($_POST['price'])){
    $price = $_POST['price'];
}
$indication = '';
if(isset($_POST['indication'])){
    $indication = $_POST['indication'];
}



// Insert method
//$success = $database->addProduct($id_product, $product_name, $price, $indication);
$success = $database->addProduct($product_name, $price, $indication);

// Check result
if ($success){
    echo "Product '{$product_name}' successfully added!'";
}
else{
    echo "Error can't insert Product '{$product_name}'!";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>