package milestone2;
import java.sql.Date;
import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.concurrent.ThreadLocalRandom;

public class TestdataGenerator {
	public static void main(String[] args) {
        System.out.println("DBFilling started! waiting for Database to startup");
        try {
            Thread.sleep(100000); //wait for 100 seconds to make sure that sql/mongo containers are running 
            					// and connection can be established/data can be inserted
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
		SqlDatabaseConnection dbHelper=new SqlDatabaseConnection();
		RandomHelper rh=new RandomHelper();	
        dbHelper.createTables();

		int cinemaAmount=50;
		int locationAmount=50;
		int screeningAmount=50;
		int employeeAmount=50;
		int moviepassvendorAmount=50;
		int customerAmount=50;
		int movieAmount=50;
		int timeslotAmount=50;
		int playsAmount=50;
		int sellsPassAmount=50;
	
		//insert into cinema:
		for (int i = 0; i<cinemaAmount && i <rh.cnames.size(); ++i) {
//			System.out.println(i + InputCnames.get(i));
			dbHelper.insertIntoCinema(rh.cnames.get(i), Date.valueOf(rh.getRandomStringFrom(rh.foundingdates)),rh.getRandomStringFrom(rh.rewardsprograms) + rh.getRandomStringFrom(rh.rewardsprograms2));
		}
		
		//insert into location_:
		//Foreign Key generation for Location:
		ArrayList<String> ActiveCnames=dbHelper.selectCnamesFromCinema();//get a list of all cnames in the table cinema, to use as foreign keys
		//cnames are the primary key, therefore cannot be null, therefore i do not have to check if the value was null.
		for (int i=0; i<locationAmount;++i) {
			dbHelper.insertIntoLocation(rh.getRandomStringFrom(rh.streets), rh.getRandomInteger(1,100), rh.getRandomInteger(100,10000), rh.getRandomStringFrom(rh.cities), rh.getRandomDouble(50, 9999, 2), rh.getRandomInteger(0, 1), rh.getRandomStringFrom(ActiveCnames));
		}
		
		//insert into screening_room:
		//get all addresses from location to use as foreign keys:
		ArrayList<ArrayList<String>> ActiveAddresses=dbHelper.selectAddressesFromLocation();//Get all streets, streetnumbers, postalcodes, cities in an array
		//ActiveAddresses.get(attribut).get(Zeile)
		//all the values are are selected are part of the primary key, therefore cannot be null.
		for (int i=0; i<screeningAmount;++i) {
			int j=rh.getRandomInteger(0,ActiveAddresses.get(0).size()-1);
			dbHelper.insertIntoScreening(rh.getRandomInteger(1, 99), rh.getRandomInteger(10,500), rh.getRandomInteger(0, 5), ActiveAddresses.get(0).get(j),  Integer.parseInt(ActiveAddresses.get(1).get(j)), Integer.parseInt(ActiveAddresses.get(2).get(j)), ActiveAddresses.get(3).get(j));
		}
		
		//insert into employee:
		ArrayList<Integer> ActiveEIDs=dbHelper.selectEIDsFromEmployee();//get a list of all eIDs in the table employee, to use as foreign keys
		if (ActiveEIDs.isEmpty()) {//insert half of the employees without friends, if no employees are inserted yet
			for (int i=0; i<employeeAmount/2;++i) {
				dbHelper.insertIntoEmployeeNofriends(rh.getRandomStringFrom(rh.firstnames), rh.getRandomStringFrom(rh.lastnames), rh.getRandomDouble(1900, 9999, 2), rh.getRandomStringFrom(ActiveCnames));
			}
			ActiveEIDs=dbHelper.selectEIDsFromEmployee();//get a list of all eIDs in the table employee, to use as foreign keys
			for (int i=employeeAmount/2; i<employeeAmount;++i) {
				dbHelper.insertIntoEmployee(rh.getRandomStringFrom(rh.firstnames), rh.getRandomStringFrom(rh.lastnames), rh.getRandomDouble(1900, 9999, 2), rh.getRandomStringFrom(ActiveCnames), ActiveEIDs.get(rh.getRandomInteger(0,ActiveEIDs.size()-1)));
			}
		}
		else {
			for (int i=0; i<employeeAmount;++i) {
				dbHelper.insertIntoEmployee(rh.getRandomStringFrom(rh.firstnames), rh.getRandomStringFrom(rh.lastnames), rh.getRandomDouble(1900, 9999, 2), rh.getRandomStringFrom(ActiveCnames), ActiveEIDs.get(rh.getRandomInteger(0,ActiveEIDs.size()-1)));
			}
		}
		
		
		//insert into moviepass vendor:
		ActiveEIDs=dbHelper.selectEIDsFromEmployee();//get a list of all eIDs in the table employee, to use as foreign keys
		for (int i=0; i<moviepassvendorAmount && i< ActiveEIDs.size();++i) {
			int n1 = ThreadLocalRandom.current().nextInt(111, 999);
            int n2 = ThreadLocalRandom.current().nextInt(111, 999);
            int n3 = ThreadLocalRandom.current().nextInt(111, 999);
            int n4 = ThreadLocalRandom.current().nextInt(111, 999);
			dbHelper.insertIntoMovieV(rh.getRandomStringFrom(rh.email1) + "@" + rh.getRandomStringFrom(rh.email2), n1 + "-" + n2 + "-" + n3 + "-" + n4, ActiveEIDs.get(rh.getRandomInteger(0,ActiveEIDs.size()-1)));
		}
		
		//insert into customer:
		for (int i=0; i<customerAmount;++i) {
			dbHelper.insertIntoCustomer(rh.getRandomStringFrom(rh.firstnames), rh.getRandomStringFrom(rh.lastnames), Date.valueOf(rh.getRandomStringFrom(rh.foundingdates)));
		}
		
		//insert into movie:
		for (int i=0; i<movieAmount;++i) {
			dbHelper.insertIntoMovie(rh.getRandomDouble(10.0,100.0, 2), rh.getRandomStringFrom(rh.movie1) + " " + rh.getRandomStringFrom(rh.movie2) + " " + rh.getRandomStringFrom(rh.movie3) + " " + rh.getRandomStringFrom(rh.movie4) + " " + rh.getRandomStringFrom(rh.movie5), rh.getRandomStringFrom(rh.languages), rh.getRandomInteger(0,18));
		}
		
		ArrayList<Integer> activeMIDs=dbHelper.selectMIDs();
		
		//insert into timeslot:
		for (int i=0; i<timeslotAmount;++i) {
			int j=rh.getRandomInteger(0,rh.times.size()-1);
			int k=rh.getRandomInteger(0,rh.foundingdates.size()-1);
//			System.out.println("\nk = " + k + ", j = " + j);
//			System.out.println("start: " + rh.foundingdates.get(k) + " " + rh.times.get(j) + "\nend: " + rh.foundingdates.get(k) + " " + rh.times2.get(j));
			dbHelper.insertIntoTimeslot(Timestamp.valueOf(rh.foundingdates.get(k) + " " + rh.times.get(j)), Timestamp.valueOf(rh.foundingdates.get(k) + " " + rh.times2.get(j)));
		}
		
		//insert into plays:
		//need to use address from screening room, mID from movie, and timestamps from timeslot:
		ArrayList<ArrayList<java.sql.Timestamp>> activeTimes=dbHelper.selectTimestampsFromTimeslot();
		ArrayList<ArrayList<String>> activeRooms=dbHelper.selectKeyFromScreening();//Get all room numbers, streets, streetnumbers, postalcodes, cities in an array
		//activeScreens.get(attribut).get(Zeile)
		for (int i=0; i<playsAmount;++i) {
			int j=rh.getRandomInteger(0,activeRooms.get(0).size()-1);
			int k=rh.getRandomInteger(0,activeTimes.get(0).size()-1);
			dbHelper.insertIntoPlays(Integer.parseInt(activeRooms.get(4).get(j)), activeRooms.get(0).get(j), Integer.parseInt(activeRooms.get(1).get(j)), Integer.parseInt(activeRooms.get(2).get(j)), activeRooms.get(3).get(j), activeMIDs.get(rh.getRandomInteger(0, activeMIDs.size()-1)), activeTimes.get(0).get(k), activeTimes.get(1).get(k));
		}
		
		//insert into sells_pass_to:
		//need to use Eids from moviepass vendors, and customerIDs from customer. I already have the movieIDs from plays.
		ArrayList<Integer> activeMovieVEIDs=dbHelper.selectMovieVEids();
		ArrayList<Integer> activeCustomerIDs=dbHelper.selectCustomerIDs();
		for (int i=0; i<sellsPassAmount;++i) {
			dbHelper.insertIntoSellsPassTo(activeMovieVEIDs.get(rh.getRandomInteger(0,activeMovieVEIDs.size()-1)), activeCustomerIDs.get(rh.getRandomInteger(0,activeCustomerIDs.size()-1)), activeMIDs.get(rh.getRandomInteger(0, activeMIDs.size()-1)));
		}
	
	    System.out.println("Inserting into MongoDB");
	    
	    new MongoDatabaseConnection();

	}

}