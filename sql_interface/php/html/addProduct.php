<!doctype html>
<html lang="en">
  <head>  
    <!-- Required meta tags -->
    <meta charset="utf-8">
	<!-- Mobile device format support -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!--  name of the page --> 
    <title>Result page</title>

	<!-- from moodle wiki III -->
    <link rel="stylesheet" type="text/css" href="ExampleCss.css">

	
	<!-- BOOTSTRAP CDN -->	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
	integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
	integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
	<div class="pad_menu"></div>
	<!-- CSS -->
	<style>
		<!-- TABLES --> 
		table, th, td {
		  border: 1px solid black;
		  border-collapse: collapse;
		}
		td { <!-- table entries -->
		  padding: 5px;
		  text-align:center;	
		}	
		th { <!-- table headers -->
		  padding: 5px;
		  text-align:center;	
		}
		
		<!-- BACKGROUND --> 
		.pad_menu {
			padding: 100px;
			background-color: #a5b8d4;
		}
		body {
			background: #a5b8d4 !important;
		}
		
		<!-- CUSTOM ROW -->
		.my-custom-row {
			background-color: bisque; 
			height: 400px; 
			justify-content-center;
		}
	</style>

</head>
<body>
	
<!-- Top text block -->
<div class="container"> <!-- Centering-->

	<br>
	<div class="row "> 
		<div class="col-lg-12"><div class="p-4 border-dark bg-light">

		<!-- header --> 
		<h3>Result page</h3>
			<?php

			/** ADD PRODUCT **/

			//include DatabaseHelper.php file
			require_once('DatabaseHelper.php');

			//instantiate DatabaseHelper class
			$database = new DatabaseHelper();

			//Grab variables from POST request
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


			if ($product_name == '') { 
				echo "Error: No product name was given!";
			}			
			elseif ($indication == '') { 
				echo "Error: No indication was given!";
			}
			else {
				// Insert method
				$success = $database->addProduct($product_name, $price, $indication);

				// Check result
				if ($success){
						echo "Product '{$product_name}' successfully added!";
				}
				else{
						echo "Error can't insert Product '{$product_name}'!";
				}
			}
			?>

			<!-- link back to index page-->
			<br><br>
			<a href="index.php">
				<button>go back</button>
			</a>