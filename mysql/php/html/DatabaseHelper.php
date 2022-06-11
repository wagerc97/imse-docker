<!--------------------------------------------------
DatabaseHelper.php
Disclaimer: Adapted version from DBS Project 2021
---------------------------------------------------->

<?php

// turn of all warnings
//warning_reporting(0);

//---------------------------------------------------
//------------------- CONNECTION --------------------
//---------------------------------------------------
class DatabaseHelper
{
	// Since the connection details are constant, define them as const
	// We can refer to constants like e.g. DatabaseHelper::username
	const host = 'db';  //service name from docker-compose.yml
	const user = 'devuser'; // use a + your matriculation number  
	const password = 'devpass'; // use your oracle db password
	const db = 'PharmaComp';  // database name
	
	
    // Since we need only one connection object, it can be stored in a member variable.
    // $conn is set in the constructor.
    protected $conn;

    public function __construct()
    {
        try {
			$this->conn = mysqli_connect(
			DatabaseHelper::host, 
			DatabaseHelper::user, 
			DatabaseHelper::password, 
			DatabaseHelper::db);		

			// Check if the connection failed 
			if ($this->conn->connect_error) {
				die('Connect Error: ' . $conn->connect_error);
			}
		} catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
	}
    // Used to clean up
    public function __destruct()
    {
        // clean up
        @mysqli_close($this->conn);
    }
	
	
	
	


//TODO
//---------------------------------------------------
//------------- MAIN USE CASE 1 ---------------------
//---------------------------------------------------
//------------- INSERT CLIENT -----------------------
//---------------------------------------------------
	// adds a new row to the CLIENT table 
    public function addClient($client_client_name, $client_country_name)
	{
        $sql = "INSERT INTO Client (client_name, country_name) 
				VALUES ('{$client_client_name}', '{$client_country_name}')";
		
        //$stmt = @oci_parse($this->conn, $sql);
        $stmt = $conn->prepare($sql);

        //$success = @oci_execute($stmt) && @oci_commit($this->conn);
        $success = @mysqli_stmt_execute($stmt) && @mysqli_commit($this->conn);

        //@oci_free_stmt($stmt);
        @mysql_free_result($stmt);

        return $success;
    }

//TODO
//---------------------------------------------------
//------------- MAIN USE CASE 2 ---------------------
//---------------------------------------------------
//------------- INSERT PRODUCT ----------------------
//---------------------------------------------------
	// adds a new row to the PRODUCT table (ID_product(4), Name_product, Price, Indication)
    public function addProduct($id_product, $product_name, $price, $indication)
	{
        $sql = "INSERT INTO Product (ID_product, Product_Name, Price, Indication) 
				VALUES ('{$id_product}', '{$product_name}', '{$price}', '{$indication}')";
		
        //$stmt = @oci_parse($this->conn, $sql);
		$stmt = $conn->prepare($sql); 

        //$success = @oci_execute($stmt) && @oci_commit($this->conn);
        $success = @mysqli_stmt_execute($stmt) && @mysqli_commit($this->conn);

		//@oci_free_stmt($stmt);
        @mysql_free_result($stmt);
		
		return $success;
    }
	




















		
		
} // end of DatabaseHelper
?>
