/**********************************************************************************
 *  Adapted version from DBS which used the adapted version from moodle.
 * This is the main function that executes the functions from the DatabaseHelper.
 * Some .csv files were made using https://extendsclass.com/csv-generator.html
**********************************************************************************/

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.Statement;


public class Main { 

  public static void main(String[] args) { 
    try {
      // Instance of Helper
      DatabaseHelper dbHelper = new DatabaseHelper();

      Class.forName(DatabaseHelper.JDBC_DRIVER);

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
      System.err.println(e.toString());
    }
  }
}
