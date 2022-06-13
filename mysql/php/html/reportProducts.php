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
        <h1>Reporting the five most expensive products ordered within the given time interval</h1>
        <?php 
            $timeinterval = '1'; // default value 1 MONTH

            //Grab variables from POST request
            if(isset($_POST['timeinterval'])){
                $timeinterval = $_POST['timeinterval'];

                if($timeinterval > 1) {
                    echo "Searched through DB entries of the last {$timeinterval} months!";
                }
                else{ //} if($timeinterval = 1) {
                    echo "Searched through DB entries of the last month! (default = 1)";
                }
            }

            //include DatabaseHelper.php file
            require_once('DatabaseHelper.php');

            //instantiate DatabaseHelper class
            $database = new DatabaseHelper();

            // Call seach function in DatabaseHelper
            $exp_ord_product_array = $database->selectExpensiveOrderedProducts($timeinterval);

            // Check result
            if($exp_ord_product_array): ?>

                <table class="table table-sm table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Customer</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php foreach ($exp_ord_product_array as $eop) : ?>
                            <!-- HTML part --> 
                                <tr>
                                    <td><?php echo $eop['Product_Name']; ?>  </td>
                                    <td><?php echo $eop['Price'].' €'; ?>  </td>
                                    <td><?php echo $eop['Order_Date']; ?>  </td>
                                    <td><?php echo $eop['Client_Name']; ?>  </td>
                                </tr>
                            <?php endforeach; ?> 
                        </tbody>
                </table>
            <?php endif ?>
            
    <!-- link back to index page-->
    <br><br>
    <a href="index.php">
        go back
    </a>
	</div></div></div>
