/**********************************************************************************************
 *  This Class shall test the connection to mysql service running on the same docker container
 **********************************************************************************************/


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
    private static final String DBNAME = "PharmaComp";
    private static final String LOCALIP = "127.0.0.1"; //localhost

    //const con_string = 'oracle-lab.cs.univie.ac.at:1521/lab';
    //private static final String DB_CONNECTION_URL = "jdbc:mysql://mysql8:8000/PharmaComp";
    private static final String DB_CONNECTION_URL = "jdbc:mysql://"+LOCALIP+":8000/"+DBNAME;
    //"jdbc:mysql://localhost/" + DBNAME + "?user=" + USER + "&password=" + PASS + "&useUnicode=true&characterEncoding=UTF-8"; // 10 years ago, i guess deprecated


    // The name of the class loaded from the ojdbc14.jar driver file
    static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";

    // We need only one Connection and one Statement during the execution => class variable
    private static Statement stmt;
    private static Connection con;


    public static void main(String[] args) {

        System.out.println("[INFO] Connecting to database (with root access) ...");

        try (Connection con = DriverManager.getConnection(DB_CONNECTION_URL, USERROOT, PASSROOT)) {
            System.out.println("\n[SUCCESS] Connection successful!");
        } catch (SQLException e) {
            throw new IllegalStateException("\n[FAIL] Connect to database failed!", e);
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
            con.close();
        } catch (Exception ignored) {}
    }
}
