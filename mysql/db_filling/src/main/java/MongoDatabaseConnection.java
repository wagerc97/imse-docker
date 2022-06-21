package milestone2;
import com.mongodb.client.MongoClient;
import com.mongodb.client.MongoClients;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;


import org.bson.types.ObjectId;

import java.util.ArrayList;
import java.util.List;

import org.bson.Document;
import static java.util.Arrays.asList;

import java.sql.Date;
import java.time.Instant;
import java.time.format.DateTimeFormatter;
import java.time.temporal.TemporalAccessor;


public class MongoDatabaseConnection {

    private final MongoCollection<Document> cinemaCollection;
    private final MongoCollection<Document> customerCollection;
    private final MongoCollection<Document> employeeCollection;
	private final MongoCollection<Document> locationCollection;
	private final MongoCollection<Document> movieCollection;
	//private final MongoCollection<Document> playsCollection;

    public MongoDatabaseConnection() {
        //MongoClient mongoClient = MongoClients.create("mongodb://localhost:27017");
    	MongoClient mongoClient = MongoClients.create("mongodb://user:password@mongo:27017");
        MongoDatabase mongoDb = mongoClient.getDatabase("IMSEcinemas");
        cinemaCollection = mongoDb.getCollection("cinema");
        locationCollection = mongoDb.getCollection("location_");
        employeeCollection = mongoDb.getCollection("employee");
		customerCollection = mongoDb.getCollection("customer");
		movieCollection = mongoDb.getCollection("movie");
		//playsCollection = mongoDb.getCollection("plays");
		cinemaCollection.drop();		
		locationCollection.drop();
		employeeCollection.drop();
		customerCollection.drop();
		movieCollection.drop();
		//playsCollection.drop();
		System.out.println("Connected to mongoDB and created cinema, location_, employee, customer, movie and plays - Collections");
		
		Document movie1 = new Document("_id", new ObjectId("61e32d9163dd4d07c248f4e7"));
	    movie1.append("mname", "City of Death");
	    movie1.append("price", 30.98);
	    movie1.append("age_rating", 8);
	    movie1.append("language_", "english");
	    ArrayList<String> c1_list = new ArrayList<String>();
	    c1_list.add("Moviemento");
	    c1_list.add("City Kino");
	    c1_list.add("Cineplex");
	    movie1.append("cname", c1_list);
	      
	    Document movie2 = new Document("_id", new ObjectId("61e32d9163dd4d07c248f4e8"));
	    movie2.append("mname", "Die Welle");
	    movie2.append("price", 20.15);
	    movie2.append("age_rating", 9);
	    movie2.append("language_", "german");
	    ArrayList<String> c2_list = new ArrayList<String>();
	    c2_list.add("City Kino");
	    c2_list.add("HaydnCinema");
	    movie2.append("cname", c2_list);
	      
	    Document movie3 = new Document("_id", new ObjectId("61e32d9163dd4d07c248f4e9"));
	    movie3.append("mname", "Butterfly Effect");
	    movie3.append("price", 35.20);
	    movie3.append("age_rating", 16);
	    movie3.append("language_", "english");
	    ArrayList<String> c3_list = new ArrayList<String>();
	    c3_list.add("City Kino");
	    movie2.append("cname", c3_list);
	    
	    Document movie4 = new Document("_id", new ObjectId("61e32d9163dd4d07c248f4ea"));
	    movie4.append("mname", "Fight Club");
	    movie4.append("price", 17.99);
	    movie4.append("age_rating", 18);
	    movie4.append("language_", "italian");
	    ArrayList<String> c4_list = new ArrayList<String>();
	    c4_list.add("Cineplex");
	    movie4.append("cname", c4_list);
	    
	    List<Document> movieList = new ArrayList<Document>();
	    movieList.add(movie1);
	    movieList.add(movie2);
	    movieList.add(movie3);
	    movieList.add(movie4);

	    movieCollection.insertMany(movieList);
	    System.out.println("Movies successfully inserted");

	    
	    Document employee1 = new Document("_id", new ObjectId("61e344d384a7737e8235d98a"));
	    employee1.append("salary", 10.05);
	    employee1.append("name", new Document("first_name", "Emil").append("last_name", "Kaiser"));
	    employee1.append("works_for", "Moviemento");
	    employee1.append("email_address", "emil.kaiser@gmail.com");
	    employee1.append("phone_number", "2342341");
	    
	    String e2 = "1990-11-14T00:00:00.000Z";
	    TemporalAccessor tae2 = DateTimeFormatter.ISO_INSTANT.parse(e2);
	    Instant ie2 = Instant.from(tae2);
	    java.util.Date de2 = Date.from(ie2);
	    
	    Document employee2 = new Document("_id", new ObjectId("61e344d384a7737e8235d98b"));
	    employee2.append("salary", 11.34);
	    employee2.append("name", new Document("first_name", "Joyce").append("last_name", "Messier"));
	    employee2.append("works_for", "Moviemento");
	    employee2.append("is_friend_of", new ObjectId("61e344d384a7737e8235d98a"));
	    employee2.append("uniform_size", 41);
	    employee2.append("date_of_birth", de2);

	    String e3 = "1990-11-10T00:00:00.000Z";
	    TemporalAccessor tae3 = DateTimeFormatter.ISO_INSTANT.parse(e3);
	    Instant ie3 = Instant.from(tae3);
	    java.util.Date de3 = Date.from(ie3);
	    
	    Document employee3 = new Document("_id", new ObjectId("61e344d384a7737e8235d98c"));
	    employee3.append("salary", 12.34);
	    employee3.append("name", new Document("first_name", "Snack").append("last_name", "McSnackson"));
	    employee3.append("works_for", "City Kino");
	    employee3.append("is_friend_of", new ObjectId("61e344d384a7737e8235d98a"));
	    employee3.append("uniform_size", 4);	    
	    employee3.append("date_of_birth", de3);
	    List<Document> snack_types = asList((new Document("barcode", "123456789012").append("sname", "popcorn")).append("price", 3.99), (new Document("barcode", "234567890123").append("sname", "Nachos")).append("price", 4.50));
	    employee3.append("snack_type", snack_types);
	    
	    Document employee4 = new Document("_id", new ObjectId("61e344d384a7737e8235d98d"));
	    employee4.append("salary", 13.05);
	    employee4.append("name", new Document("first_name", "Bettina").append("last_name", "Houston"));
	    employee4.append("works_for", "City Kino");
	    employee4.append("email_address", "bettina.houston@gmail.com");
	    employee4.append("phone_number", "2678852");
	    
	    Document employee5 = new Document("_id", new ObjectId("61e699742559744a0bc26d25"));
	    employee5.append("salary", 12.05);
	    employee5.append("name", new Document("first_name", "Samantha").append("last_name", "Burgers"));
	    employee5.append("works_for", "Moviemento");
	    employee5.append("email_address", "samantha.burgers@gmail.com");
	    employee5.append("phone_number", "2349123");
	    
	    Document employee6 = new Document("_id", new ObjectId("61e699742559744a0bc26d26"));
	    employee6.append("salary", 14.50);
	    employee6.append("name", new Document("first_name", "Thomas").append("last_name", "Phillips"));
	    employee6.append("works_for", "MovieMove");
	    employee6.append("email_address", "thomas.phillips@gmail.com");
	    employee6.append("phone_number", "4992851");
	    
	    Document employee7 = new Document("_id", new ObjectId("61e699742559744a0bc26d27"));
	    employee7.append("salary", 11.99);
	    employee7.append("name", new Document("first_name", "Louis").append("last_name", "Manners"));
	    employee7.append("works_for", "Cineplex");
	    employee7.append("email_address", "louis.manners@gmail.com");
	    employee7.append("phone_number", "1763928");
	   
	    List<Document> employeeList = new ArrayList<Document>();
	    employeeList.add(employee1);
	    employeeList.add(employee2);
	    employeeList.add(employee3);
	    employeeList.add(employee4);
	    employeeList.add(employee5);
	    employeeList.add(employee6);
	    employeeList.add(employee7);

	    employeeCollection.insertMany(employeeList);
	    System.out.println("Employees successfully inserted");
	    
	    String c1 = "1991-11-14T00:00:00.000Z";
	    TemporalAccessor tac1 = DateTimeFormatter.ISO_INSTANT.parse(c1);
	    Instant ic1 = Instant.from(tac1);
	    java.util.Date dc1 = Date.from(ic1);
	    
	    Document customer1 = new Document("_id", new ObjectId("61e344d384a7737e8235d98e"));
     	customer1.append("name", new Document("first_name", "Custard").append("last_name", "Custovic"));
	    customer1.append("date_of_birth", dc1);
	    List<Document> pass_sales_1 = asList(new Document("mID", new ObjectId("61e32d9163dd4d07c248f4e7")).append("eID", new ObjectId("61e344d384a7737e8235d98a")), new Document("mID", new ObjectId("61e32d9163dd4d07c248f4e8")).append("eID", new ObjectId("61e344d384a7737e8235d98a")));
	    customer1.append("pass_sale", pass_sales_1);
	    
	    String c2 = "2012-01-08T00:00:00.000Z";
	    TemporalAccessor tac2 = DateTimeFormatter.ISO_INSTANT.parse(c2);
	    Instant ic2 = Instant.from(tac2);
	    java.util.Date dc2 = Date.from(ic2);
	    
	    Document customer2 = new Document("_id", new ObjectId("61e344d384a7737e8235d98f"));
     	customer2.append("name", new Document("first_name", "Maria").append("last_name", "Lamberto"));
	    customer2.append("date_of_birth", dc2);
	    List<Document> pass_sales_2 = asList(new Document("mID", new ObjectId("61e32d9163dd4d07c248f4e7")).append("eID", new ObjectId("61e344d384a7737e8235d98a")), new Document("mID", new ObjectId("61e32d9163dd4d07c248f4e8")).append("eID", new ObjectId("61e344d384a7737e8235d98d")));
	    customer2.append("pass_sale", pass_sales_2);
	    
	    String c3 = "2004-01-20T00:00:00.000Z";
	    TemporalAccessor tac3 = DateTimeFormatter.ISO_INSTANT.parse(c3);
	    Instant ic3 = Instant.from(tac3);
	    java.util.Date dc3 = Date.from(ic3);
	    
	    Document customer3 = new Document("_id", new ObjectId("61e344d384a7737e8235d99a"));
     	customer3.append("name", new Document("first_name", "Virgilio").append("last_name", "Horrera"));
	    customer3.append("date_of_birth", dc3);
	    List<Document> pass_sales_3 = asList(new Document("mID", new ObjectId("61e32d9163dd4d07c248f4e7")).append("eID", new ObjectId("61e344d384a7737e8235d98a")));
	    customer3.append("pass_sale", pass_sales_3);

	    String c4 = "2012-01-20T00:00:00.000Z";
	    TemporalAccessor tac4 = DateTimeFormatter.ISO_INSTANT.parse(c4);
	    Instant ic4 = Instant.from(tac4);
	    java.util.Date dc4 = Date.from(ic4);
	    
	    Document customer4 = new Document("_id", new ObjectId("61e344d384a7737e8235d99b"));
     	customer4.append("name", new Document("first_name", "Amelie").append("last_name", "Richardson"));
	    customer4.append("date_of_birth", dc4);
	    List<Document> pass_sales_4 = asList(new Document("mID", new ObjectId("61e32d9163dd4d07c248f4e7")).append("eID", new ObjectId("61e344d384a7737e8235d98d")));
	    customer4.append("pass_sale", pass_sales_4);
	    
	    String c5 = "1992-01-20T00:00:00.000Z";
	    TemporalAccessor tac5 = DateTimeFormatter.ISO_INSTANT.parse(c5);
	    Instant ic5 = Instant.from(tac5);
	    java.util.Date dc5 = Date.from(ic5);
	    
	    Document customer5 = new Document("_id", new ObjectId("61e344d384a7737e8235d99c"));
     	customer5.append("name", new Document("first_name", "Sandra").append("last_name", "McKendry"));
	    customer5.append("date_of_birth", dc5);
	    List<Document> pass_sales_5 = asList(new Document("mID", new ObjectId("61e32d9163dd4d07c248f4ea")).append("eID", new ObjectId("61e699742559744a0bc26d26")), new Document("mID", new ObjectId("61e32d9163dd4d07c248f4e9")).append("eID", new ObjectId("61e699742559744a0bc26d26")));
	    customer5.append("pass_sale", pass_sales_5);
	    
	    String c6 = "2012-02-15T00:00:00.000Z";
	    TemporalAccessor tac6 = DateTimeFormatter.ISO_INSTANT.parse(c6);
	    Instant ic6 = Instant.from(tac6);
	    java.util.Date dc6 = Date.from(ic6);
	    
	    Document customer6 = new Document("_id", new ObjectId("61e344d384a7737e8235d99d"));
     	customer6.append("name", new Document("first_name", "David").append("last_name", "Bumstead"));
	    customer6.append("date_of_birth", dc6);
	    List<Document> pass_sales_6 = asList(new Document("mID", new ObjectId("61e32d9163dd4d07c248f4e7")).append("eID", new ObjectId("61e699742559744a0bc26d25")));
	    customer6.append("pass_sale", pass_sales_6);


	    List<Document> customerList = new ArrayList<Document>();
	    customerList.add(customer1);
	    customerList.add(customer2);
	    customerList.add(customer3);
	    customerList.add(customer4);
	    customerList.add(customer5);
	    customerList.add(customer6);

	    customerCollection.insertMany(customerList);
	    System.out.println("Customers successfully inserted");
	    
	    String ci1 = "2014-01-01T00:00:00.000Z";
	    TemporalAccessor taci1 = DateTimeFormatter.ISO_INSTANT.parse(ci1);
	    Instant ici1 = Instant.from(taci1);
	    java.util.Date dci1 = Date.from(ici1);
	    
	    Document cinema1 = new Document("_id", new ObjectId("61e419dc31927b369558bb2b"));
	    cinema1.append("cname", "Cineplex");
	    cinema1.append("founding_date", dci1);
	    cinema1.append("rewards_program", "C points");
	    
	    String ci2 = "1981-09-21T00:00:00.000Z";
	    TemporalAccessor taci2= DateTimeFormatter.ISO_INSTANT.parse(ci2);
	    Instant ici2 = Instant.from(taci2);
	    java.util.Date dci2 = Date.from(ici2);
	    
	    Document cinema2 = new Document("_id", new ObjectId("61e419dc31927b369558bb2c"));
	    cinema2.append("cname", "Moviemento");
	    cinema2.append("founding_date", dci2);
	    cinema2.append("rewards_program", "MovieBonus");
	    
	    String ci3 = "1988-11-09T00:00:00.000Z";
	    TemporalAccessor taci3= DateTimeFormatter.ISO_INSTANT.parse(ci3);
	    Instant ici3 = Instant.from(taci3);
	    java.util.Date dci3 = Date.from(ici3);
	    
	    Document cinema3 = new Document("_id", new ObjectId("61e419dc31927b369558bb2d"));
	    cinema3.append("cname", "City Kino");
	    cinema3.append("founding_date", dci3);
	    cinema3.append("rewards_program", "MovieBonus");
	    
	    String ci4 = "1998-05-09T00:00:00.000Z";
	    TemporalAccessor taci4 = DateTimeFormatter.ISO_INSTANT.parse(ci4);
	    Instant ici4 = Instant.from(taci4);
	    java.util.Date dci4 = Date.from(ici4);
	    
	    Document cinema4 = new Document("_id", new ObjectId("61e419dc31927b369558bb2e"));
	    cinema4.append("cname", "MovieMove");
	    cinema4.append("founding_date", dci4);
	    cinema4.append("rewards_program", "MovieBonus");
	    
	    String ci5 = "2005-06-06T00:00:00.000Z";
	    TemporalAccessor taci5 = DateTimeFormatter.ISO_INSTANT.parse(ci5);
	    Instant ici5 = Instant.from(taci5);
	    java.util.Date dci5 = Date.from(ici5);
	    
	    Document cinema5 = new Document("_id", new ObjectId("61e419dc31927b369558bb2f"));
	    cinema5.append("cname", "HaydnCinema");
	    cinema5.append("founding_date", dci5);
	    cinema5.append("rewards_program", "MovieBonus");
	    
	    List<Document> cinemaList = new ArrayList<Document>();
	    cinemaList.add(cinema1);
	    cinemaList.add(cinema2);
	    cinemaList.add(cinema3);
	    cinemaList.add(cinema4);
	    cinemaList.add(cinema5);
	    
	    cinemaCollection.insertMany(cinemaList);
	    System.out.println("Cinemas successfully inserted");
	    
	    Document location1 = new Document("_id", new ObjectId("61e420dc0768760f9fb8108f"));
	    location1.append("accessible", 1);
	    location1.append("address", ((new Document("street", "John Street").append("street_number", 4)).append("city", "London")).append("postal_code", 1563));
	    location1.append("cname", "Cineplex");
	    location1.append("rent", 1252.56);
	    List<Document> screening_room1 = asList((new Document("number_of_wheelchair_spaces", 1).append("number_of_seats", 11)).append("room_number", 1), (new Document("number_of_wheelchair_spaces", 2).append("number_of_seats", 22)).append("room_number", 2));
	    location1.append("screening_room", screening_room1);
	    
	    Document location2 = new Document("_id", new ObjectId("61e420dc0768760f9fb81090"));
	    location2.append("accessible", 0);
	    location2.append("address", ((new Document("street", "Square Street").append("street_number", 12)).append("city", "Bratislava")).append("postal_code", 5793));
	    location2.append("cname", "Moviemento");
	    location2.append("rent", 1379.11);
	    List<Document> screening_room2 = asList((new Document("number_of_wheelchair_spaces", 3).append("number_of_seats", 33)).append("room_number", 3), (new Document("number_of_wheelchair_spaces", 4).append("number_of_seats", 44)).append("room_number", 4));
	    location2.append("screening_room", screening_room2);
	    
	    List<Document> locationList = new ArrayList<Document>();
	    locationList.add(location1);
	    locationList.add(location2);


	    locationCollection.insertMany(locationList);
	    System.out.println("Locations successfully inserted");
	    
	  /*  String ps1 = "2022-01-21T16:30:00.000Z";
	    TemporalAccessor taps1 = DateTimeFormatter.ISO_INSTANT.parse(ps1);
	    Instant ips1 = Instant.from(taps1);
	    java.util.Date dps1 = Date.from(ips1);
	    
	    String pe1 = "2022-01-21T18:00:00.000Z";
	    TemporalAccessor tape1 = DateTimeFormatter.ISO_INSTANT.parse(pe1);
	    Instant ipe1 = Instant.from(tape1);
	    java.util.Date dpe1 = Date.from(ipe1);
	    
	    Document plays1 = new Document("_id", new ObjectId("61e423c600f459699e2ea563"));
	    plays1.append("timestamp_start", dps1);
	    plays1.append("timestamp_end", dpe1);
	    plays1.append("mID", new ObjectId("61e32d9163dd4d07c248f4e7"));
	    List<Document> screening_room_p1 = asList(new Document("location_id", new ObjectId("61e420dc0768760f9fb8108f")).append("room_number", 1));
	    plays1.append("screening_room", screening_room_p1);
	    
	    playsCollection.insertOne(plays1);
	    System.out.println("Plays successfully inserted");*/
    }
    
}
