<!--------------------------------------------------
	DatabaseHelper.php
from YouTube
----------------------------------------------------> 

<?php

// turn of all warnings
//warning_reporting(0);

//---------------------------------------------------
//------------------- CONNECTION --------------------
//---------------------------------------------------
//CONNECT


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
		
			//$conn = null;
			//$conn = new mysqli($host, $user, $password, $db);

			//if ($conn->connect_error) {
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
//------------- INSERT Functions --------------------
//---------------------------------------------------

	
//INSERT	CLIENT
	// adds a new row to the CLIENT table 
    public function addClient($client_client_name, $client_country_name)
	{
        $sql = "INSERT INTO Client (client_name, country_name) 
				VALUES ('{$client_client_name}', '{$client_country_name}')";
		
        $stmt = @oci_parse($this->conn, $sql);
        $success = @oci_execute($stmt) && @oci_commit($this->conn);
        @oci_free_stmt($stmt);
        return $success;
    }
	

//INSERT	PRODUCT
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
	
	
//INSERT	EMPLOYEE
	// adds a new row to the EMPLOYEE table
    public function addEmployee
		($add_firstname, $add_lastname, $add_gender, $add_salary, $add_team_leader, $add_hire_date)
	{
        $sql = "INSERT INTO Employee 
					(
						Firstname, Lastname, Gender, Salary, Team_leader, Hire_date
					) 
				VALUES 
					(
					'{$add_firstname}', '{$add_lastname}', '{$add_gender}', '{$add_salary}', 
						'{$add_team_leader}', to_date('{$add_hire_date}','YYYY-MM-DD')
					)";
					
        $stmt = @oci_parse($this->conn, $sql);
        $success = @oci_execute($stmt) && @oci_commit($this->conn);
        @oci_free_stmt($stmt);
        return $success;
    }
	


//---------------------------------------------------
//--------------- SELECT Functions ------------------
//---------------------------------------------------

	
	
//SELECT... SEARCH
    // This function creates and executes a SQL select stmt and returns an array as the result
    // 2-dimensional array: the result array contains nested arrays (each contains the data of a single row)
    public function selectFromEmployeeWhere($id_employee, $firstname, $lastname, $team_leader)
    {
        // Define the sql stmt string
        // Notice that the parameters $id_employee, $firstname, $lastname in the 'WHERE' clause
        $sql = "SELECT * FROM Employee
            WHERE id_employee 	LIKE '%{$id_employee}%'
              AND firstname		LIKE '%{$firstname}%'
              AND lastname		LIKE '%{$lastname}%'
			  AND team_leader 	LIKE '%{$team_leader}%'

            ORDER BY ID_Employee ASC LIMIT 30";  
		
		//Translated with: https://www.php.net/manual/de/mysqli-stmt.execute.php#:~:text=n%22%2C%C2%A0%24row%5B0%5D%2C%C2%A0%24row%5B1%5D%2C%C2%A0%24row%5B2%5D)%3B%0A%7D-,Prozeduraler%20Stil,-%3C%3Fphp%0A%0Amysqli_report(MYSQLI_REPORT_ERROR%C2%A0%7C%C2%A0MYSQLI_REPORT_STRICT)%3B%0A%24link%C2%A0%3D%C2%A0mysqli_connect(%22localhost 
		
		// QUERY the db	
		$result = mysqli_query($this->conn, $sql);
		
		// PREPARE stmt 
        // oci_parse(...) prepares the Oracle stmt for execution
        // notice the reference to the class variable $this->conn (set in the constructor)
        //$stmt = @oci_parse($this->conn, $sql);
        //$stmt = mysqli_prepare($this->conn, $sql);

        // EXECUTE a prepared statement 
		//@oci_execute($stmt);
        //mysqli_stmt_execute($stmt);


        //FREE resources, clean up
        //mysql_free_result($stmt);

        return $result;
    } 
	
	
//SELECT... DISPLAY
	// selects the whole countpreg view
    public function selectFromCountpreg()
    {
        // Define the sql stmt string
      /*   $sql = "SELECT ID_Region, Region_Name FROM Region
			ORDER BY ID_Region ASC";   */
		$sql =  "SELECT * FROM Product"; //countpreg
	
        // oci_parse prepares the Oracle stmt for execution
        //$stmt = @oci_parse($this->conn, $sql);

        // Executes the stmt
        //@oci_execute($stmt);
        //@oci_fetch_all($stmt, $result, 0, 0, OCI_FETCHstmt_BY_ROW);

        //clean up;
        //@oci_free_stmt($stmt);
		
		$result = mysqli_query($this->conn, $sql);
		//$row = $result->fetch_array(MYSQLI_NUM); // numeric array

        //return $result;
        return $result;
    } 
	
//SELECT... DISPLAY
	// selects the whole region table
    public function selectFromCountry()//$country_country_name, $country_client_name)
    {
        // Define the sql stmt string
		$sql =  "SELECT * FROM clientpcount";

        // oci_parse prepares the Oracle stmt for execution
        $stmt = @oci_parse($this->conn, $sql);

        // Executes the stmt
        @oci_execute($stmt);
        @oci_fetch_all($stmt, $result, 0, 0, OCI_FETCHstmt_BY_ROW);

        //clean up;
        @oci_free_stmt($stmt);

        return $result;
    } 

//SELECT... SEARCH
		// selects the whole region table
    public function selectFromClient ($id_client, $client_client_name, $client_country_name)
    {
        // Define the sql stmt string
        $sql = "SELECT * FROM CLIENT 
				WHERE id_client 	LIKE '%{$id_client}%' 
				AND client_name		LIKE '%{$client_client_name}%' 
				AND country_name 	LIKE '%{$client_country_name}%' 
				ORDER BY id_client ASC";   	
		
        // oci_parse prepares the Oracle stmt for execution
        $stmt = @oci_parse($this->conn, $sql);

        // Executes the stmt
        @oci_execute($stmt);
        @oci_fetch_all($stmt, $result, 0, 30, OCI_FETCHstmt_BY_ROW);

        //clean up;
        @oci_free_stmt($stmt);

        return $result;
    } 
	
//SELECT... DISPLAY
	// selects the whole PRODUCT table
    public function selectFromProduct()//$sel_id_product, $sel_product_name, $sel_price, $sel_indication)
    {
        // Define the sql stmt string
        // just select all colums
		$sql= "SELECT * FROM Product 
			   ORDER BY PRODUCT_NAME
			   LIMIT 40"; // TEST for DEBUGGING remove 'LIMIT 40' +++
		
		
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
	
//SELECT... DISPLAY
	// selects the whole CAMPAIGN table
    public function selectFromCampaign()
    {
        // Define the sql stmt string
        // just select all colums
		$sql= "SELECT * FROM camps
				ORDER BY START_DATE";			
		
        // oci_parse prepares the Oracle stmt for execution
        $stmt = @oci_parse($this->conn, $sql);

        // Executes the stmt
        @oci_execute($stmt);
        @oci_fetch_all($stmt, $result, 0, 0, OCI_FETCHstmt_BY_ROW);

        //clean up;
        @oci_free_stmt($stmt);

        return $result;
    } 
	
	
//SELECT... DISPLAY
	// selects the whole MARKETING EMPLOYEES table
    public function selectFromMarkEmp($markemp_date)
    {
        // Define the sql stmt string
        // just select all colums
		$sql = "SELECT m.ID_Employee, e.Lastname, Occupation, e.hire_date
				FROM Employee e
					INNER JOIN MARKETING_EMP m
						ON e.ID_Employee = m.ID_Employee
				WHERE e.hire_date > to_date('{$markemp_date}','YYYY-MM-DD')
				ORDER BY e.hire_date ASC";		
		
        // oci_parse prepares the Oracle stmt for execution
        $stmt = @oci_parse($this->conn, $sql);

        // Executes the stmt
        @oci_execute($stmt);
        @oci_fetch_all($stmt, $result, 0, 0, OCI_FETCHstmt_BY_ROW);

        //clean up;
        @oci_free_stmt($stmt);

        return $result;
    } 


//SELECT... DISPLAY
		// selects the whole ORDERS table
    public function selectFromOrders()
    {
        // Define the sql stmt string 
		
		$sql1 = "SELECT * FROM ord_rev
				 ORDER BY order_date DESC";
		
        // oci_parse prepares the Oracle stmt for execution
        $stmt = @oci_parse($this->conn, $sql1);

        // Executes the stmt
        @oci_execute($stmt);
        @oci_fetch_all($stmt, $result, 0, 30, OCI_FETCHstmt_BY_ROW);

        //clean up;
        @oci_free_stmt($stmt);

        return $result;
    } 


//SELECT... DISPLAY
		// selects the whole ORDERS table
    public function selectFromAdvertises()
    {
        // Define the sql stmt string
		$sql = "SELECT * FROM Ads
				ORDER BY product_name DESC";
		
        // oci_parse prepares the Oracle stmt for execution
        $stmt = @oci_parse($this->conn, $sql);

        // Executes the stmt
        @oci_execute($stmt);
        @oci_fetch_all($stmt, $result, 0, 30, OCI_FETCHstmt_BY_ROW);

        //clean up;
        @oci_free_stmt($stmt);

        return $result;
    } 


//SELECT... DISPLAY
		// selects the whole ORDERS table
    public function selectFromKeyClient()
    {
        // Define the sql stmt string
		$sql = "SELECT * FROM key_clients";
		
        // oci_parse prepares the Oracle stmt for execution
        $stmt = @oci_parse($this->conn, $sql);

        // Executes the stmt
        @oci_execute($stmt);
        @oci_fetch_all($stmt, $result, 0, 30, OCI_FETCHstmt_BY_ROW);

        //clean up;
        @oci_free_stmt($stmt);

        return $result;
    } 


//---------------------------------------------------
//----------- DELETE Functions ----------------------
//---------------------------------------------------


//DELETE - using a Procedure         CLIENT

    // This function uses a SQL procedure to delete a person and returns an errorcode
    public function deleteClient($del_id_client)
    {		
        $errorcode = 0;

        // The SQL string
        $sql = 'BEGIN P_DELETE_CLIENT(:del_id_client, :errorcode); END;'; // that's a stored procedure 
        $stmt = oci_parse($this->conn, $sql);

        //  Bind the parameters
        oci_bind_by_name($stmt, ':del_id_client', $del_id_client);
        oci_bind_by_name($stmt, ':errorcode', $errorcode);

        // Execute stmt
        @oci_execute($stmt);

        //Commit to changes
        @oci_commit($stmt); 

        //Clean Up
        oci_free_stmt($stmt);

        //$errorcode == 1 => success
        //$errorcode != 1 => Oracle SQL related errorcode;
        return $errorcode;
    }



//DELETE - using a Procedure         EMPLOYEE

    // This function uses a SQL procedure to delete a person and returns an errorcode
    public function deleteEmployee($del_id_employee)
    {		
        $errorcode = 0;

        // The SQL string
        $sql = 'BEGIN P_DELETE_EMPLOYEE(:del_id_employee, :errorcode); END;'; 
        $stmt = oci_parse($this->conn, $sql);

        //  Bind the parameters
        oci_bind_by_name($stmt, ':del_id_employee', $del_id_employee);
        oci_bind_by_name($stmt, ':errorcode', $errorcode);

        // Execute stmt
        @oci_execute($stmt);

        //Commit to changes
        @oci_commit($stmt); 

        //Clean Up
        oci_free_stmt($stmt);

        //$errorcode == 1 => success
        //$errorcode != 1 => Oracle SQL related errorcode;
        return $errorcode;
    }


//---------------------------------------------------
//--------------- UPDATE Functions ------------------
//---------------------------------------------------

	
//DELETE - using a Procedure         CLIENT

	public function updateClient($up_id_client, $up_client_name, $up_client_country)
	{
		// Define the sql stmt string
		$sql = 'BEGIN P_UPDATE_CLIENT(:up_id_client, :up_client_name, :up_client_country, :errorcode); END;'; 
        $stmt = @oci_parse($this->conn, $sql);

		//  Bind the parameters
        @oci_bind_by_name($stmt, ':up_id_client', $up_id_client);
        @oci_bind_by_name($stmt, ':up_client_name', $up_client_name);
        @oci_bind_by_name($stmt, ':up_client_country', $up_client_country);
        @oci_bind_by_name($stmt, ':errorcode', $errorcode);
		
		// Execute stmt
        @oci_execute($stmt);
		
		//Commit to changes
        @oci_commit($stmt); 
		
        //Clean Up
        @oci_free_stmt($stmt);
		
        //$errorcode == 1 => success because exactly 1 row affected
        //$errorcode != 1 => Oracle SQL related errorcode 
        return $errorcode;
	}

	
//DELETE - using a Procedure         EMPLOYEE

	public function updateEmployee
		($up_id_employee, $up_firstname, $up_lastname, $up_gender, $up_salary, $up_team_leader)
	{
		// Define the sql stmt string
       
		$sql = 'BEGIN P_UPDATE_EMPLOYEE(:up_id_employee, :up_firstname, :up_lastname, 
				:up_gender, :up_salary, :up_team_leader, :errorcode); END;'; 
        $stmt = @oci_parse($this->conn, $sql);

		//  Bind the parameters
        @oci_bind_by_name($stmt, ':up_id_employee', $up_id_employee);
        @oci_bind_by_name($stmt, ':up_firstname', $up_firstname);
        @oci_bind_by_name($stmt, ':up_lastname', $up_lastname);
        @oci_bind_by_name($stmt, ':up_gender', $up_gender);
        @oci_bind_by_name($stmt, ':up_salary', $up_salary);
        @oci_bind_by_name($stmt, ':up_team_leader', $up_team_leader);
        @oci_bind_by_name($stmt, ':errorcode', $errorcode);
		
		// Execute stmt
        @oci_execute($stmt);
		
		//Commit to changes
        @oci_commit($stmt); 
		
        //Clean Up
        @oci_free_stmt($stmt);
		
        //$errorcode == 1 => success because exactly 1 row affected
        //$errorcode != 1 => Oracle SQL related errorcode 
        return $errorcode;
	}
	
	
		
		
} // end of DatabaseHelper
?>
