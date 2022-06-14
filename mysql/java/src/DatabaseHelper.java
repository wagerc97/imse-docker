//Database Systems (Module IDS)
/**************************************************************
 * This class contains all the funtions to fill my tables.
 * I will access it from a main function in another file.
 * When the DatabaseHelper is called, it...
 * - creates a connection
 * - calls a function for each table to fill it with tuples
 * - closes the connection
 **************************************************************/

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
// CONNECTIVITY
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Date;
// ERROR HANDLING
import java.sql.SQLException;


// The DatabaseHelper class encapsulates the communication with our database
class DatabaseHelper {
    //Source: https://www.vogella.com/tutorials/MySQLJava/article.html#:~:text=To%20connect%20to%20MySQL%20from,file%20which%20we%20require%20later.

    // Database connection info
    private static final String USER = "devuser";
    private static final String PASS = "devpass";
    private static final String DBNAME = "imse_sql_db";
    private static final String LOCALIP = "127.0.0.1"; //localhost

    //const con_string = 'oracle-lab.cs.univie.ac.at:1521/lab';
    //private static final String DB_CONNECTION_URL = "jdbc:mysql://mysql8:8000/imse_sql_db";
  //  private static final String DB_CONNECTION_URL = "jdbc:mysql://localhost:8000/" + DBNAME;
    private static final String DB_CONNECTION_URL = "jdbc:mysql://"+LOCALIP+":8000/"+DBNAME;


    private static final String PATH = "..\\resources\\";

    // The name of the class loaded from the ojdbc14.jar driver file
    //public final String JDBC_DRIVER = "oracle.jdbc.driver.OracleDriver";
    static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";


    // Getter Methods
    public String getDatabase(){return DB_CONNECTION_URL;}
    public String getUser(){return USER;}
    public String getPass(){return PASS;}
    public String getPath(){return PATH;}

    // We need only one Connection and one Statement during the execution => class variable
    private static Statement stmt;
    private static Connection con;

    //CREATE CONNECTION
    //DatabaseHelper() {
    void DatabaseHelperOld() {
        try {
            //Loads the class into the memory
            //Class.forName(JDBC_DRIVER);

            // establish connection to database
            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            stmt = con.createStatement();

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    DatabaseHelper() {
        // https://mkyong.com/jdbc/how-to-connect-to-mysql-with-jdbc-driver-java/
        // Example:
        //conn = DriverManager.getConnection("jdbc:mysql://hostname:port/dbname","username", "password");
        try (Connection conn = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS)) {
            if (conn != null) {
                System.out.println("Connected to the database!");
            } else {
                System.out.println("Failed to make connection!");
            }

        } catch (SQLException e) {
            System.err.format("SQL State: %s\n%s", e.getSQLState(), e.getMessage());
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    // load the RandomHelper class
    RandomHelper rdHelper = new RandomHelper();



    public void close()  {
        try {
            stmt.close(); //clean up
            con.close();
        } catch (Exception ignored) {}
    }


//************************************************************************************************************
//**************************************** INSERT METHODS ****************************************************
//************************************************************************************************************

    // BUFFER variables storing FKs
    // this buffer stores inserted countries for the insertDataClient method
    ArrayList<String> countryBuff = new ArrayList<>();
    // buffer of marketing_emp for the insertDataAdvertises method
    ArrayList<Integer> markBuff = new ArrayList<>();
    // buffer of region_ids for the insertDataGeneral_Managers method
    ArrayList<Integer> regBuff = new ArrayList<>();
    // buffer of region_ids for the insertDataOrders method
    ArrayList<Integer> clientBuff = new ArrayList<>();
    // buffer of products_ids for the insertDataOrders method
    ArrayList<String> prodBuff = new ArrayList<>();

    // insert 6 rows
    public void insertDataRegion(Statement stmt) {
        // print that function was called
        System.out.println("insertDataRegion running ...");

        // grabs file
        File f = new File(PATH + "regions.csv");
        // reads file and stores data in list
        ArrayList<String> set = readFileSingleCol(f);
        // prints data from list
        //printList(set);
        int reg=1;
        for (String elem : set) {
            regBuff.add(reg++);
            try {
                String insertSql =
                        "INSERT INTO REGION (Region_Name) " +
                                "VALUES ('" + elem + "')";

                // executeUpdate Method:
                //   Executes the SQL statement, which can be an INSERT, UPDATE, or DELETE statement
                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataRegion affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Region");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    // insert 21 rows
    public void insertDataCountry(Statement stmt) {
        // print that function was called
        System.out.println("insertDataCountry running ...");

        // grabs file
        File f = new File(PATH + "countries.csv");
        // reads file and stores data in list
        List<String[]> set = readCSV(f, ",");


        for (int i=0; i<set.toArray().length-1; i++) {
            try {
                countryBuff.add(set.get(i)[0]); // adds country strings to the buffer
            } catch (Exception e) {
                System.err.println("Error while adding countries to buffer: " + e.getMessage());
            }
            try {
                String insertSql =
                    "INSERT INTO COUNTRY (COUNTRY_NAME,ID_REGION) " +
                    "VALUES ('" + set.get(i)[0] + "', '" + set.get(i)[1] + "')";

                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataCountry affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Country");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    // insert 100 rows
    public void insertDataClient(Statement stmt) {
        // print that function was called
        System.out.println("insertDataClient running ...");

        int count_id=1;
        // Client_Name + iterator
        // client country is chosen random
        for (int i=0; i < 1000; i++) { // TODO full CLIENT size loop: 1000
            try {
                clientBuff.add(count_id++);
                String insertSql =
                "INSERT INTO Client (Client_Name, Country_Name) VALUES ('exampleClient" + (i+1) + "', '"
                + countryBuff.get(rdHelper.getRandomInteger(0, countryBuff.size() - 1)) + "')";

                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataCountry affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Client");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    // insert 30 rows
    public void insertDataProduct(Statement stmt) {
        // print that function was called
        System.out.println("insertDataProduct running ...");

        // grabs file
        File f = new File(PATH + "product_full.csv");
        // reads file and stores data in list
        List<String[]> set = readCSV(f, ";");

        for (int i=0; i<set.size()-1; i++) {
            try {
                prodBuff.add(set.get(i)[0]); // stores inserted prod_id in list

                String insertSql =
                "INSERT INTO Product (ID_product, Product_Name, Price, Indication) VALUES" +
                "('"+set.get(i)[0]+"' , '"+set.get(i)[1]+"' , '"+set.get(i)[2]+"' , '"+set.get(i)[3]+"')";

                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataProduct affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }

        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Product");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    // insert 22 rows
    public void insertDataCampaign(Statement stmt) {
        // print that function was called
        System.out.println("insertDataCampaign running ...");

        // grabs file
        File f = new File(PATH + "campaigns_full.csv");
        // reads file and stores data in list
        List<String[]> set = readCSV(f, ";");


        // first line is a header
        for (int i=1; i < set.size()-1; i++) {
            try {
                String insertSql =
                    "INSERT INTO Campaign VALUES ( " + // (ID_product, Campaign_Name, Start_date, End_date) VALUES" +
                    "'"+ set.get(i)[0] +"' , '"+ set.get(i)[1] +"' , " +
                    "to_date('"+ set.get(i)[2] +"', 'DD.MM.YYYY') , " +
                    "to_date('"+ set.get(i)[3] +"', 'DD.MM.YYYY') )";

                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataCampaign affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Campaign");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    // insert 1000 rows
    public void insertDataEmployee(Statement stmt) {
        // print that function was called
        System.out.println("insertDataEmployee running ...");

        // grabs file
        File f = new File(PATH + "employees.csv");
        // reads file and stores data in list
        List<String[]> set = readCSV(f, ";");


        // first line is header
        for (int i=1; i < set.size()-1; i++) { // TODO full EMPLOYEE size loop
            try {
                String insertSql =
                    "INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader, Hire_date) VALUES(" +
                    "'"+set.get(i)[0]+"' , '"+set.get(i)[1]+"' , '"+set.get(i)[2]+"' , " +
                    "'"+set.get(i)[3]+"' , '"+set.get(i)[4]+"' , to_date('"+set.get(i)[5]+"','YYYY-MM-DD') )";

                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataEmployee affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Employee");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    // insert 100+ rows
    public void insertDataMarketing_emp(Statement stmt) {
        // print that function was called
        System.out.println("insertDataMarketing_emp running ...");

        // grabs file
        File f = new File(PATH + "Marketing_emp_occupations.csv");
        // reads file and stores data in list
        List<String> set = readFileSingleCol(f);


        // marketing jobs assigned to employees with ID >= 20
        for (int i=0; i < set.size()-1; i++) { // TODO full MARKETING_EMP size loop
            try {
                markBuff.add((i+20));
                String insertSql =
                        "INSERT INTO Marketing_emp (ID_Employee, Occupation) VALUES (" +
                        " '"+(i+20)+"' , '"+ set.get(i) +"')";

                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataMarketing_emp affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Marketing_emp");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    // insert 200+ rows
    public void insertDataAdvertises(Statement stmt) {
        // print that function was called
        System.out.println("insertDataAdvertises running ...");

                // grabs file
                File f = new File(PATH + "advertises.csv");
                // reads file and stores data in list
                List<String[]> set = readCSV(f, ";");

        for (int i=1; i < set.size()-1; i++) { // TODO full ADVERTISES size loop
            try {
                String insertSql =
                    "INSERT INTO Advertises (ID_product, ID_employee) VALUES" +
                    "('"+set.get(i)[0]+"','"+set.get(i)[1]+"')";


                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataAdvertises affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Advertises");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    // insert 5 rows (5, 6, 7, 8, 9)
    public void insertDataGeneral_Manager(Statement stmt) {
        // print that function was called
        System.out.println("insertDataGeneral_Manager running ...");

        // grabs file
        File f = new File(PATH + "general_managers_id.csv");
        // reads file and stores data in list
        List<String> set = readFileSingleCol(f);


        // marketing jobs assigned to employees with ID >= 20
        for (int i=0; i < 5; i++) {
            try {
                String insertSql =
                    "INSERT INTO General_Manager (ID_Employee, ID_region) VALUES (" +
                    " '"+ set.get(i) +"' , '"+ regBuff.get(i) +"')";

                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataGeneral_Manager affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM General_Manager ");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    // insert 1000 rows
    public void insertDataOrders(Statement stmt) {

        // print that function was called
        System.out.println("insertDataOrders running ...");

        // grab and read file, stores data in list;
        File fOrd = new File(PATH + "new_order_dates.csv");
        List<String> setOrd = readFileSingleCol(fOrd);

        for (int i=0; i < setOrd.size()-1; i++) { // TODO full ORDERS size loop
            // random integers to calculate random quantities (min. 10, max. 9900)
            int randHun = rdHelper.getRandomInteger(0, 9);
            int randMil = rdHelper.getRandomInteger(1, 9);
            int randDiv = rdHelper.getRandomInteger(0, 1);

            try {
                String insertSql =
             //       "INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES(" +
                    "INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES(" +
                    "'"+ prodBuff.get(rdHelper.getRandomInteger(0,   prodBuff.size()-1))+"' , " + // range of inserted products
                    "'"+ clientBuff.get(rdHelper.getRandomInteger(0, clientBuff.size()-1))+"' , " + // range of clients
                    "to_date('"+setOrd.get(i)+"' , 'YYYY-MM-DD') , " +
                    "'"+ ((randMil*1000+randHun*100)/(10*randDiv+1-randDiv)) +"')";

                // print finishing output
                int rowsAffected = stmt.executeUpdate(insertSql);
                System.out.println("insertDataOrders affected " + rowsAffected + " row(s).");
            } catch (Exception e) {
                System.err.println("Error while executing INSERT INTO statement: " + e.getMessage());
            }
        }
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Orders");
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Number of datasets: " + count +"\n");
            }
            rs.close();
        } catch (Exception e) {
            System.err.println("Error ResultSet of INSERT INTO statement: " + e.getMessage());
        }
    } // end of function


    //**************************************************************************************************\\
//************************ SMALL HELPER METHODS ***************++*******************************************\\
    //**************************************************************************************************\\

    //reads single-column files and stores its values as Strings in an ArrayList
    // from RandomHelper.java
    public ArrayList<String> readFileSingleCol(File filename) {
    String line;
    ArrayList<String> set = new ArrayList<>();

    try (BufferedReader br = new BufferedReader(new FileReader(filename))) {
        while ((line = br.readLine()) != null) {
            try {
                set.add(line);
            } catch (Exception ignored) {
            }
        }
    } catch (Exception e) {
        e.printStackTrace();
    }
    return set;
}

    // reads a CSV file and returns a list of strings arrays
    public List<String[]> readCSV(File filename, String DELIMITER) {
        List<String[]> content = new ArrayList<>();
        try(BufferedReader br = new BufferedReader(new FileReader(filename))) {
            String line = "";
            while ((line = br.readLine()) != null) {
                //System.out.println(line);
                content.add(line.split(DELIMITER));
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
        return content;
    }


} // end of class