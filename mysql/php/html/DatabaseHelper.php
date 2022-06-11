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
	


	
//SELECT... DISPLAY  ==> USED TO TEST ON MYSQL <== 
	// selects the whole PRODUCT table
    public function selectFromProduct()//$sel_id_product, $sel_product_name, $sel_price, $sel_indication)
    {
        // Define the sql stmt string
        // show the last / youngest 10 entries -> to confirm that main use case "Register Product" works. 
		$sql= "SELECT * FROM Product LIMIT 10"; 
		
		
        // oci_parse prepares the Oracle stmt for execution
        //$stmt = @oci_parse($this->conn, $sql); // oracle sql
		//$stmt = $this->conn->prepare($sql); // mysqli

        // Executes the stmt
        //@oci_execute($stmt); // oracle sql
		
        //@oci_fetch_all($stmt, $result, 0, 0, OCI_FETCHstmt_BY_ROW); // oracle sql

        //clean up;
        //@oci_free_stmt($stmt); // oracle sql
		
		// query db --> newly added for mysqli 
		$result = mysqli_query($this->conn, $sql);


        return $result;
    } 
	
    
//SELECT... DISPLAY  ==> USED TO TEST ON MYSQL <== 
	// selects the whole CLIENT table
    public function selectFromClient()//$sel_id_product, $sel_product_name, $sel_price, $sel_indication)
    {
        // Define the sql stmt string
        // show the last / youngest 10 entries -> to confirm that main use case "Register Product" works. 
		$sql= "SELECT * FROM Client LIMIT 10"; 
		
		
        // oci_parse prepares the Oracle stmt for execution
        //$stmt = @oci_parse($this->conn, $sql); // oracle sql
		//$stmt = $this->conn->prepare($sql); // mysqli

        // Executes the stmt
        //@oci_execute($stmt); // oracle sql
		
        //@oci_fetch_all($stmt, $result, 0, 0, OCI_FETCHstmt_BY_ROW); // oracle sql

        //clean up;
        //@oci_free_stmt($stmt); // oracle sql
		
		// query db --> newly added for mysqli 
		$result = mysqli_query($this->conn, $sql);


        return $result;
    } 
	

















		
		
} // end of DatabaseHelper
?>
