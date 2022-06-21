package milestone2;


import java.sql.*;
import java.util.ArrayList;

public class SqlDatabaseConnection {


    private static SqlDatabaseConnection instance;
	private static Statement stmt;
    private Connection connection;

    SqlDatabaseConnection() { // Konstruktor
	    try {
	        // establish connection to database
	    	connection = getDatabaseConnection();;
	        stmt = connection.createStatement();
	    } catch (Exception e) {
	        e.printStackTrace();
	    }
    }
    	
    public static synchronized SqlDatabaseConnection getInstance() {
        if (instance == null) return instance = new SqlDatabaseConnection();
        return instance;
    }
    //sql:3306
    private static final String DATABASE_CONNECTION_STRING = "jdbc:mysql://sql:3306/IMSEcinemas";
    private static final String DATABASE_USERNAME = "root";
    private static final String DATABASE_PASSWORD = "password";

    public Connection getDatabaseConnection() {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            if (connection == null) {
                return connection = DriverManager.getConnection(DATABASE_CONNECTION_STRING, DATABASE_USERNAME, DATABASE_PASSWORD);
            } else {
                return connection;
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }

    public boolean isDatabaseEmpty() {
        String statement = "SELECT count(*) AS NumberOfTables FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'imse_sql_db'";
        try {
            Statement st = connection.createStatement();
            var result = st.executeQuery(statement);
            while (result.next()) {
                if (result.getInt("NumberOfTables") > 0) {
                    st.close();
                    return true;
                }
            }
            st.close();
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
        return false;
    }
    


  //---------------------------------------CREATE: -------------------------------------------------------//
      

      public void createTables() {
    	  String disableKeyCheck = "SET FOREIGN_KEY_CHECKS = 0;";
          String deleteCinemaTable = "DROP TABLE IF EXISTS cinema CASCADE;";
      	  String cinemaTable =  "CREATE TABLE cinema" +
                  "(" +
                  "    cname varchar(255)," +
                  "    founding_date date," +
                  "    rewards_program varchar(255)," +
                  "    CONSTRAINT cinema_PK PRIMARY KEY (cname)" +
                  ");";
      	String deleteLocationTable = "DROP TABLE IF EXISTS location_ CASCADE;";
      	String locationTable =  "CREATE TABLE location_" +
                "(" +
                "    street varchar(255)," +
                "    street_number integer," +
                "    postal_code integer," +
                "    city varchar(255)," +
                "    rent decimal(18,2)," +
                "    accessible_ integer," +
                "    cname varchar(255)," +
                "    CONSTRAINT location_PK PRIMARY KEY(street, street_number, postal_code, city)," +
                "    CONSTRAINT location_FK_cinema FOREIGN KEY(cname) REFERENCES cinema(cname) ON DELETE CASCADE," +
                "    CONSTRAINT location_accessible_0_or_1 CHECK (accessible_=0 OR accessible_=1)" +
                ");";
      	String deleteScreeningRoomTable = "DROP TABLE IF EXISTS screening_room CASCADE;";
      	String screeningRoomTable =  "CREATE TABLE screening_room" +
                "(" +
                "    room_number integer," +
                "    number_of_seats integer," +
                "    number_of_wheelchair_spaces integer DEFAULT 2," +
                "    street varchar(255)," +
                "    street_number integer," +
                "    postal_code integer," +
                "    city varchar(255)," +
                "    CONSTRAINT screening_room_PK PRIMARY KEY(street, street_number, postal_code, city, room_number)," +
                "    CONSTRAINT screening_room_FK_location FOREIGN KEY (street, street_number, postal_code, city) REFERENCES location_(street, street_number, postal_code, city) ON DELETE CASCADE" +
                ");";
          String deleteEmployeeTable = "DROP TABLE IF EXISTS employee CASCADE;";
      	  String employeeTable =  "CREATE TABLE employee" +
                  "(" +
                  "    eID integer AUTO_INCREMENT," +
                  "    first_name varchar(255)," +
                  "    last_name varchar(255)," +
                  "    salary decimal(18,2) DEFAULT 2000," +
                  "    cname varchar(255)," +
                  "    friendID integer," +
                  "    CONSTRAINT employee_PK PRIMARY KEY(eID)," +
                  "    CONSTRAINT employee_FK_cinema FOREIGN KEY(cname) REFERENCES cinema(cname) ON DELETE CASCADE," +
                  "    CONSTRAINT employee_FK_employee FOREIGN KEY(friendID) REFERENCES employee(eID) ON DELETE SET NULL" +
                  ");";
          String deleteMovieVTable = "DROP TABLE IF EXISTS moviepass_vendor CASCADE;";
          String movieVTable =  "CREATE TABLE moviepass_vendor" +
                  "(" +
                  "    email_address varchar(255)," +
                  "    phone_number varchar(255)," +
                  "    eID integer," +
                  "    CONSTRAINT moviepass_vendor_PK PRIMARY KEY(eID)," +
  				  "    CONSTRAINT moviepass_vendor_FK_employee FOREIGN KEY(eID) REFERENCES employee(eID) ON DELETE CASCADE," +		
  				  "    CONSTRAINT email_unique_moviepassvendor UNIQUE (email_address)" +
                  ");";
          String deleteMovieTable = "DROP TABLE IF EXISTS movie CASCADE;";
          String movieTable =  "CREATE TABLE movie" +
                  "(" +
                  "    mID integer AUTO_INCREMENT," +
                  "    price decimal(18,2) DEFAULT 10," +
                  "    mname varchar(255) NOT NULL," +
                  "    language_ varchar(255)," +
  				  "    age_rating integer DEFAULT 0," +		
                  "    CONSTRAINT movie_PK PRIMARY KEY(mID)," +
  				  "    CONSTRAINT movie_check_price_positive CHECK (price>=0)," +
  				  "    CONSTRAINT movie_agerating_between_0and21 CHECK (age_rating BETWEEN 0 AND 21)" +
                  ");";
          String deleteCustomerTable = "DROP TABLE IF EXISTS customer CASCADE;";
          String customerTable =  "CREATE TABLE customer" +
                  "(" +
                  "    customerID integer AUTO_INCREMENT," +
                  "    first_name varchar(255)," +
                  "    last_name varchar(255)," +
                  "    date_of_birth date," +
  				  "    CONSTRAINT customer_PK PRIMARY KEY(customerID)" +		
                  ");";
          String deleteTimeslotTable = "DROP TABLE IF EXISTS timeslot CASCADE;";
          String timeslotTable =  "CREATE TABLE timeslot" +
                  "(" +
                  "    timestamp_start timestamp," +
                  "    timestamp_end timestamp," +
                  "    CONSTRAINT timeslot_PK PRIMARY KEY(timestamp_start, timestamp_end)," +
                  "    CONSTRAINT timeslot_positive_intervall CHECK((timestamp_end - timestamp_start)>TIMESTAMP('2019-01-09 15:48:23') - TIMESTAMP('2019-01-09 15:48:23'))" +
                  ");";
          String deletePlaysTable = "DROP TABLE IF EXISTS plays CASCADE;";
          String playsTable =  "CREATE TABLE plays" +
                  "(" +
                  "    room_number integer," +
                  "    street varchar(255)," +
                  "    street_number integer," +
                  "    postal_code integer," +
                  "    city varchar(255)," +
                  "    mID integer," +
                  "    timestamp_start timestamp," +
                  "    timestamp_end timestamp NOT NULL," +
                  "    CONSTRAINT plays_PK PRIMARY KEY (room_number, street, street_number, postal_code, city, timestamp_start)," +
                  "    CONSTRAINT plays_FK_screening_room FOREIGN KEY(street, street_number, postal_code, city, room_number) REFERENCES screening_room(street, street_number, postal_code, city, room_number) ON DELETE CASCADE," +
                  "    CONSTRAINT plays_FK_date FOREIGN KEY(timestamp_start, timestamp_end) REFERENCES timeslot(timestamp_start, timestamp_end) ON DELETE CASCADE," +
                  "    CONSTRAINT plays_FK_movie FOREIGN KEY(mID) REFERENCES movie(mID) ON DELETE SET NULL" +
                  ");";
          String deleteSellsPassToTable = "DROP TABLE IF EXISTS sells_pass_to CASCADE;";
          String sellsPassToTable =  "CREATE TABLE sells_pass_to" +
                  "(" +
                  "    eID integer," +
                  "    customerID integer," +
                  "    mID integer," +
                  "    CONSTRAINT sells_pass_to_PK PRIMARY KEY(customerID, mID)," +
  				  "    CONSTRAINT sells_pass_to_FK_moviepass_vendor FOREIGN KEY(eID) REFERENCES moviepass_vendor(eID) ON DELETE SET NULL," +
                  "    CONSTRAINT sells_pass_to_FK_customer FOREIGN KEY(customerID) REFERENCES customer(customerID) ON DELETE CASCADE," +
  				  "    CONSTRAINT sells_pass_to_FK_movie FOREIGN KEY(mID) REFERENCES movie(mID)" +	
                  ");";
          String deleteProcedureSellsPassTo = "DROP PROCEDURE IF EXISTS P_ADD_SALE;";
          String procedureSellsPassTo = 
          		  "    CREATE PROCEDURE P_ADD_SALE (IN n_eID DOUBLE, IN n_customerID DOUBLE, IN n_mID DOUBLE, OUT errorcode VARCHAR(4000))" +
                  "    BEGIN" +
                  "    DECLARE birthdate DATETIME;" +
                  "    DECLARE agerate DOUBLE;" +
                  "    DECLARE currentdate DATETIME;" +
                  "    DECLARE c_age DOUBLE;" +
                  "    DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN" +
                  "    SET ERRORCODE='default_errorcode';" +
                  "    END;" +
                  "    SELECT date_of_birth INTO birthdate FROM customer WHERE customerID=n_customerID;" +
                  "    SELECT age_rating INTO agerate FROM movie WHERE mID=n_mID;" +
                  "    SELECT NOW() INTO currentdate FROM dual;" +
                  "    SET c_age=YEAR(currentdate) - YEAR( birthdate);" +
                  "    IF (c_age<agerate) THEN" +
                  "    SET ERRORCODE=2;" +
                  "    ELSE" +
                  "    INSERT INTO sells_pass_to (eID, customerID, mID) VALUES (n_eID, n_customerID, n_mID);" +
                  "    SET ERRORCODE=ROW_COUNT();" +
                  "    IF (ERRORCODE=1) THEN" +       
                  "    COMMIT;" +
                  "    ELSE" +
                  "    ROLLBACK;" +
                  "    END IF;" +
                  "    END IF;" +
                  "    END;";
          String enableKeyChecks = "SET FOREIGN_KEY_CHECKS=1;";
          try {
              var stmt = connection.createStatement();
              stmt.execute(disableKeyCheck);
              stmt.executeUpdate(deleteCinemaTable);
              stmt.executeUpdate(cinemaTable);             
              stmt.executeUpdate(deleteLocationTable);
              stmt.executeUpdate(locationTable);
              stmt.executeUpdate(deleteScreeningRoomTable);
              stmt.executeUpdate(screeningRoomTable);
              stmt.executeUpdate(deleteEmployeeTable);
              stmt.executeUpdate(employeeTable); 
              stmt.executeUpdate(deleteMovieVTable);
              stmt.executeUpdate(movieVTable);
              stmt.executeUpdate(deleteCustomerTable);
              stmt.executeUpdate(customerTable); 
              stmt.executeUpdate(deleteMovieTable);
              stmt.executeUpdate(movieTable);
              stmt.executeUpdate(deletePlaysTable);
              stmt.executeUpdate(playsTable);
              stmt.executeUpdate(deleteTimeslotTable);
              stmt.executeUpdate(timeslotTable);
              stmt.executeUpdate(deleteSellsPassToTable);
              stmt.executeUpdate(sellsPassToTable); 
              stmt.executeUpdate(deleteProcedureSellsPassTo);
              stmt.executeUpdate(procedureSellsPassTo);
              stmt.execute(enableKeyChecks);
              stmt.close(); //clean up
          } catch (SQLException throwables) {
              throwables.printStackTrace();
          }
      }
      
//---------------------------------------INSERT: -------------------------------------------------------//

    //insert into cinema:
    void insertIntoCinema(String cname, Date founding_date, String rewards_program) {
    	String statement = "INSERT INTO cinema (cname, founding_date, rewards_program) VALUES (?,?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setString(1, cname);
            prepStatement.setDate(2, founding_date);
            prepStatement.setString(3, rewards_program);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }
    
    //insert into location:
    void insertIntoLocation(String street, int streetnumber, int postalcode, String city, double rent, int accessible, String cname) {
    	String statement = "INSERT INTO location_ (street, street_number, postal_code, city, rent, accessible_, cname) VALUES (?,?,?,?,?,?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setString(1, street);
            prepStatement.setInt(2, streetnumber);
            prepStatement.setInt(3, postalcode);
            prepStatement.setString(4, city);
            prepStatement.setDouble(5, rent);
            prepStatement.setInt(6, accessible);
            prepStatement.setString(7, cname);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }

    //insert into screening_room:
    void insertIntoScreening(int room_number, int number_of_seats, int wheelchair_spaces, String street, int streetnumber, int postalcode, String city) {
    	String statement = "INSERT INTO screening_room (room_number, number_of_seats, number_of_wheelchair_spaces, street, street_number, postal_code, city) VALUES (?,?,?,?,?,?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setInt(1, room_number);
            prepStatement.setInt(2, number_of_seats);
            prepStatement.setInt(3, wheelchair_spaces);
            prepStatement.setString(4, street);
            prepStatement.setInt(5, streetnumber);
            prepStatement.setInt(6, postalcode);
            prepStatement.setString(7, city);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }


    //insert into employee:
    void insertIntoEmployee(String firstname, String lastname, double salary, String cname, int friendID) {
    	String statement = "INSERT INTO employee (first_name, last_name, salary, cname, friendID) VALUES (?,?,?,?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setString(1, firstname);
            prepStatement.setString(2, lastname);
            prepStatement.setDouble(3, salary);
            prepStatement.setString(4, cname);
            prepStatement.setInt(5, friendID);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }
    
    //without friendID:
    void insertIntoEmployeeNofriends(String firstname, String lastname, double salary, String cname) {
    	String statement = "INSERT INTO employee (first_name, last_name, salary, cname) VALUES (?,?,?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setString(1, firstname);
            prepStatement.setString(2, lastname);
            prepStatement.setDouble(3, salary);
            prepStatement.setString(4, cname);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }
    
    //insert into moviepass vendor:
    void insertIntoMovieV(String email, String phone_number, int eid) {
    	String statement = "INSERT INTO moviepass_vendor (email_address, phone_number, eID) VALUES (?,?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setString(1, email);
            prepStatement.setString(2, phone_number);
            prepStatement.setInt(3, eid);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }

    //insert into customer:
    void insertIntoCustomer(String firstname, String lastname, Date birthdate) {
    	String statement = "INSERT INTO customer (first_name, last_name, date_of_birth) VALUES (?,?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setString(1, firstname);
            prepStatement.setString(2, lastname);
            prepStatement.setDate(3, birthdate);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }

    
    //insert into movie:
    void insertIntoMovie(double price, String name, String language, int age_rating) {
    	String statement = "INSERT INTO movie (price, mname, language_, age_rating) VALUES (?,?,?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setDouble(1, price);
            prepStatement.setString(2, name);
            prepStatement.setString(3, language);
            prepStatement.setInt(4, age_rating);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }

    //insert into plays:
    void insertIntoPlays(int room_number, String street, int streetnumber, int postalcode, String city, int mID, Timestamp starttime, Timestamp endtime) {
    	String statement = "INSERT INTO plays (room_number, street, street_number, postal_code, city, mID, timestamp_start, timestamp_end) VALUES (?,?,?,?,?,?,?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setInt(1, room_number);
            prepStatement.setString(2, street);
            prepStatement.setInt(3, streetnumber);
            prepStatement.setInt(4, postalcode);
            prepStatement.setString(5, city);
            prepStatement.setInt(6, mID);
            prepStatement.setTimestamp(7, starttime);
            prepStatement.setTimestamp(8, endtime);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }
    
    //insert into Timeslot:
    void insertIntoTimeslot(Timestamp starttime, Timestamp endtime) {
    	String statement = "INSERT INTO timeslot (timestamp_start, timestamp_end) VALUES (?,?)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setTimestamp(1, starttime);
            prepStatement.setTimestamp(2, endtime);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }

    //insert into sells_pass_to:
    void insertIntoSellsPassTo(int eid, int customerID, int mID) {
    	String statement = "CALL P_ADD_SALE(?,?,?,@errorcode)";
        try {
            PreparedStatement prepStatement = connection.prepareStatement(statement);
            prepStatement.setInt(1, eid);
            prepStatement.setInt(2, customerID);
            prepStatement.setInt(3, mID);
            prepStatement.executeUpdate();
            prepStatement.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }
    
    //insert into sells_pass_to:
    //void insertIntoSellsPassTo(int eid, int customerID, int mID) {
    //	String statement = "INSERT INTO sells_pass_to (eID, customerID, mID) VALUES (?,?,?)";
    //    try {
    //        PreparedStatement prepStatement = connection.prepareStatement(statement);
    //        prepStatement.setInt(1, eid);
    //        prepStatement.setInt(2, customerID);
    //        prepStatement.setInt(3, mID);
    //        prepStatement.executeUpdate();
    //        prepStatement.close();
    //    } catch (Exception ex) {
    //        ex.printStackTrace();
    //    }
    //}

    

//---------------------------------------SELECT: -------------------------------------------------------//
    
    //select cnames from cinema to use as foreign keys:
    ArrayList<String> selectCnamesFromCinema() {
    	ArrayList<String> allCnames=new ArrayList<>();
    	try {
    		ResultSet rs = stmt.executeQuery("SELECT cname FROM cinema");
    		while (rs.next()) {
    			allCnames.add(rs.getString("cname"));
    		}
    		rs.close();
    	} catch (Exception e) {
            System.err.println(("Error at: selectCnamesFromCinema\n message: " + e.getMessage()).trim());
    	}
        return allCnames;
    }
    
    //select eIDs from employee to use as foreign keys:
    ArrayList<Integer> selectEIDsFromEmployee() {
    	ArrayList<Integer> allEids=new ArrayList<>();
    	try {
    		ResultSet rs = stmt.executeQuery("SELECT eID FROM employee");
    		while (rs.next()) {
    			allEids.add(rs.getInt("eID"));
    		}
    		rs.close();
    	} catch (Exception e) {
            System.err.println(("Error at: selectEIDsFromEmployee\n message: " + e.getMessage()).trim());
    	}
    	System.out.println("The length of the array allEids is: "+ allEids);  
        return allEids;
    }

    
    //select all MIDs:
    ArrayList<Integer> selectMIDs() {
    	ArrayList<Integer> mIDs=new ArrayList<>();
    	try {
    		ResultSet rs = stmt.executeQuery("SELECT mID FROM movie");
    		while (rs.next()) {
    			mIDs.add(rs.getInt("mID"));
    		}
    		rs.close();
    	} catch (Exception e) {
            System.err.println(("Error at: selectMIDs\n message: " + e.getMessage()).trim());
    	}
        return mIDs;
    }
    
    //select all employees that are moviepass vendors:
    ArrayList<Integer> selectMovieVEids() {
    	ArrayList<Integer> movieVEids=new ArrayList<>();
    	try {
    		ResultSet rs = stmt.executeQuery("SELECT eID FROM moviepass_vendor");
    		while (rs.next()) {
    			movieVEids.add(rs.getInt("eID"));
    		}
    		rs.close();
    	} catch (Exception e) {
            System.err.println(("Error at: selectMovieVEids\n message: " + e.getMessage()).trim());
    	}
        return movieVEids;
    }
    
    
    //select all customerIDs:
    ArrayList<Integer> selectCustomerIDs() {
    	ArrayList<Integer> customerIDs=new ArrayList<>();
    	try {
    		ResultSet rs = stmt.executeQuery("SELECT customerID FROM customer");
    		while (rs.next()) {
    			customerIDs.add(rs.getInt("customerID"));
    		}
    		rs.close();
    	} catch (Exception e) {
            System.err.println(("Error at: selectCustomerIDs\n message: " + e.getMessage()).trim());
    	}
        return customerIDs;
    }
    
  //select addresses from location to use as foreign keys:
    ArrayList<ArrayList<String>> selectAddressesFromLocation() {
    	ArrayList<ArrayList<String>> allAddresses=new ArrayList<>();
//    	allAddresses.add(new ArrayList<String>());
    	ArrayList<String> streetrow=new ArrayList<>();
    	ArrayList<String> streetnumrow=new ArrayList<>();
    	ArrayList<String> postalrow=new ArrayList<>();
    	ArrayList<String> cityrow=new ArrayList<>();
    	try {
    		ResultSet rs = stmt.executeQuery("SELECT street, street_number, postal_code, city FROM location_");
    		while (rs.next()) {
    			streetrow.add(rs.getString("street"));
    			streetnumrow.add(String.valueOf(rs.getInt("street_number")));
    			postalrow.add(String.valueOf(rs.getInt("postal_code")));
    			cityrow.add(rs.getString("city"));
    		}
    		allAddresses.add(streetrow);
    		allAddresses.add(streetnumrow);
    		allAddresses.add(postalrow);
    		allAddresses.add(cityrow);
    		rs.close();
    	} catch (Exception e) {
            System.err.println(("Error at: selectAddressesFromLocation\n message: " + e.getMessage()).trim());
    	}
        return allAddresses;
    }
    
  //select timeslots:
    ArrayList<ArrayList<Timestamp>> selectTimestampsFromTimeslot() {
    	ArrayList<ArrayList<Timestamp>> allTimes=new ArrayList<>();
    	ArrayList<Timestamp> startrow=new ArrayList<>();
    	ArrayList<Timestamp> endrow=new ArrayList<>();
    	try {
    		ResultSet rs = stmt.executeQuery("SELECT timestamp_start, timestamp_end FROM timeslot");
    		while (rs.next()) {
    			startrow.add(rs.getTimestamp("timestamp_start"));
    			endrow.add(rs.getTimestamp("timestamp_end"));
    		}
    		allTimes.add(startrow);
    		allTimes.add(endrow);
    		rs.close();
    	} catch (Exception e) {
            System.err.println(("Error at: selectTimestampsFromTimeslot\n message: " + e.getMessage()).trim());
    	}
        return allTimes;
    }
    
    
    
    
    //select screening rooms from screening_room to use as foreign keys:
    ArrayList<ArrayList<String>> selectKeyFromScreening() {
    	ArrayList<ArrayList<String>> allRooms=new ArrayList<>();
//    	allAddresses.add(new ArrayList<String>());
    	ArrayList<String> streetrow=new ArrayList<>();
    	ArrayList<String> streetnumrow=new ArrayList<>();
    	ArrayList<String> postalrow=new ArrayList<>();
    	ArrayList<String> cityrow=new ArrayList<>();
    	ArrayList<String> roomrow=new ArrayList<>();
    	try {
    		ResultSet rs = stmt.executeQuery("SELECT room_number, street, street_number, postal_code, city FROM screening_room");
    		while (rs.next()) {
    			streetrow.add(rs.getString("street"));
    			streetnumrow.add(String.valueOf(rs.getInt("street_number")));
    			postalrow.add(String.valueOf(rs.getInt("postal_code")));
    			cityrow.add(rs.getString("city"));
    			roomrow.add(String.valueOf(rs.getInt("room_number")));
    		}
    		allRooms.add(streetrow);
    		allRooms.add(streetnumrow);
    		allRooms.add(postalrow);
    		allRooms.add(cityrow);
    		allRooms.add(roomrow);
    		rs.close();
    	} catch (Exception e) {
            System.err.println(("Error at: selectKeyFromScreening\n message: " + e.getMessage()).trim());
    	}
        return allRooms;
    }
    
}


