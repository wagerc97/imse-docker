package dump1; /**********************************************************************************
 *  Adapted version from DBS which used the adapted version from moodle.
 * This is the main function that executes the functions from the DatabaseHelper.
 * Some .csv files were made using https://extendsclass.com/csv-generator.html
**********************************************************************************/

import dump1.TestConnection;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.Statement;


public class Main { // main class is just a class called main

  public static void main(String[] args) { // THE main method where the program starts
    try {
      // load the the DatabaseHelper
      //DatabaseHelper dbHelper = new DatabaseHelper();
      TestConnection testConn = new TestConnection();

      /* CONNECTION in the main is established only via the DatabaseHelper class for security. */

      // Loads the class "oracle.jdbc.driver.OracleDriver" into the memory
      //Class.forName(DatabaseHelper.JDBC_DRIVER);
      Class.forName(TestConnection.JDBC_DRIVER);

      // Connection details
      //String database = dbHelper.getDatabase();
      //String user = dbHelper.getUser();
      //String pass = dbHelper.getPass();

      // Connection details for Test
      String testDatabase = testConn.getDatabase();
      String testUser = testConn.getUser();
      String testPass = testConn.getPass();

      // Establish a connection to the database
      //Connection con = DriverManager.getConnection(database, user, pass); //non test
      Connection con = DriverManager.getConnection(testDatabase, testUser, testPass);
      Statement stmt = con.createStatement();

      /*
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
      */

      // Clean up connections
      //dbHelper.close();
      testConn.close();
      stmt.close();
      con.close();
    } catch (Exception e) {
      System.err.println(e.toString());
    }

  } // main method
} // main class
