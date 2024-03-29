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
        <h1>Reporting the five most expensive products priced below the given price limit</h1>
        <?php 
            $price_limit = '1'; // default value 1 MONTH

            //Grab variables from POST request

            if(isset($_POST['price_limit'])){
                $price_limit = $_POST['price_limit'];
            }
            if ($price_limit == '') { 
                $price_limit = 0;
            }

            if ($price_limit == 0) {
                echo "Error: Price limit cannot be 0!";
            }
            elseif ($price_limit < 0) {
                echo "Error: Price limit cannot be negative!";
            }
            else {
                echo "Searched for products that cost less than {$price_limit} €";
                

                //include DatabaseHelper.php file
                require_once('DatabaseHelper.php');

                //instantiate DatabaseHelper class
                $database = new DatabaseHelper();

                // Call seach function in DatabaseHelper
                $exp_ord_product_array = $database->selectProductsUnderPriceLimit($price_limit);

                // Check result
                if($exp_ord_product_array): ?>

                <table class="table table-sm table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Indication</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php foreach ($exp_ord_product_array as $eop) : ?>
                            <!-- HTML part --> 
                                <tr>
                                <td><?php echo $eop['ID_product']; ?>  </td>
                                <td><?php echo $eop['Product_Name']; ?></td>
                                <td><?php echo $eop['Indication']; ?>  </td>
                                <td><?php echo $eop['Price'].' €'; ?>  </td>
                                </tr>
                            <?php endforeach; ?> 
                        </tbody>
                </table>
            <?php endif; } ?>
            
    <!-- link back to index page-->
    <br><br>
    <a href="index.php">
        <button>go back</button>
    </a>
	</div></div></div>
