package milestone2;
import java.io.BufferedReader;
import java.io.FileReader;
import java.util.ArrayList;
import java.util.Random;


public class RandomHelper {
	  private final char[] alphabet = getCharSet();
	  private Random rand;
	  ArrayList<String> foundingdates;
	  ArrayList<String> rewardsprograms;
	  ArrayList<String> rewardsprograms2;
	  ArrayList<String> cnames;
	  ArrayList<String> streets;
	  ArrayList<String> cities;
	  ArrayList<String> firstnames;
	  ArrayList<String> lastnames;
	  ArrayList<String> email1;
	  ArrayList<String> email2;
	  ArrayList<String> snacks1;
	  ArrayList<String> snacks2;
	  ArrayList<String> movie1;
	  ArrayList<String> movie2;
	  ArrayList<String> movie3;
	  ArrayList<String> movie4;
	  ArrayList<String> movie5;
	  ArrayList<String> languages;
	  ArrayList<String> times;
	  ArrayList<String> times2;
	  private static final String dateFile = "./resources/foundingdates.csv";
	  private static final String rewardFile = "./resources/rewardsprograms.csv";
	  private static final String reward2File = "./resources/rewardsprograms2.csv";
	  private static final String cnamesFile = "./resources/cnames.csv";
	  private static final String streetFile = "./resources/streets.csv";
	  private static final String cityFile = "./resources/cities.csv";
	  private static final String fnameFile = "./resources/firstnames.csv";
	  private static final String lnameFile = "./resources/lastnames.csv";
	  private static final String email1File = "./resources/email_starts.csv";
	  private static final String email2File = "./resources/email_endings.csv";
	  private static final String snacks1File = "./resources/snack_prefixes.csv";
	  private static final String snacks2File = "./resources/snacks.csv";
	  private static final String movie1File = "./resources/movie1.csv";
	  private static final String movie2File = "./resources/movie2.csv";
	  private static final String movie3File = "./resources/movie3.csv";
	  private static final String movie4File = "./resources/movie4.csv";
	  private static final String movie5File = "./resources/movie5.csv";
	  private static final String languageFile = "./resources/languages.csv";
	  private static final String timesFile = "./resources/times.csv";
	  private static final String times2File = "./resources/timeends.csv";




	  //instantiate the Random object and store data from files in lists
	  RandomHelper() {
	      this.rand = new Random();
	      this.rewardsprograms = readFile(rewardFile);
	      this.rewardsprograms2 = readFile(reward2File);
	      this.foundingdates = readFile(dateFile);
//	      this.courses = readFile(coursesFile);
	      this.cnames = readFile(cnamesFile);
	      this.streets = readFile(streetFile);
	      this.cities = readFile(cityFile);
	      this.firstnames = readFile(fnameFile);
	      this.lastnames = readFile(lnameFile);
	      this.email1 = readFile(email1File);
	      this.email2 = readFile(email2File);
	      this.snacks1 = readFile(snacks1File);
	      this.snacks2 = readFile(snacks2File);
	      this.movie1 = readFile(movie1File);
	      this.movie2 = readFile(movie2File);
	      this.movie3 = readFile(movie3File);
	      this.movie4 = readFile(movie4File);
	      this.movie5 = readFile(movie5File);
	      this.languages = readFile(languageFile);
	      this.times = readFile(timesFile);
	      this.times2 = readFile(times2File);
	  }

	  //not used but it might be helpful
	  String getRandomString(int minLen, int maxLen) {
	      StringBuilder out = new StringBuilder();
	      int len = rand.nextInt((maxLen - minLen) + 1) + minLen;
	      while (out.length() < len) {
	          int idx = Math.abs((rand.nextInt() % alphabet.length));
	          out.append(alphabet[idx]);
	      }
	      return out.toString();
	  }

	  //returns random element from list
	  String getRandomDate() {
	      return foundingdates.get(getRandomInteger(0, foundingdates.size() - 1));
	  }
	  
	  String getRandomCname() {
	      return cnames.get(getRandomInteger(0, cnames.size() - 1));
	  }
	  
	  String getRandomStringFrom(ArrayList<String> valuelist) {//So I don't have to create a function for every single String attribute
		  return valuelist.get(getRandomInteger(0, valuelist.size() - 1));
	  }
	/*
	  //returns random element from list
	  String getRandomLastName() {
	      return lastNames.get(getRandomInteger(0, lastNames.size() - 1));
	  }


	  //returns random element from list
	  String getRandomCourse() {
	      return courses.get(getRandomInteger(0, courses.size() - 1));
	  }
	*/

	  //returns random double from the Interval [min, max] and a defined precision (e.g. precision:2 => 3.14)
	  Double getRandomDouble(double min, double max, int precision) {
	      //Hack that is not the cleanest way to ensure a specific precision, but...
	      double r = Math.pow(10, precision);
	      return Math.round(min + (rand.nextDouble() * (max - min)) * r) / r;
	  }

	  //return random Integer from the Interval [min, max]; (min, max are possible as well)
	  Integer getRandomInteger(int min, int max) {
	      return rand.nextInt((max - min) + 1) + min;
	  }
	  

	  //reads single-column files and stores its values as Strings in an ArraList
	  private ArrayList<String> readFile(String filename) {
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

	  //defines which chars are used to create random strings
	  private char[] getCharSet() { // create getCharSet char array
	      StringBuffer b = new StringBuffer(128);
	      for (int i = 48; i <= 57; i++) b.append((char) i);        // 0-9
	      for (int i = 65; i <= 90; i++) b.append((char) i);        // A-Z
	      for (int i = 97; i <= 122; i++) b.append((char) i);       // a-z
	      return b.toString().toCharArray();
	  }
}
