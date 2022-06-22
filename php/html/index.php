<?php 
/************************************************************************
	index.php
	PROJECT: Pharmacompany
	AUTHOR: Clemens Wager, a01635477
	COURSE: VU Database Systems 2021S
	PURPOSE of this file:
		- Starting point of web application
		- Contains GUI 
		- navigation
*************************************************************************/


// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

// VARIABLE DECLARATION
// columns of EMPLOYEE
$id_employee = ''; // initialization
if (isset($_GET['id_employee'])) {   // assign variable GET Method if there exists one
    $id_employee = $_GET['id_employee'];
}

$firstname = '';
if (isset($_GET['firstname'])) {
    $firstname = $_GET['firstname'];
}

$lastname = '';
if (isset($_GET['lastname'])) {
    $lastname = $_GET['lastname'];
}

$team_leader = '';
if (isset($_GET['team_leader'])) {
    $team_leader = $_GET['team_leader'];
}


// for EMPLOYEE update
$up_id_employee = ''; 
if (isset($_GET['up_id_employee'])) { 
	$up_id_employee = $_GET['up_id_employee'];
}


// for adding EMPLOYEE
$add_firstname = '';
if (isset($_GET['add_firstname'])) {
	$add_firstname = $_GET['add_firstname'];
}

$add_lastname = '';
if (isset($_GET['add_lastname'])) {
	$add_lastname = $_GET['add_lastname'];
}

$add_gender = '';
if (isset($_GET['add_gender'])) {
	$add_gender = $_GET['add_gender'];
}

$add_salary = '';
if (isset($_GET['add_salary'])) {
	$add_salary = $_GET['add_salary'];
}

$add_team_leader = '';
if (isset($_GET['add_team_leader'])) {
	$add_team_leader = $_GET['add_team_leader'];
}

$add_hire_date = '';
if (isset($_GET['add_hire_date'])) {
	$add_hire_date = $_GET['add_hire_date'];
}


// for EMPLOYEE update
$up_id_employee = '';
if (isset($_GET['up_id_employee'])) {  
	$up_id_employee = $_GET['up_id_employee'];
}

$up_firstname = '';
if (isset($_GET['up_firstname'])) {
	$up_firstname = $_GET['up_firstname'];
}

$up_lastname = '';
if (isset($_GET['up_lastname'])) {
	$up_lastname = $_GET['up_lastname'];
}

$up_gender = '';
if (isset($_GET['up_gender'])) {
	$up_gender = $_GET['up_gender'];
}

$up_salary = '';
if (isset($_GET['up_salary'])) {
	$up_salary = $_GET['up_salary'];
}

$up_team_leader = '';
if (isset($_GET['up_team_leader'])) {
	$up_team_leader = $_GET['up_team_leader'];
}


// for EMPLOYEE delete
$del_id_employee = '';
if (isset($_GET['del_id_employee'])) {  
	$del_id_employee = $_GET['del_id_employee'];
}
	

// columns of REGION
$id_region = '';
if (isset($_GET['id_region'])) {
    $id_region = $_GET['id_region'];
} 


// columns of CLIENT
$client_client_name = '';
if (isset($_GET['client_client_name'])) {
    $client_client_name = $_GET['client_client_name'];
} 

$id_client = '';
if (isset($_GET['id_client'])) {
    $id_client = $_GET['id_client'];
} 

$del_id_client = '';
if (isset($_GET['del_id_client'])) {
    $del_id_client = $_GET['del_id_client'];
} 

$client_country_name = '';
if (isset($_GET['client_country_name'])) {
    $client_country_name = $_GET['client_country_name'];
} 


// columns of PRODUCT
$id_product = '';
if (isset($_GET['id_product'])) {
    $id_product = $_GET['id_product'];
} 
$product_name = '';
if (isset($_GET['product_name'])) {
    $product_name = $_GET['product_name'];
} 
$price = '';
if (isset($_GET['price'])) {
    $price = $_GET['price'];
} 
$indication = '';
if (isset($_GET['indication'])) {
    $indication = $_GET['indication'];
} 


// for Marketing Employee Search
$markemp_date = '';
if (isset($_GET['markemp_date'])) {
    $markemp_date = $_GET['markemp_date'];
} 


// for UPDATE Client
$up_id_client = '';
if (isset($_GET['up_id_client'])) {
    $up_id_client = $_GET['up_id_client'];
} 

$up_client_name = '';
if (isset($_GET['up_client_name'])) {
    $up_client_name = $_GET['up_client_name'];
} 

$up_client_country = '';
if (isset($_GET['up_client_country'])) {
    $up_client_country = $_GET['up_client_country'];
} 


//// Fetch data from database for tables ////
$client_array = $database->selectFromClient ();	// confir that main use cas "Register Client" works

$product_array = $database->selectFromProduct(); // confirm that main use cas "Register Product" works

$order_array = $database->selectFromOrders(); // list of the last 5 orders



//$employee_array = $database->selectFromEmployeeWhere ($id_employee, $firstname, $lastname, $team_leader);

// $region_array = $database->selectFromCountpreg();

//$country_array = $database->selectFromCountry();
	
//$client_array_select = $database->selectFromClient ($id_client, $client_client_name, $client_country_name);	// former "client_array"

//$campaign_array = $database->selectFromCampaign();

//$markemp_array = $database->selectFromMarkEmp($markemp_date);


//$ads_array = $database->selectFromAdvertises();

//$key_client_array = $database->selectFromKeyClient();


?>

<!-------------------------------------------------------------------------------------->

<!doctype html>
<html lang="en">
  <head>  
    <!-- Required meta tags -->
    <meta charset="utf-8">
	<!-- Mobile device format support -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--  name of the page --> 
    <title>IMSE Project SS2022</title>
	
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
		<div class="col-lg-12"><div class="p-4 border-dark bg-success">

		<!-- header --> 
		<h1>
			Web Interface for Database
		</h1>
		<h2>
			Welcome to our IMSE Web Application of IMSErgo Ltd. - <br>
			Pharmacutical Company and Project Realisation
		</h2>
		<h3>
			by Claas Fillies (A12047732) 
			and Clemens Wager (A01635477)<br>
			for 052400-1 VU Information Management and Systems Engineering (SS2022)<br>
		</h3>
	</div></div></div>
	<br>




	<!----------------------------------------------------------------------------------------------------------------------------->
	<!---------------------------------- MAIN USE CASE 1: ADD CLIENT ---------------------------------------------------------------->
	<!----------------------------------------------------------------------------------------------------------------------------->


	<!-- DBS PROJECT -->
	<!-- Insert new CLIENT -->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
				<h3>Add Client</h3>
				<h4>[MAIN USE CASE 1]</h4>
				<h4>Please fill in the Client information:</h4>
				
			<!-- opens confirmation page to let user know the INSERT was successful --> 
			<form method="post" action="addClient.php"> 
				<!-- client_name textbox -->
				<div>
					<label for="client_client_name">Client name:</label>
					<input id="client_client_name" name="client_client_name" type="text" placeholder='Enter a name' maxlength="25">
				</div>
				<br>
				<!-- country_name textbox -->
				<div>
					<label for="client_country_name">Country:</label>
					<input id="client_country_name" name="client_country_name" type="text" placeholder='Enter a country' maxlength="25">
				</div>
				<br>

				<!-- Submit button sends request when clicked -->
				<div>
					<button type="submit">
						Add Client
					</button>
				</div>
			</form>
		</div></div>
	</div> <!-- end of row -->


	<!----------------------------------------------- DISPLAY PRODUCTS ------------------------------------------------------------>

	<!-- TEST DISPLAY LAST 10 CLIENTS -->
	<!-- Row    sizes: -sm|-md|-lg|-xl|-xxl-->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">

			<h3>Display newest 10 clients</h3>
			<h4>[MAIN USE CASE 1]</h4>
			<h4>This is a list of the newest 10 clients that were registered</h4>
			<br>
			
		<table class="table table-sm table-hover table-striped table-bordered table-light ">
			<thead class="thead-dark">
				<tr>
					<th>Client ID</th>
					<th>Client name</th>
					<th>Country name</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($client_array as $client) : ?>
					<tr>
						<td><?php echo $client['ID_client']; ?>  </td>
						<td><?php echo $client['Client_Name']; ?>  </td>
						<td><?php echo $client['Country_Name']; ?>  </td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div></div></div>
	<br>


	<!----------------------------------------------------------------------------------------------------------------------------->
	<!----------------------------------------- MAIN USE CASE 2: ADD PRODUCT -------------------------------------------------------->
	<!----------------------------------------------------------------------------------------------------------------------------->

	<!-- DBS PROJECT -->
	<!-- Insert new PRODUCT -->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>Add Product: </h3>
			<h4>[MAIN USE CASE 2]</h4>
			<h4>Please fill in the Product information:</h4>
			<!-- opens confirmation page to let user know the INSERT was successul --> 
			<form method="post" action="addProduct.php"> 
				<!-- id textbox -->
				<!-- id is auto-incremented
				<div>
					<label for="id_product">Product ID:</label>
					<input id="id_product" name="id_product" type="number" placeholder='12345' min="1" max="99999">
				</div>
				<br>
				-->
				<!-- product_name textbox -->
				<div>
					<label for="product_name">Product name:</label>
					<input id="product_name" name="product_name" type="text" placeholder='Enter a name' maxlength="50">
				</div>
				<br>
				<!-- price textbox -->
				<div>
					<label for="price">Price (use comma):</label>
					<input id="price" name="price" type="float" placeholder='123456.78' min="1">
				</div>
				<br>
				<!-- indication textbox -->
				<div>
					<label for="indication">Indication:</label>
					<input id="indication" name="indication" type="text" placeholder='Indication name' maxlength="40">
				</div>
				<br>

				<!-- Submit button sends request when clicked -->
				<div>
					<button type="submit">
						Add Product
					</button>
				</div>
			</form>
	</div></div></div>


	<!----------------------------------------------- DISPLAY PRODUCTS ------------------------------------------------------------>

	<!-- TEST DISPLAY LAST 10 PRODUCTS -->
	<!-- Row    sizes: -sm|-md|-lg|-xl|-xxl-->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">

			<h3>Display newest 10 products</h3>
			<h4>[MAIN USE CASE 2]</h4>
			<h4>This is a list of the last 10 products that were registered</h4>
			<br>
			
		<table class="table table-sm table-hover table-striped table-bordered table-light ">
			<thead class="thead-dark">
				<tr>
					<th>Product ID</th>
					<th>Product name</th>
					<th>Price per unit</th>
					<th>Indication</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($product_array as $product) : ?>
					<tr>
						<td><?php echo $product['ID_product']; ?>  </td>
						<td><?php echo $product['Product_Name']; ?>  </td>
						<td><?php echo $product['Price'].' €'; ?>  </td>
						<td><?php echo $product['Indication']; ?>  </td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div></div></div>
	<br>
	 


	<!----------------------------------------------------------------------------------------------------------------------------->
	<!--------------------------------- Small use case 1: the 5 most recent orders ------------------------------------------------>
	<!----------------------------------------------------------------------------------------------------------------------------->


	<!-- MOST RECENT ORDERS -->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>List of the most recent Orders</h3>
			<h4>[SMALL USE CASE 1]</h4>
				<table class="table table-sm table-hover table-striped table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>Order ID</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Client</th>
							<th>Order Date</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($order_array as $order) : ?>
						<tr>
							<td><?php echo $order['ID_Orders']; ?>  </td>
							<td><?php echo $order['Product_Name']; ?>  </td>
							<td><?php echo $order['Quantity']; ?>  </td>
							<td><?php echo $order['Client_Name']; ?>  </td>
							<td><?php echo $order['Order_Date']; ?>  </td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
	</div></div></div>
	<br>

	 	

	<!----------------------------------------------------------------------------------------------------------------------------->
	<!--------------------------------- Small use case 2: Who is GM of my region?  ------------------------------------------------>
	<!----------------------------------------------------------------------------------------------------------------------------->


	<!-- MOST RECENT ORDERS -->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>Find out who the GM of a given region is!</h3>
			<h4>[SMALL USE CASE 2]</h4>
				<!-- opens confirmation page to let user know the INSERT was successul --> 
				<form method="post" action="findGmOfRegion.php">
				<!-- Region name textbox -->
				<div>
					<label for="regionname">Enter a region:</label> 
					<input id="regionname" name="regionname" type="text" placeholder='Region name' maxlength="50">
				</div>
				<br>

				<!-- Submit button sends request and leads to a result page -->
				<div>
				<button id='submit' type='submit'>
						Find Person
					</button>
				</div>
			</form>
	</div></div></div>
	<br>




	<!----------------------------------------------------------------------------------------------------------------------------->
	<!----- REPORT 1: The 5 most expensive products, which a client ordered in the given time interval? (default=last month) ------>
	<!----------------------------------------------------------------------------------------------------------------------------->


	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>Report the five most expensive products ordered within a given time interval</h3>
			<h4>[REPORT 1]</h4>
				<!-- opens confirmation page to let user know the INSERT was successul --> 
				<form method="post" action="reportProducts.php">
				<!-- Region name textbox -->
				<div>
					<label for="timeinterval">Choose time interval:</label> 
					<input id="timeinterval" name="timeinterval" type="text" placeholder='Month' max="9999">
				</div>
				<br>

				<!-- Submit button sends request and leads to a result page -->
				<div>
				<button id='submit' type='submit'>
						Submit report
					</button>
				</div>
			</form>
	</div></div></div>
	<br>



	<!----------------------------------------------------------------------------------------------------------------------------->
	<!----- REPORT 2: Key clients in terms of generated revenue ----->
	<!----------------------------------------------------------------------------------------------------------------------------->

	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>Report the key clients in terms of revenue </h3>
			<h4>[REPORT 2]</h4>
				<!-- opens confirmation page to let user know the INSERT was successul --> 
				<form method="post" action="reportKeyClients.php">
				<!-- Region name textbox -->
				<div>
					<label for="region_param">Choose a region:</label> 
					<input id="region_param" name="region_param" type="text" placeholder='Region name' maxlength="50">
				</div>
				<br>
				<!-- Submit button sends request and leads to a result page -->
				<div>
				<button id='submit' type='submit'>
						Submit report
					</button>
				</div>
			</form>
	</div></div></div>
	<br>
	<br>
	<hr>







</div> <!-- end of container -->

	<!-- BOOTSTRAP JS -->	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
	integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
	integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

</body>
</html>
