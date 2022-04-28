<!------------------------------------------------------------------------------------------------------------
	DatabaseHelper.php
	PROJECT: Pharmacompany
	AUTHOR: Clemens Wager, a01635477
	COURSE: VU Database Systems 2021S
	PURPOSE of this file:
		- implementation of website functionality 
		- DBS connection 
		- DBS manipulation (CRUD)

-------------------------------------------------------------------------------------------------------------> 

<?php

class DatabaseHelper
{
//------------------------------------------------------------------------------------------------------------
//----------------------------------- CONNECTION -------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------
//CONNECT

    // Since the connection details are constant, define them as const
    // We can refer to constants like e.g. DatabaseHelper::username
		
		// to connect to oracle database + oracle username + oracle PW
    const username 	= 'a01635477'; // use a + your matriculation number  
    const password 	= 'tiger650'; // use your oracle db password
    const con_string = 'oracle-lab.cs.univie.ac.at:1521/lab';  //on almighty "lab" is sufficient

    // Since we need only one connection object, it can be stored in a member variable.
    // $conn is set in the constructor.
    protected $conn;

    // Create connection in the constructor
    public function __construct()
    {
        try {
            // Create connection with the command oci_connect(String(username), String(password), String(connection_string))
            // The @ sign avoids the output of warnings (supresses warnings)
            // It could be helpful to use the function without the @ symbol during developing process
            $this->conn = @oci_connect(
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::con_string
            );

            //check if the connection object is != null
            if (!$this->conn) {
                // die(String(message)): stop PHP script and output message:
                die("DB error: Connection can't be established!");
            }

        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    // Used to clean up
    public function __destruct()
    {
        // clean up
        @oci_close($this->conn);
    }
	

//--------------------------------------------------------------------------------------------------------
//----------------------------------- INSERT Functions ---------------------------------------------------
//--------------------------------------------------------------------------------------------------------

	
//INSERT	CLIENT
	// adds a new row to the CLIENT table 
    public function addClient($client_client_name, $client_country_name)
	{
        $sql = "INSERT INTO Client (client_name, country_name) 
				VALUES ('{$client_client_name}', '{$client_country_name}')";
		
        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }
	

//INSERT	PRODUCT
	// adds a new row to the PRODUCT table (ID_product(4), Name_product, Price, Indication)
    public function addProduct($id_product, $product_name, $price, $indication)
	{
        $sql = "INSERT INTO Product (ID_product, Product_Name, Price, Indication) 
				VALUES ('{$id_product}', '{$product_name}', '{$price}', '{$indication}')";
		
        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
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
					
        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }
	


//--------------------------------------------------------------------------------------------------------
//----------------------------------- SELECT Functions ---------------------------------------------------
//--------------------------------------------------------------------------------------------------------
	
	
//SELECT... SEARCH
    // This function creates and executes a SQL select statement and returns an array as the result
    // 2-dimensional array: the result array contains nested arrays (each contains the data of a single row)
    public function selectFromEmployeeWhere($id_employee, $firstname, $lastname, $team_leader)
    {
        // Define the sql statement string
        // Notice that the parameters $id_employee, $firstname, $lastname in the 'WHERE' clause
          $sql = "SELECT * FROM Employee
            WHERE id_employee 	LIKE '%{$id_employee}%'
              AND firstname		LIKE '%{$firstname}%'
              AND lastname		LIKE '%{$lastname}%'
			  AND team_leader 	LIKE '%{$team_leader}%'

            ORDER BY ID_Employee ASC";  
			
        // oci_parse(...) prepares the Oracle statement for execution
        // notice the reference to the class variable $this->conn (set in the constructor)
        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);

        @oci_fetch_all(
			$statement,		// sql statement
			$res_array,		// store result here
			0, 				// rows skip
			30, 				// max rows in result 
			OCI_FETCHSTATEMENT_BY_ROW		// format flag  
		);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 
	
//SELECT... DISPLAY
	// selects the whole region table
    public function selectFromRegion()
    {
        // Define the sql statement string
      /*   $sql = "SELECT ID_Region, Region_Name FROM Region
			ORDER BY ID_Region ASC";   */
		$sql =  "SELECT * FROM countpreg";
	
        // oci_parse prepares the Oracle statement for execution
        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);
        @oci_fetch_all($statement, $res_array, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 
	
//SELECT... DISPLAY
	// selects the whole region table
    public function selectFromCountry()//$country_country_name, $country_client_name)
    {
        // Define the sql statement string
		$sql =  "SELECT * FROM clientpcount";

        // oci_parse prepares the Oracle statement for execution
        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);
        @oci_fetch_all($statement, $res_array, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 

//SELECT... SEARCH
		// selects the whole region table
    public function selectFromClient ($id_client, $client_client_name, $client_country_name)
    {
        // Define the sql statement string
        $sql = "SELECT * FROM CLIENT 
				WHERE id_client 	LIKE '%{$id_client}%' 
				AND client_name		LIKE '%{$client_client_name}%' 
				AND country_name 	LIKE '%{$client_country_name}%' 
				ORDER BY id_client ASC";   	
		
        // oci_parse prepares the Oracle statement for execution
        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);
        @oci_fetch_all($statement, $res_array, 0, 30, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 
	
//SELECT... DISPLAY
	// selects the whole PRODUCT table
    public function selectFromProduct()//$sel_id_product, $sel_product_name, $sel_price, $sel_indication)
    {
        // Define the sql statement string
        // just select all colums
		$sql= "SELECT * FROM product 
			   ORDER BY PRODUCT_NAME";
		
		
        // oci_parse prepares the Oracle statement for execution
        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);
        @oci_fetch_all($statement, $res_array, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 
	
//SELECT... DISPLAY
	// selects the whole CAMPAIGN table
    public function selectFromCampaign()
    {
        // Define the sql statement string
        // just select all colums
		$sql= "SELECT * FROM camps
				ORDER BY START_DATE";			
		
        // oci_parse prepares the Oracle statement for execution
        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);
        @oci_fetch_all($statement, $res_array, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 
	
	
//SELECT... DISPLAY
	// selects the whole MARKETING EMPLOYEES table
    public function selectFromMarkEmp($markemp_date)
    {
        // Define the sql statement string
        // just select all colums
		$sql = "SELECT m.ID_Employee, e.Lastname, Occupation, e.hire_date
				FROM Employee e
					INNER JOIN MARKETING_EMP m
						ON e.ID_Employee = m.ID_Employee
				WHERE e.hire_date > to_date('{$markemp_date}','YYYY-MM-DD')
				ORDER BY e.hire_date ASC";		
		
        // oci_parse prepares the Oracle statement for execution
        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);
        @oci_fetch_all($statement, $res_array, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 


//SELECT... DISPLAY
		// selects the whole ORDERS table
    public function selectFromOrders()
    {
        // Define the sql statement string 
		
		$sql1 = "SELECT * FROM ord_rev
				 ORDER BY order_date DESC";
		
        // oci_parse prepares the Oracle statement for execution
        $statement = @oci_parse($this->conn, $sql1);

        // Executes the statement
        @oci_execute($statement);
        @oci_fetch_all($statement, $res_array, 0, 30, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 


//SELECT... DISPLAY
		// selects the whole ORDERS table
    public function selectFromAdvertises()
    {
        // Define the sql statement string
		$sql = "SELECT * FROM Ads
				ORDER BY product_name DESC";
		
        // oci_parse prepares the Oracle statement for execution
        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);
        @oci_fetch_all($statement, $res_array, 0, 30, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 


//SELECT... DISPLAY
		// selects the whole ORDERS table
    public function selectFromKeyClient()
    {
        // Define the sql statement string
		$sql = "SELECT * FROM key_clients";
		
        // oci_parse prepares the Oracle statement for execution
        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);
        @oci_fetch_all($statement, $res_array, 0, 30, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res_array;
    } 


//--------------------------------------------------------------------------------------------------------
//----------------------------------- DELETE Functions ---------------------------------------------------
//--------------------------------------------------------------------------------------------------------

//DELETE - using a Procedure         CLIENT

    // This function uses a SQL procedure to delete a person and returns an errorcode
    public function deleteClient($del_id_client)
    {		
        $errorcode = 0;

        // The SQL string
        $sql = 'BEGIN P_DELETE_CLIENT(:del_id_client, :errorcode); END;'; // that's a stored procedure 
        $statement = oci_parse($this->conn, $sql);

        //  Bind the parameters
        oci_bind_by_name($statement, ':del_id_client', $del_id_client);
        oci_bind_by_name($statement, ':errorcode', $errorcode);

        // Execute Statement
        @oci_execute($statement);

        //Commit to changes
        @oci_commit($statement); 

        //Clean Up
        oci_free_statement($statement);

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
        $statement = oci_parse($this->conn, $sql);

        //  Bind the parameters
        oci_bind_by_name($statement, ':del_id_employee', $del_id_employee);
        oci_bind_by_name($statement, ':errorcode', $errorcode);

        // Execute Statement
        @oci_execute($statement);

        //Commit to changes
        @oci_commit($statement); 

        //Clean Up
        oci_free_statement($statement);

        //$errorcode == 1 => success
        //$errorcode != 1 => Oracle SQL related errorcode;
        return $errorcode;
    }


//--------------------------------------------------------------------------------------------------------
//----------------------------------- UPDATE Functions ---------------------------------------------------
//--------------------------------------------------------------------------------------------------------
	
//DELETE - using a Procedure         CLIENT

	public function updateClient($up_id_client, $up_client_name, $up_client_country)
	{
		// Define the sql statement string
		$sql = 'BEGIN P_UPDATE_CLIENT(:up_id_client, :up_client_name, :up_client_country, :errorcode); END;'; 
        $statement = @oci_parse($this->conn, $sql);

		//  Bind the parameters
        @oci_bind_by_name($statement, ':up_id_client', $up_id_client);
        @oci_bind_by_name($statement, ':up_client_name', $up_client_name);
        @oci_bind_by_name($statement, ':up_client_country', $up_client_country);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);
		
		// Execute Statement
        @oci_execute($statement);
		
		//Commit to changes
        @oci_commit($statement); 
		
        //Clean Up
        @oci_free_statement($statement);
		
        //$errorcode == 1 => success because exactly 1 row affected
        //$errorcode != 1 => Oracle SQL related errorcode 
        return $errorcode;
	}

	
//DELETE - using a Procedure         EMPLOYEE

	public function updateEmployee
		($up_id_employee, $up_firstname, $up_lastname, $up_gender, $up_salary, $up_team_leader)
	{
		// Define the sql statement string
       
		$sql = 'BEGIN P_UPDATE_EMPLOYEE(:up_id_employee, :up_firstname, :up_lastname, 
				:up_gender, :up_salary, :up_team_leader, :errorcode); END;'; 
        $statement = @oci_parse($this->conn, $sql);

		//  Bind the parameters
        @oci_bind_by_name($statement, ':up_id_employee', $up_id_employee);
        @oci_bind_by_name($statement, ':up_firstname', $up_firstname);
        @oci_bind_by_name($statement, ':up_lastname', $up_lastname);
        @oci_bind_by_name($statement, ':up_gender', $up_gender);
        @oci_bind_by_name($statement, ':up_salary', $up_salary);
        @oci_bind_by_name($statement, ':up_team_leader', $up_team_leader);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);
		
		// Execute Statement
        @oci_execute($statement);
		
		//Commit to changes
        @oci_commit($statement); 
		
        //Clean Up
        @oci_free_statement($statement);
		
        //$errorcode == 1 => success because exactly 1 row affected
        //$errorcode != 1 => Oracle SQL related errorcode 
        return $errorcode;
	}

} // end of DatabaseHelper Class
// Webaddress: http://wwwlab.cs.univie.ac.at/~wagerc97/index.php 
?>