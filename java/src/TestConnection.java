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
    private static final String PASS = "devpass";
    private static final String PATH = "..\\resources\\";
    private static final String DBNAME = "PharmaComp";

    //const con_string = 'oracle-lab.cs.univie.ac.at:1521/lab';
    //private static final String DB_CONNECTION_URL = "jdbc:mysql://mysql8:8000/PharmaComp";
    private static final String DB_CONNECTION_URL = "jdbc:mysql://localhost:8000/" + DBNAME;
    //"jdbc:mysql://localhost/" + DBNAME + "?user=" + USER + "&password=" + PASS + "&useUnicode=true&characterEncoding=UTF-8"; // 10 years ago, i guess deprecated


    // The name of the class loaded from the ojdbc14.jar driver file
    static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";

    // We need only one Connection and one Statement during the execution => class variable
    private static Statement stmt;
    private static Connection con;


    public static void main(String[] args) {

        System.out.println("Connecting database...");

        try (Connection connection = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS)) {
            System.out.println("Connection successful!");
        } catch (SQLException e) {
            throw new IllegalStateException("Connect to database failed!", e);
        }
    }
    // Getter Methods
    public String getDatabase(){return DB_CONNECTION_URL;}
    public String getUser(){return USER;}
    public String getPass(){return PASS;}
    public String getPath(){return PATH;}

    public void close()  {
        try {
            stmt.close(); //clean up
            con.close();
        } catch (Exception ignored) {}
    }
}
