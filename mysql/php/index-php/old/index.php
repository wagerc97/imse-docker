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

$product_array = $database->selectFromProduct();

//$employee_array = $database->selectFromEmployeeWhere ($id_employee, $firstname, $lastname, $team_leader);

$region_array = $database->selectFromCountpreg();

//$country_array = $database->selectFromCountry();
	
//$client_array = $database->selectFromClient ($id_client, $client_client_name, $client_country_name);	

//$campaign_array = $database->selectFromCampaign();

//$markemp_array = $database->selectFromMarkEmp($markemp_date);

//$order_array = $database->selectFromOrders();

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
	


<div class="container"> <!-- Centering-->

	<br>
	<div class="row "> 
		<div class="col-lg-12"><div class="p-4 border-dark bg-success">

		<!-- header --> 
		<h1>
			Webapplication for Database
		</h1>
		<h2>
			Welcome to our IMSE Web Application of IMSErgo Ltd. - <br>
			Pharmacutical Company and Project Realisation
		</h2>
		<h3>
			by Claas Fillies, A12047732 
			and Clemens Wager, A01635477<br>
			for 052400-1 VU Information Management and Systems Engineering (SS2022)<br>
		</h3>
	</div></div></div>
	<br>

	<!------------------------------------------------------------------------->
	<!----------------------- Test to display all products -------------------->
	<!------------------------------------------------------------------------->

	<!-- Row    sizes: -sm|-md|-lg|-xl|-xxl-->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">

			<!-- DBS PROJECT -->
			<!-- Display REGION table -->
			<h3>Test to display up to 40 products</h3>
			<h4>This is a list of 40 products that were imported using the Java application</h4>
			<br>
			
		<table class="table table-sm table-hover table-striped table-bordered table-light ">
			<thead class="thead-dark">
				<tr>
					<th>Product ID</th>
					<th>Product name</th>
					<th>Price in EUR</th>
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
	<!-- </div>end row -->
	 
	 
	 	 

	<!------------------------------------------------------------------------->
	<!----------------------- REGION & GM ------------------------------------->
	<!------------------------------------------------------------------------->

	<!-- Row    sizes: -sm|-md|-lg|-xl|-xxl-->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">

			<!-- DBS PROJECT -->
			<!-- Display REGION table -->
			<h3>All Regions and their assigned GM:</h3>
			<h4>This is a list of all Regions where DBSan Ltd. operates with their assigned General Manager.</h4>
			<br>
			
		<table class="table table-sm table-hover table-striped table-bordered table-light ">
			<thead class="thead-dark">
				<tr>
					<th>Region ID</th>
					<th>Region name</th>
					<th>Related countries</th>
					<th>Assigned GM</th>
					<th>ID of GM</th>

				</tr>
			</thead>
			<tbody>
				<!-- <?php //foreach ($region_array as $region) : ?> old foreach solution -->
				<?php 
				// 
				
				// numeric array Source: https://www.php.net/manual/de/mysqli-result.fetch-array.php
				
				// $row = $result->fetch_array(MYSQLI_NUM);
				// printf("%s (%s)\n", $row[0], $row[1]);


					//Loop through the $posts array IF it is an array.
					if(is_array($region_array)){

						foreach($region_array as $region){
							//Do something.
				?>
					<tr>
						<td><?php echo $region['ID_Region']; ?>  </td>
						<td><?php echo $region['Region_Name']; ?>  </td>
						<td><?php echo $region['Count_country'].'x'; ?>  </td>
						<td><?php echo $region['lastname']; ?>  </td>
						<td><?php echo $region['ID_Employee']; ?>  </td>
					</tr>
						<?php }
					} else {
						echo('Error: $result is not an array');
					}?>
				<!-- <?php //endforeach; ?> -->
			</tbody>
		</table>
		<?php echo('EVERYTHING BELOW THIS TABLE IS UNDER CONSTRUCTION. "hic sunt dracones..."'); ?>

	</div></div></div>
	<br>
	 <!-- </div>end row -->


	<!----------------------------------------------------------------------------------------------------------------------------->
	<!-------------------------------------------------- COUNTRIES ---------------------------------------------------------------->
	<!----------------------------------------------------------------------------------------------------------------------------->


	<!-- DBS PROJECT -->
	<!-- Display Country table with view -->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>All Countries:</h3>
			<h4>These are the Countries where our Clients are located.</h4>
		<table class="table table-sm table-hover table-striped table-bordered table-light ">
			<thead class="thead-dark">
			<tr>
				<th>Number of Clients</th>
				<th>Country</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach ($country_array as $country) : ?>
					<tr>
						<td><?php echo $country['COUNT_CLIENT']; ?>  </td>
						<td><?php echo $country['COUNTRY_NAME']; ?>  </td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div></div></div>
	<br>



	<!----------------------------------------------------------------------------------------------------------------------------->
	<!--------------------------------------------------- CLIENT ------------------------------------------------------------------>
	<!----------------------------------------------------------------------------------------------------------------------------->



	<!-- DBS PROJECT -->
	<!-- Insert new CLIENT -->
 	<div class="row"> 
		<div class="col-lg-6"><div class="p-4 border bg-light">
				<h3>Add Client</h3>
				<h4>Please fill in the Client information:</h4>
				
			<!-- opens confirmation page to let user know the INSERT was successul --> 
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
		
		<!-- Delete CLIENT -->
		<div class="col-lg-6"><div class="p-4 border bg-light">
			<h3>Delete Client</h3>
			<h4>Please enter the ID of the Client you want to delete from the database:</h4>
			<form method="post" action="delClient.php">
				<!-- ID textbox -->
				<div>
					<label for="del_id_client">ID:</label>
					<input id="del_id_client" name="del_id_client" type="number" placeholder='Enter a Client ID' min="0">
				</div>
				<br>

				<!-- Submit button -->
				<div>
					<button type="submit">
						Delete Client
					</button>
				</div>
			</form>
			<br>
		</div></div>
		<br>
	</div> <!-- end of row -->
	<br>

	<!-- DBS PROJECT -->
	<!-- Update form CLIENT -->
	 <div class="row"> 
		<div class="col-lg-6"><div class="p-4 border bg-light">
			<h3>Update Client</h3>
			<h4>Please enter the unique ID of the Client you want to update:</h4>
			<form method="post" action="updateClient.php"> 
				<!-- ID textbox:-->
				<div>
					<label for="up_id_client">Client ID:</label>
					<input id="up_id_client" name="up_id_client" type="number" placeholder='12345' 
						value='<?php echo $up_id_client; ?>' min="0" max="99999">
				</div>

				<h5>Enter new information:</h5>

				<!-- client_name textbox -->
				<div>
					<label for="up_client_name">Client name:</label>
					<input id="up_client_name" name="up_client_name" type="text" placeholder='Enter new name' 
					value='<?php echo $up_client_name; ?>' maxlength="25">
				</div>
				<br>
				<!-- country_name textbox -->
				<div>
					<label for="up_client_country">Country:</label>
					<input id="up_client_country" name="up_client_country" type="text" placeholder='Enter new country' 
					value='<?php echo $up_client_country; ?>' maxlength="25">
				</div>
				<br>
				
				<!-- Submit button sends request when clicked -->
				<!-- Submit button -->
				<div>
					<button id='submit' type='submit'>
						Update
					</button>
				</div>
			</form>
		</div></div>
		

	<!-- DBS PROJECT -->
	<!-- Search form -->
		<div class="col-lg-6"><div class="p-4 border bg-light">

			<h3>Search Client</h3>
			<h4>Please enter the information of the Client you are looking for:</h4>
			<form method="get">
				<!-- ID textbox:-->
				<div>
					<label for="id_client">Client ID:</label>
					<input id="id_client" name="id_client" type="number" placeholder='12345' 
						value='<?php echo $id_client; ?>' min="0" max="99999">
				</div>
				<br>

				<!-- Client name textbox:-->
				<div>
					<label for="client_client_name">Client name:</label>
					<input id="client_client_name" name="client_client_name" type="text" placeholder='Enter a name'
						value='<?php echo $client_client_name; ?>'maxlength="50">
				</div>
				<br>

				<!-- Country name textbox:-->
				<div>
					<label for="client_country_name">Country of Client:</label> 
					<input id="client_country_name" name="client_country_name" type="text" placeholder='Enter a country'
						value='<?php echo $client_country_name; ?>' maxlength="25">
				</div>
				<br>

				<!-- Submit button -->
				<div>
					<button id='submit' type='submit'>
						Search
					</button>
				</div>
			</form>
	</div></div></div>
	<br>


	<!-- DBS PROJECT -->
	<!-- CLIENT Search result -->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h2>Client Search Result:</h2>
			<h3>Displays the tuples of the Client table that were selected during Client Search</h3>
				<table class="table table-sm table-hover table-striped table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>Client ID</th>
							<th>Client name</th>
							<th>Country</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($client_array as $client) : ?>
							<tr>
								<td><?php echo $client['ID_CLIENT']; ?>  </td>
								<td><?php echo $client['CLIENT_NAME']; ?>  </td>
								<td><?php echo $client['COUNTRY_NAME']; ?>  </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<h5>... only the top results are visible!</h5>

	</div></div></div>



	<!-- DBS PROJECT -->
	<!-- KEY CLIENTS -->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h2>Key Clients:</h2>
			<h3>List of our Clients that issued more than five orders.</h3>
			<table class="table table-sm table-hover table-striped table-bordered">
				<thead class="thead-dark">
					<tr>
						<th>Client name</th>
						<th>Ordes issued<th>
					</tr>
					</thead>
					<tbody>
						<?php foreach ($key_client_array as $client) : ?>
							<tr>
								<td><?php echo $client['CLIENT_NAME']; ?>  </td>
								<td><?php echo $client['CIDC']; ?>  </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
			</table>
			<h5>... only the top results are visible!</h5>
	</div></div></div>
	<br>



	<!----------------------------------------------------------------------------------------------------------------------------->
	<!-------------------------------------------------- EMPLOYEE ----------------------------------------------------------------->
	<!----------------------------------------------------------------------------------------------------------------------------->




	<!-- DBS PROJECT -->
	<!-- Insert new EMPLOYEE -->
	<div class="row"> 
		<div class="col-lg-8"><div class="p-4 border bg-light">
			<h2>Hire new Employee: </h2>
			<h3>Please fill in the Employee information:</h3>
			<!-- opens confirmation page to let user know the INSERT was successul --> 
			<form method="post" action="addEmployee.php"> 
				<!-- firstname textbox -->
				<div>
					<label for="add_firstname">Firstname:</label>
					<input id="add_firstname" name="add_firstname" type="text" placeholder='Enter firstname' maxlength="25"
					value='<?php echo $add_firstname; ?>'>
				</div>
				<br>
				<!-- lastname textbox -->
				<div>
					<label for="add_lastname">Lastname:</label>
					<input id="add_lastname" name="add_lastname" type="text" placeholder='Enter lastname' maxlength="25"
					value='<?php echo $add_lastname; ?>'>
				</div>
				<br>
				<!-- gender textbox -->
				<div>
					<label for="add_gender">Gender:</label>
					<input id="add_gender" name="add_gender" type="text" placeholder='F/M/D' maxlength="1"
					value='<?php echo $add_gender; ?>'>
				</div>
				<br>
				<!-- salary textbox -->
				<div>
					<label for="add_salary">Salary:</label>
					<input id="add_salary" name="add_salary" type="number" placeholder='Enter a monthly salary' max="999999,99"
					value='<?php echo $add_salary; ?>'>
				</div>
				<br>
				<!-- team_leader textbox -->
				<div>
					<label for="add_team_leader">Team leader:</label>
					<input id="add_team_leader" name="add_team_leader" type="number" placeholder='Enter an ID' min="1"
					value='<?php echo $add_team_leader; ?>'>
				</div>
				<br>
				
				<!-- hire_date textbox -->
				<div>
					<label for="add_hire_date">Hire date:</label>
					<input id="add_hire_date" name="add_hire_date" type="date" placeholder='placeholder='DD.MM.YYYY'
					value='<?php echo $add_hire_date; ?>'>
				</div>
				<br>

				<!-- Submit button sends request when clicked -->
				<div>
					<button type="submit">
						Add Employee
					</button>
				</div>
			</form>
	</div></div>


	<!-- Delete CLIENT -->
	<div class="col-lg-4"><div class="p-4 border bg-light">
	<br><br><br>
		<h2>Delete Employee</h4>
		<h3>Please enter the ID of the Employee you want to fire:</h3>
		<form method="post" action="delEmployee.php">
			<!-- ID textbox -->
			<div>
				<label for="del_id_employee">ID:</label>
				<input id="del_id_employee" name="del_id_employee" type="number" placeholder='Enter an ID' min="1">
			</div>
			<br>
			<br>

			<!-- Submit button -->
			<div>
				<button type="submit">
					Delete Employee
				</button>
			</div>
		</form>
	<br><br><br><br><br>
	</div></div></div>
	
	<br>

	<!-- DBS PROJECT -->
	<!-- Search form EMPLOYEE-->
	<div class="row"> 
		<div class="col-lg-6"><div class="p-4 border bg-light">
		<br>
		<br>
		<br>
			<h2>Search Employee</h2>
			<h3>Please enter the information of the Employee you are looking for:</h3>
			<form method="get">
				<!-- ID textbox:-->
				<div>
					<label for="id_employee">ID:</label>
					<input id="id_employee" name="id_employee" type="number" placeholder='12345'
						value='<?php echo $id_employee; ?>' min="0">
				</div>
				<br>

				<!-- Firstname textbox:-->
				<div>
					<label for="firstname">Firstname:</label>
					<input id="firstname" name="firstname" type="text" placeholder='Enter a name'
						value='<?php echo $firstname; ?>'maxlength="25">
				</div>
				<br>

				<!-- Lastname textbox:-->
				<div>
					<label for="lastname">Lastname:</label>
					<input id="lastname" name="lastname" type="text" placeholder='Enter a name'
						value='<?php echo $lastname; ?>' maxlength="25">
				</div>
				<br>
				
				<!-- Team Leader textbox:-->
				<div>
					<label for="team_leader">Team Leader:</label>
					<input id="team_leader" name="team_leader" type="number" placeholder='Enter an employee ID'
						value='<?php echo $team_leader; ?>' min="1" maxlength="4">
				</div>
				<br>

				<!-- Submit button -->
				<div>
					<button id='submit' type='submit'>
						Search
					</button>
				</div>
			</form>
		<br><br><br>
		</div></div>



	<!-- DBS PROJECT -->
	<!-- Update form EMPLOYEE -->
		<div class="col-lg-6"><div class="p-4 border bg-light">
			<h2>Update Employee</h2>
			<h3>Please enter the unique ID of the Employee you want to update:</h3>
			<form method="post" action="updateEmployee.php"> 
				<!-- ID textbox:-->
				<div>
					<label for="up_id_employee">Employee ID:</label>
					<input id="up_id_employee" name="up_id_employee" type="number" placeholder='12345' 
						value='<?php echo $up_id_employee; ?>' min="0" max="999999999999">
				</div>

				<h4>Enter new information:</h4>

				<!-- firstname textbox -->
				<div>
					<label for="up_firstname">Firstname:</label>
					<input id="up_firstname" name="up_firstname" type="text" placeholder='Enter new firstname' 
					value='<?php echo $up_firstname; ?>' maxlength="25">
				</div>
				<br>
				
				<!-- lastname textbox -->
				<div>
					<label for="up_lastname">Lastname:</label>
					<input id="up_lastname" name="up_lastname" type="text" placeholder='Enter new lastname' 
					value='<?php echo $up_lastname; ?>' maxlength="25">
				</div>
				<br>
				
				<!-- gender textbox -->
				<div>
					<label for="up_gender">Gender:</label>
					<input id="up_gender" name="up_gender" type="text" placeholder='Enter new gender' 
					value='<?php echo $up_gender; ?>' maxlength="1">
				</div>
				<br>
				
				<!-- salary textbox -->
				<div>
					<label for="up_salary">Salary:</label>
					<input id="up_salary" name="up_salary" type="number" placeholder='Enter new salary' 
					value='<?php echo $up_salary; ?>' max="999999">
				</div>
				<br>
				
				<!-- team_leader textbox -->
				<div>
					<label for="up_team_leader">Team leader:</label>
					<input id="up_team_leader" name="up_team_leader" type="number" placeholder='Enter a new ID' 
					value='<?php echo $up_team_leader; ?>' min="1">
				</div>
				<br>

				<!-- Submit button sends request when clicked -->
				<!-- Submit button -->
				<div>
					<button id='submit' type='submit'>
						Update
					</button>
				</div>
			</form>
	</div></div></div>
	<br>


	<!-- DBS PROJECT -->
	<!-- Search result -->
	<div class="row"> 
	<div class="col-lg-12"><div class="p-4 border bg-light">
		<h2>Employee Search Result</h2>
		<h3>Displays the tuples of the Employee table that were selected during Employee Search</h3>
			<table class="table table-sm table-hover table-striped table-bordered">
				<thead class="thead-dark">
					<tr>
						<th>ID</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Gender</th>
						<th>Salary [€]</th>
						<th>Boss</th>
						<th>Hired since</th>
					</tr>
					</thead>
					<tbody>
						<?php foreach ($employee_array as $employee) : ?>
							<tr>
								<td><?php echo $employee['ID_EMPLOYEE']; ?>  </td>
								<td><?php echo $employee['FIRSTNAME']; ?>  </td>
								<td><?php echo $employee['LASTNAME']; ?>  </td>
								<td><?php echo $employee['GENDER']; ?>  </td>
								<td><?php echo $employee['SALARY']; ?>  </td>
								<td><?php echo $employee['TEAM_LEADER']; ?>  </td>
								<td><?php echo $employee['HIRE_DATE']; ?>  </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
		<h5>... only the top results are visible!</h5>
	</div></div></div>
	<br>



	<!----------------------------------------------------------------------------------------------------------------------------->
	<!--------------------------------------------------- PRODUCT ----------------------------------------------------------------->
	<!----------------------------------------------------------------------------------------------------------------------------->



	<!-- DBS PROJECT -->
	<!-- Insert new PRODUCT -->
	<div class="row"> 
		<div class="col-lg-6"><div class="p-4 border bg-light">
			<h3>Add Product: </h3>
			<h4>Please fill in the Product information:</h4>
			<!-- opens confirmation page to let user know the INSERT was successul --> 
			<form method="post" action="addProduct.php"> 
				<!-- id textbox -->
				<div>
					<label for="id_product">Product ID:</label>
					<input id="id_product" name="id_product" type="number" placeholder='12345' min="1" max="99999">
				</div>
				<br>
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



	<!-- DBS PROJECT -->
	<!-- Search result -->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h2>Complete Product List</h2>
			<h3>List of all Products that DBSan sells.</h3>
			<table class="table table-sm table-hover table-striped table-bordered">
				<thead class="thead-dark">
					<tr>
						<th>Product ID</th>
						<th>Name</th>
						<th>Price [€]</th>
						<th>Indication</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($product_array as $product) : ?>
						<tr>
							<td><?php echo $product['ID_PRODUCT']; ?>  </td>
							<td><?php echo $product['PRODUCT_NAME']; ?>  </td>
							<td><?php echo $product['PRICE']; ?>  </td>
							<td><?php echo $product['INDICATION']; ?>  </td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
	</div></div></div>
	<br>



	<!----------------------------------------------------------------------------------------------------------------------------->
	<!-------------------------------------------------- CAMPAIGN ----------------------------------------------------------------->
	<!----------------------------------------------------------------------------------------------------------------------------->


	<!-- DBS PROJECT -->
	<!-- Search result -->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h2>Long Campaigns</h2>
			<h3>List of all Product Campaigns that took more than one year.</h3>
				<table class="table table-sm table-hover table-striped table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>Product ID</th>
							<th>Campaign Name</th>
							<th>Start date</th>
							<th>End date</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($campaign_array as $campaign) : ?>
							<tr>
								<td><?php echo $campaign['ID_PRODUCT']; ?>  </td>
								<td><?php echo $campaign['CAMPAIGN_NAME']; ?>  </td>
								<td><?php echo $campaign['START_DATE']; ?>  </td>
								<td><?php echo $campaign['END_DATE']; ?>  </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
	</div></div></div>
	<br>
	
	
	<!----------------------------------------------------------------------------------------------------------------------------->
	<!-------------------------------------------- MARKETING EMPLOYYEES ----------------------------------------------------------->
	<!----------------------------------------------------------------------------------------------------------------------------->


	<!-- DBS PROJECT -->
	<!-- Search form EMPLOYEE-->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>Search Marketing Employees after hire date</h3>
			<h4>Please enter the earliest hire date of Marketing Employees that you want to list below:</h4>
			<form method="get">
				<!-- DATE textbox:-->
				<div>
					<label for="markemp_date">Earliest hire date:</label>
					<input id="markemp_date" name="markemp_date" type="date" placeholder='DD.MM.YYYY'
						value='<?php echo $markemp_date; ?>' >
				</div>
				<br>
				<!-- Submit button -->
				<div>
					<button id='submit' type='submit'>
						Search
					</button>
				</div>
			</form>
	</div></div>


	<!-- DBS PROJECT -->
	<!-- Search result -->
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>Marketing Employees Search Result</h3>
			<h4>List of all Employees in the marketing sector.</h4>
				<table class="table table-sm table-hover table-striped table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Occupation</th>
							<th>Hire date</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($markemp_array as $marketing) : ?>
							<tr>
								<td><?php echo $marketing['ID_EMPLOYEE']; ?>  </td>
								<td><?php echo $marketing['LASTNAME']; ?>  </td>
								<td><?php echo $marketing['OCCUPATION']; ?>  </td>
								<td><?php echo $marketing['HIRE_DATE']; ?>  </td>
								</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
	</div></div></div>
	<br>



	<!----------------------------------------------------------------------------------------------------------------------------->
	<!-------------------------------------------------- ADVERTISES --------------------------------------------------------------->
	<!----------------------------------------------------------------------------------------------------------------------------->


	<!-- DBS PROJECT -->
	<!-- Search Advertises-->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>Which marketing employee advertises which product?</h3>
				<table class="table table-sm table-hover table-striped table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>Employee ID</th>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>Product</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($ads_array as $ads) : ?>
							<tr>
								<td><?php echo $ads['ID_EMPLOYEE']; ?>  </td>
								<td><?php echo $ads['FIRSTNAME']; ?>  </td>
								<td><?php echo $ads['LASTNAME']; ?>  </td>
								<td><?php echo $ads['PRODUCT_NAME']; ?>  </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
						<h5>... only the top results are visible!</h5>
	</div></div></div>
	<br>



	<!----------------------------------------------------------------------------------------------------------------------------->
	<!---------------------------------------------------- ORDERS ----------------------------------------------------------------->
	<!----------------------------------------------------------------------------------------------------------------------------->

	<!-- DBS PROJECT -->
	<!-- Search result ORDERS-->
	<div class="row"> 
		<div class="col-lg-12"><div class="p-4 border bg-light">
			<h3>List of the most recent Orders:</h3>
				<table class="table table-sm table-hover table-striped table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>Order ID</th>
							<th>Date of order</th>
							<th>Product ID</th>
							<th>Product Name</th>
							<th>Client ID</th>
							<th>Quantity</th>
							<th>Revenue [€]</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($order_array as $order) : ?>
						<tr>
							<td><?php echo $order['ID_ORDERS']; ?>  </td>
							<td><?php echo $order['ORDER_DATE']; ?>  </td>
							<td><?php echo $order['ID_PRODUCT']; ?>  </td>
							<td><?php echo $order['PRODUCT_NAME']; ?>  </td>
							<td><?php echo $order['ID_CLIENT']; ?>  </td>
							<td><?php echo $order['QUANTITY']; ?>  </td>
							<td><?php echo $order['REVENUE']; ?>  </td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
						<h5>... only the top results are visible!</h5>
	</div></div></div>
	<br>


</div> <!-- end of container -->


	<!-- BOOTSTRAP JS -->	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
	integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
	integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

</body>
</html>