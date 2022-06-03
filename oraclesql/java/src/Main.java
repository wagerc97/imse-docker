/* This is the example java-sql Main from moodle form the wiki
* https://moodle.univie.ac.at/mod/wiki/view.php?pageid=47109
* This is the main function that executes the functions from the DatabaseHelper.
*
* Some .csv files were made using https://extendsclass.com/csv-generator.html
* */

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.Statement;


public class Main { // main class is just a class called main

  public static void main(String[] args) { // THE main method where the program starts
    try {
      // load the the DatabaseHelper
      DatabaseHelper dbHelper = new DatabaseHelper();

      /* CONNECTION in the main is established only via the DatabaseHelper class for security. */

      // Loads the class "oracle.jdbc.driver.OracleDriver" into the memory
      Class.forName(dbHelper.getClassname());

      // Connection details
      String database = dbHelper.getDatabase();
      String user = dbHelper.getUser();
      String pass = dbHelper.getPass();

      // Establish a connection to the database
      Connection con = DriverManager.getConnection(database, user, pass);
      Statement stmt = con.createStatement();

      // Calls functions to fill all tables with test data
      dbHelper.insertDataRegion(stmt);           // max. 10 tuples
      dbHelper.insertDataCountry(stmt);          // max. 100 tuples
      dbHelper.insertDataClient(stmt);           // 1000 tuples
      dbHelper.insertDataProduct(stmt);          // 30 tuples
      dbHelper.insertDataCampaign(stmt);         // max. 100 tuples
      dbHelper.insertDataEmployee(stmt);         // 1000 tuples
      dbHelper.insertDataMarketing_emp(stmt);    // 100 tuples
      dbHelper.insertDataAdvertises(stmt);       // 100 tuples
      dbHelper.insertDataGeneral_Manager(stmt);  // 100 tuples
      dbHelper.insertDataOrders(stmt);           // 1000 tuples

      // Clean up connections
      dbHelper.close();
      stmt.close();
      con.close();
    } catch (Exception e) {
      System.err.println(e);
    }

  } // main method
} // main class
