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
        $stmt = $this->conn->prepare($sql);

        //$success = @oci_execute($stmt) && @oci_commit($this->conn);
        $success = @mysqli_stmt_execute($stmt) && @mysqli_commit($this->conn);

        return $success;
    }



//SELECT... DISPLAY  ==> USED TO TEST ON MYSQL <== 
	// selects the whole CLIENT table
    public function selectFromClient()//$sel_id_product, $sel_product_name, $sel_price, $sel_indication)
    {
        // Define the sql stmt string
        // show the last / youngest 10 entries -> to confirm that main use case "Register Product" works. 
		$sql= "SELECT * FROM Client ORDER BY ID_client DESC LIMIT 10;"; 
		
		$result = mysqli_query($this->conn, $sql);

        return $result;
    } 
	



//---------------------------------------------------
//------------- MAIN USE CASE 2 ---------------------
//---------------------------------------------------
//------------- INSERT PRODUCT ----------------------
//---------------------------------------------------
	// adds a new row to the PRODUCT table (ID_product(4), Name_product, Price, Indication)
    //public function addProduct($id_product, $product_name, $price, $indication)
    public function addProduct($product_name, $price, $indication)
	{
        //$sql = "INSERT INTO Product (ID_product, Product_Name, Price, Indication) 
        $sql = "INSERT INTO Product (Product_Name, Price, Indication) 
				VALUES ('{$product_name}', '{$price}', '{$indication}')";
                // VALUES ('{$id_product}', '{$product_name}', '{$price}', '{$indication}')";
                
        //$stmt = @oci_parse($this->conn, $sql);
		$stmt = $this->conn->prepare($sql); 

        //$success = @oci_execute($stmt) && @oci_commit($this->conn);
        $success = @mysqli_stmt_execute($stmt) && @mysqli_commit($this->conn);
		
		return $success;
    }


	
//SELECT... DISPLAY  ==> USED TO TEST ON MYSQL <== 
	// selects the whole PRODUCT table
    public function selectFromProduct()//$sel_id_product, $sel_product_name, $sel_price, $sel_indication)
    {
        // Define the sql stmt string
        // show the last / youngest 10 entries -> to confirm that main use case "Register Product" works. 
		$sql= "SELECT * FROM Product ORDER BY ID_product DESC LIMIT 10"; 
		
		$result = mysqli_query($this->conn, $sql);

        return $result;
    } 
	


//---------------------------------------------------
//------------- SMALL USE CASE 1 --------------------
//---------------------------------------------------
//----------- MOST RECENT ORDERS --------------------
//---------------------------------------------------
//SELECT... DISPLAY
    // select last 5 rows of ORDERS table
    public function selectFromOrders()
    {
        // Define the sql stmt string
        $sql= "SELECT  o.ID_Orders, p.Product_Name, o.Quantity , c.Client_Name, o.Order_Date
                FROM Orders o
                INNER JOIN Client c
                    ON o.ID_Client = c.ID_client
                INNER JOIN Product p
                    ON o.ID_Product = p.ID_product
                    ORDER BY Order_Date DESC 
                    LIMIT 5;"; 
        
        $result = mysqli_query($this->conn, $sql);

        return $result;
    } 



//---------------------------------------------------
//------------- SMALL USE CASE 2 --------------------
//---------------------------------------------------
//-------- Who is the GM of my region? --------------
//---------------------------------------------------
    // select last 5 rows of ORDERS table
    public function selectTheGM($regionname)
    {
        // Define the sql stmt string
        $sql = "SELECT r.Region_Name, e.Firstname, e.Lastname, e.ID_employee 
                FROM Employee e
                INNER JOIN General_Manager g
                    ON e.ID_employee = g.ID_employee
                INNER JOIN Region r
                    ON g.ID_region = r.ID_region
                WHERE Region_Name LIKE '%{$regionname}%'";

        $result = mysqli_query($this->conn, $sql);

        return $result;
    } 




//---------------------------------------------------
//------------------- REPORT 1 ----------------------
//---------------------------------------------------
//-------- Most expensive products ordered ----------
//---------------------------------------------------
    public function selectExpensiveOrderedProducts($timeinterval)
    {
        // Define the sql stmt string
        // The Docker time is 2h behind CET
        $sql = "SELECT p.Product_Name, p.Price, o.Order_Date, c.Client_Name
                FROM Orders o
                INNER JOIN Client c
                    ON o.ID_Client = c.ID_client
                INNER JOIN Product p
                    ON o.ID_Product = p.ID_product  
                WHERE 
                    Order_Date <= (SELECT CURDATE() AS Today) AND
                    Order_Date >= (SELECT CURDATE() AS Today) - INTERVAL '{$timeinterval}' MONTH
                ORDER BY Price DESC
                LIMIT 5 ;";

        $result = mysqli_query($this->conn, $sql);

        return $result;
    } 



    

//---------------------------------------------------
//------------------- REPORT 2 ----------------------
//---------------------------------------------------
//------- 5 key clients in terms of revenue ---------
//---------------------------------------------------
public function selectKeyClients($region_param)
{
    // Define the sql stmt string
    // This query uses helper views in the sql CREATE script
    $sql = "SELECT  c.Client_Name, y.Region_Name, -- #3 group rows with the same ID_Client
                SUM(y.sum_of_orders) AS sum_of_orders_per_client, 
                SUM(y.sum_of_revenue) AS sum_of_rev_per_client
                FROM Client c 
                INNER JOIN 
                ( 
                -- #2 filter clients per 'Region_Name' and add the revenue column
                SELECT  c.ID_client, r.Region_Name, 
                    SUM(x.revenue_per_order) AS sum_of_revenue, 
                    SUM(x.ID_Orders) AS sum_of_orders
                    FROM Client c -- get Client data
                    NATURAL JOIN Country t NATURAL JOIN Region r -- get connection to Region for filter
                    INNER JOIN -- get order revenues
                    (
                    -- #1 get revenue per order and other order information 
                    SELECT  o.ID_client, o.ID_Orders, p.ID_Product, p.Price*o.Quantity revenue_per_order
                        FROM Orders o
                            INNER JOIN Product p ON p.ID_Product = o.ID_Product
                    ) x ON c.ID_client = x.ID_client
                    WHERE r.Region_Name LIKE '%{$region_param}%'
                    GROUP BY c.ID_client, x.ID_Orders, r.Region_Name
                ) y ON c.ID_client = y.ID_client
                GROUP BY c.Client_Name, y.Region_Name
                ORDER BY sum_of_rev_per_client DESC
                LIMIT 5 ;";

    $result = mysqli_query($this->conn, $sql);

    return $result;
} 














		
		
} // end of DatabaseHelper
?>
