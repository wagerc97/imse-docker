// CONNECTIVITY
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;


public class TestConnection {

    // Database connection info
    private static final String USER = "devuser";
    private static final String USERROOT = "root";
    private static final String PASS = "devpass";
    private static final String PASSROOT = "imse4eva";
    private static final String PATH = "..\\resources\\";
    private static final String LOCALIP = "127.0.0.1"; //localhost
    private static final String DBPORT = "3306";
    private static final String DBNAME = "PharmaComp";

    //const con_string = 'oracle-lab.cs.univie.ac.at:1521/lab';
    private static final String DB_CONNECTION_URL = "jdbc:mysql://"+LOCALIP+":"+DBPORT+"/"+DBNAME;
  //  private static final String DB_CONNECTION_URL = "jdbc:mysql://127.0.0.1:3306/PharmaComp";
  //  private static final String DB_CONNECTION_URL = "jdbc:mysql://localhost:3306/PharmaComp";


    // The name of the class loaded from the ojdbc14.jar driver file
    static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";

    // We need only one Connection and one Statement during the execution => class variable
    private static Statement stmt;
    private static Connection connection;


    public static void main(String[] args) {

        System.out.println("[INFO] Connecting to database ...");

        try (Connection connection = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS)) {
            System.out.println("\n[SUCCESS] Connection successful!");
        } catch (SQLException e) {
            throw new IllegalStateException("\n[FAIL] Cannot connect to database!", e);
        }
    }
    // Getter Methods
    public String getDatabase(){return DB_CONNECTION_URL;}
    public String getUser(){return USER;}
    public String getUserRoot(){return USERROOT;}
    public String getPass(){return PASS;}
    public String getPassRoot(){return PASSROOT;}
    public String getPath(){return PATH;}

    public void close()  {
        try {
            stmt.close(); //clean up
            connection.close();
        } catch (Exception ignored) {}
    }
}
