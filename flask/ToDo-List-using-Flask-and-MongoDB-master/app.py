from flask import Flask
from flask import render_template, request, redirect, url_for
from markupsafe import Markup # For flask implementation
from pymongo import MongoClient # Database connector
from bson.objectid import ObjectId # For ObjectId to work
from bson.errors import InvalidId # For catching InvalidId exception for ObjectId
import os
import mysql.connector as connector
from mysql.connector import Error #NEW
import datetime
#import nosqlWriter 
from decouple import config #NEW
from jinja2.utils import markupsafe  #NEW
markupsafe.Markup() #NEW
Markup('') #NEW

import logging # NEW
logging.basicConfig(level=logging.INFO) #NEW

# ------------------#

migrate = False
if migrate: 
	print("[INFO] The data will be migrated.")
else: 
	print("[INFO] The data will not be migrated. MongoDB already setup?")
# ------------------#

# -------------------- Connect Mongo------------------
attempt=0; retry = 3; again=True
while attempt < retry and again: 
	attempt +=1
	try: 
		clientDB = MongoClient(config('MDB_CONNECTION_STRING', ''),  #https://pymongo.readthedocs.io/en/stable/examples/tls.html
				maxPoolSize=50,
				unicode_decode_error_handler='ignore'
		)

	except Error as e:
		print("[ERROR] Could not connect to NoSQL DB. ", end="")
		if attempt <= retry: 
			print("Try again to connect to NoSQL DB.")
	else: 
		again = False
		print("[INFO] Connection to NoSQL DB successful.")



db = clientDB.camp2016    #Select the database
todos = db.todo #Select the collection

dbDrug = clientDB.MedStore   #Select the database
order = dbDrug.order #Select the collection


# ------------------flask ------------------------------


app = Flask(__name__)
title = "TODO with Flask"
heading = "ToDo Reminder"
#modify=ObjectId()



if migrate: 

	# -------------------------------------------------------
	# -------------------connect mysql-----------------------
	# -------------------------------------------------------


	attempt=0; retry = 3; again=True
	while attempt < retry and again: 
		attempt +=1
		try: 
			sql11Server=config('SQL_SERVER')
			sql11Name=config('SQL_DB')
			sql11Username=config('SQL_USER')
			sql11Password=config('SQL_PASS')
			sql11Port=config('SQL_PORT')

			connSQL = connector.connect( user=sql11Username, password=sql11Password, host=sql11Server, database=sql11Name, port=sql11Port )
		except Error as e:
			print("[ERROR] Could not connect to SQL DB.", end=" ")
			if attempt <= retry: 
				print("Try again to connect to SQL DB.")
		else: 
			again = False
			print("[INFO] Connection to SQL DB successful.")


	cursorSQL = connSQL.cursor(buffered=True)


	# -----------------------------------------------------------
	# ------------------------ NoSQL ----------------------------
	# -----------------------------------------------------------

	#Write data into NOSQL
	clientCollection=dbDrug['Client']
	regionCollection=dbDrug['Region']
	orderCollection=dbDrug['Order']
	productCollection=dbDrug['Product']
	employeeCollection=dbDrug['Employee']


	# -------------------- Delete NoSQL Tables ------------------------

	#Delet everythin in collection
	clientCollection.delete_many({})
	regionCollection.delete_many({})
	orderCollection.delete_many({})
	productCollection.delete_many({})
	employeeCollection.delete_many({})
	print("[INFO] All collections deleted")



	try: 
		# ----------------------------------------------------------------- 
		# -------------------- Create NoSQL Tables ------------------------
  	# ----------------------------------------------------------------- 


		def creatDate(date):
			res = datetime.datetime.strptime(str(date), "%Y-%m-%d")
			return res





		# ------------ PRODUCT ------------------

		def creatCampain(campain):
			return {"name":str(campain[0]), "StartDate":creatDate(campain[1]), "EndDate":creatDate(campain[2])}


		def inserProduct(name, price, campains, indications, marketingEmps , dbDrug):
			collection = dbDrug['Product']

			campainsInsert = []
			for eachCampain in campains:
				campainsInsert.append(creatCampain(eachCampain))


			indicationsInser = []
			for eachIndication in indications:
				indicationsInser.append(eachIndication)

			marketingEmpInser = []
			for eachmarketingEmp in marketingEmps:
				marketingEmpInser.append({"Name": eachmarketingEmp[0], "Occupation": eachmarketingEmp[1]})


			doc = { "$set":{ "name": name, "price": int(price), "Campains": campainsInsert, "indications": indications, "Marketing_Emp": marketingEmpInser }}
			filter = { 'name': name }
			collection.update_one(filter, doc,  True)

			



		cursorSQL.execute(
		"""
		SELECT * FROM Product
		"""
		)
		
		allProducts = cursorSQL.fetchall()
		countPoduct = 0
		for eachProduct in allProducts:
			name = eachProduct[1]
			price = eachProduct[2]
			indications = eachProduct[3]

			campains = []
			cursorSQL.execute(
			"""
			SELECT * FROM Campaign
			WHERE ID_Product="""+ str(eachProduct[0])
			)
			allCampains = cursorSQL.fetchall()
			for eachCampain in allCampains:
				campains.append([eachCampain[1], eachCampain[2], eachCampain[3]])


			cursorSQL.execute(
			"""
			SELECT * FROM sql11501710.Product JOIN sql11501710.Advertises
			ON sql11501710.Product.ID_product=sql11501710.Advertises.ID_product
			JOIN sql11501710.Employee
			ON sql11501710.Employee.ID_employee=sql11501710.Advertises.ID_employee
			JOIN sql11501710.Marketing_emp
			ON sql11501710.Employee.ID_employee=sql11501710.Marketing_emp.ID_employee
			WHERE sql11501710.Product.ID_product="""+ str(eachProduct[0])
			)
			
			allmarketingEmp = cursorSQL.fetchall()
			marketingEmps= []
			for eachmarketingEmp in allmarketingEmp:
				marketingEmps.append([eachmarketingEmp[7]+" "+ eachmarketingEmp[8], eachmarketingEmp[14] ])


			inserProduct(name, price, campains, indications, marketingEmps , dbDrug)
			countPoduct += 1

		print(f"[INFO] {countPoduct} new Products inserted to DB")



			
		# ---------------------- Employee -------------------------

		def insertEmployee(name, gender, salery, teamLeader, hirDate):
			collection = dbDrug['Employee']
			doc = { "$set":{"Name": name, "Gender": gender, "Salary": int(salery), "Team_Leader": teamLeader, "Hir_Date": creatDate(hirDate)}}
			filter = { 'Name': name }
			collection.update_one(filter, doc,  True)


		cursorSQL.execute(
		"""
		SELECT * FROM Employee
		"""
		)
		allEmployees = cursorSQL.fetchall()
		employeeCount = 0
		for eachEmployee in allEmployees:
			name = eachEmployee[1] + " " +eachEmployee[2]
			gender = eachEmployee[3]
			salery = int(eachEmployee[4])
			teamLeader = eachEmployee[5]
			hirDate = eachEmployee[6]
			insertEmployee(name, gender, salery, teamLeader, hirDate)
			employeeCount += 1
		
		print(f"[INFO] {employeeCount} new Employees inserted to DB")







		#-------------Region-------------------

		def insertRegion(name, countries, gm):
			collection = dbDrug['Region']
			
			doc = { "$set":{ "name": name, "Countries": countries, "General_Manager": gm}}
			filter = { 'name': name }
			collection.update_one(filter, doc,  True)




		def findCountries(regionID, cursorSQL):
			resAllCountries = []
			cursorSQL.execute(
			"""
			SELECT * FROM Country
			WHERE ID_region="""+ str(regionID)
			)
			
			allCountries = cursorSQL.fetchall()
			for eachCountry in allCountries:
				resAllCountries.append(eachCountry[0])

			return resAllCountries


		def findGM(regionID, cursorSQL):
			resGM = []
			cursorSQL.execute(
			"""
			SELECT * FROM sql11501710.General_Manager JOIN sql11501710.Employee
			ON sql11501710.General_Manager.ID_employee=sql11501710.Employee.ID_employee
			WHERE ID_region="""+str(regionID)
			)
			
			GM = cursorSQL.fetchall()
			return {"Name": str(GM[0][3])+" "+ str(GM[0][4]), "Gender": GM[0][5], "Salery": int(GM[0][6]), "Team_Leader": GM[0][7], "Hire_Date": creatDate(GM[0][8])}




		cursorSQL.execute(
		"""
		SELECT * FROM Region
		"""
		)
		allRegions = cursorSQL.fetchall()
		countRegion = 0
		for eachRegion in allRegions:
			regionID = eachRegion[0]
			nameRegion = eachRegion[1]
			countries = findCountries(regionID, cursorSQL)
			generalManager = findGM(regionID, cursorSQL)



			insertRegion(nameRegion, countries, generalManager )
			countRegion += 1
		
		print(f"[INFO] {countRegion} new Regions inserted to DB")






		# ----------------- Client --------------------

		def inserCliet(name, country, dbDrug ):
			collection = dbDrug['Client']
			doc = { "$set":{ "name": name, "country_name": country }}
			filter = { 'name': name }
			collection.update_one(filter, doc,  True)


		cursorSQL.execute(
		"""
		SELECT * FROM Client
		"""
		)
		
		res = cursorSQL.fetchall()
		countClient = 0
		for ecahClient in res:
			name = ecahClient[1]
			country = ecahClient[2]
			inserCliet(name, country,  dbDrug)
			countClient += 1
		
		print(f"[INFO] {countClient} new Client inserted to DB")








		# ------------------ ORDER -------------------

		def inserOrder(orderID, client, product, orderDate, quantity, dbDrug ):
			collection = dbDrug['Order']
			date = creatDate(orderDate)
			doc = { "$set":{ "orderID": orderID, "client": client, "Product": product, "Order_Date": date,"Quantity": quantity }}
			filter = { 'orderID': orderID }
			collection.update_one(filter, doc,  True)



		cursorSQL.execute(
		"""
		SELECT * FROM Orders JOIN Product
		ON Orders.ID_Product=Product.ID_product
		JOIN Client
		ON Orders.ID_Client=Client.ID_client

		"""
		)
		res = cursorSQL.fetchall()
		countOrder = 0
		for eachOrder in res:
			orderID = eachOrder[0]
			client = eachOrder[10]
			product = eachOrder[6]
			orderDate = eachOrder[3]
			quantity = int(eachOrder[4])
			inserOrder(orderID, client, product, orderDate, quantity, dbDrug )
			countOrder += 1
		print(f"[INFO] {countOrder} new Orders added to DB")



	except Error as e: 
		print("[ERROR] Could not migrate data from SQL Database to MongoDB.", e)
	finally: 
		cursorSQL.close()
		connSQL.close()
		print("[INFO] SQL connection terminated.")








# ---------------------------------------------------------
# ---------------- classes for fontend --------------------
# ---------------------------------------------------------


@app.route("/Af1", methods=['GET'])
def Af1():

	#------------	ABFRAGE1-----------------------
	nameOfProduct = "NewProd"
	newDoc = { "name": nameOfProduct, "ingredients": ["Highway 37", "Tempo45"], "price": "34" }
	print("in the drug Store")
	collection=dbDrug['Product']
	cursor = collection.find({"name": nameOfProduct})
	count =  (collection.count_documents({"name": nameOfProduct}))
	if count == 1:
		for document in cursor:
			res = "The Product alredy exists" + str(document)
	elif count >= 1:
		res = "Error to many pro woth the same name"
	elif count == 0:
		collection.insert_one(newDoc)
		cursor2 = collection.find({"name": nameOfProduct})
		count2 =  (collection.count_documents({"name": nameOfProduct}))
		if count2 == 1:
			for document in cursor:
				res = "[INFO] The following pro was inserted" + str(document)
	print(res)
	return res



@app.route("/Af2", methods=['GET'])
def Af2():

	#------------	ABFRAGE2-----------------------
	nameOfCountry = "Austria"
	nameOfClient = "Clemens Wager"
	newDoc = { "name": nameOfClient, "country_name":nameOfCountry, "Region": "Niederöstereich" }
	collection=dbDrug['Client']
	
	cursor = collection.find({"name": nameOfClient})

	count =  (collection.count_documents({"name": nameOfClient}))
	if count == 1:
		for document in cursor:
			res = "The Client alredy exists" + str(document)
	elif count >= 1:
		res = "Error to many Clients woth the same name"
	elif count == 0:
		collectionCountry=dbDrug['Country']
		cursor2 = collectionCountry.find({"country_name": nameOfCountry})
		count2 =  (collectionCountry.count_documents({"country_name": nameOfCountry}))
		if count2 == 1:
			collection.insert_one(newDoc)
			cursor3 = collection.find({"name": nameOfClient})
			count3 =  (collection.count_documents({"name": nameOfClient}))
			if count3 == 1:
				for document in cursor:
					res = "[INFO] The follwoing Client was inserted" + str(document)
		else:
			res= "[INFO] The compnay does not surply the country"
	print(res)
	return res



@app.route("/Af3", methods=['GET'])
def Af3():

	#------------	ABFRAGE3-----------------------

	nameOfRegion = "Bielefeld"
	res = "The GM could not be found"
	collection = dbDrug['Country']
	cursor = (collection.find_one({"Regions.Name": nameOfRegion} ))
	cursor2 = (cursor["Regions"])
	for eachRegion in cursor2:
		if  eachRegion["Name"] == nameOfRegion:
			res = "The GM is:" + str(eachRegion["General_Mananger"])
	print(res)
	return res


@app.route("/Af4", methods=['GET'])
def Af4():

	#------------	ABFRAGE4-----------------------

	collection=dbDrug['Order']
	res = ""
	cursor = collection.find().sort("Order_Date", -1).limit(5)
	
	for i in cursor:
		print(i)
		res += str(i) 

	return res




def redirect_url():
	return request.args.get('next') or \
		request.referrer or \
		url_for('index')

@app.route("/list")
def lists ():
	#Display the all Tasks
	todos_l = todos.find()
	a1="active"
	return render_template('index.html',a1=a1,todos=todos_l,t=title,h=heading)

@app.route("/")
@app.route("/uncompleted")
def tasks ():
	#Display the Uncompleted Tasks
	todos_l = todos.find({"done":"no"})
	a2="active"
	return render_template('index.html',a2=a2,todos=todos_l,t=title,h=heading)


@app.route("/completed")
def completed ():
	#Display the Completed Tasks
	todos_l = todos.find({"done":"yes"})
	a3="active"
	return render_template('index.html',a3=a3,todos=todos_l,t=title,h=heading)

@app.route("/done")
def done ():
	#Done-or-not ICON
	id=request.values.get("_id")
	task=todos.find({"_id":ObjectId(id)})
	if(task[0]["done"]=="yes"):
		todos.update_one({"_id":ObjectId(id)}, {"$set": {"done":"no"}})
	else:
		todos.update_one({"_id":ObjectId(id)}, {"$set": {"done":"yes"}})
	redir=redirect_url()	# Re-directed URL i.e. PREVIOUS URL from where it came into this one

#	if(str(redir)=="http://localhost:5000/search"):
#		redir+="?key="+id+"&refer="+refer

	return redirect(redir)



#@app.route("/add")
#def add():
#	return render_template('add.html',h=heading,t=title)

@app.route("/action", methods=['POST'])
def action ():
	#Adding a Task
	name=request.values.get("name")
	desc=request.values.get("desc")
	date=request.values.get("date")
	pr=request.values.get("pr")
	todos.insert_one({ "name":name, "desc":desc, "date":date, "pr":pr, "done":"no"})
	return redirect("/list")

@app.route("/remove")
def remove ():
	#Deleting a Task with various references
	key=request.values.get("_id")
	todos.delete_one({"_id":ObjectId(key)})
	return redirect("/")

@app.route("/update")
def update ():
	id=request.values.get("_id")
	task=todos.find({"_id":ObjectId(id)})
	return render_template('update.html',tasks=task,h=heading,t=title)

@app.route("/action3", methods=['POST'])
def action3 ():
	#Updating a Task with various references
	name=request.values.get("name")
	desc=request.values.get("desc")
	date=request.values.get("date")
	pr=request.values.get("pr")
	id=request.values.get("_id")
	todos.update_one({"_id":ObjectId(id)}, {'$set':{ "name":name, "desc":desc, "date":date, "pr":pr }})
	return redirect("/")

@app.route("/search", methods=['GET'])
def search():
	#Searching a Task with various references

	key=request.values.get("key")
	refer=request.values.get("refer")
	if(refer=="id"):
		try:
			todos_l = todos.find({refer:ObjectId(key)})
			if not todos_l:
				return render_template('index.html',a2=a2,todos=todos_l,t=title,h=heading,error="No such ObjectId is present")
		except InvalidId as err:
			pass
			return render_template('index.html',a2=a2,todos=todos_l,t=title,h=heading,error="Invalid ObjectId format given")
	else:
		todos_l = todos.find({refer:key})
	return render_template('searchlist.html',todos=todos_l,t=title,h=heading)


@app.route("/about")
def about():
	return render_template('credits.html',t=title,h=heading)



if __name__ == "__main__":

	env = os.environ.get('APP_ENV', 'development')
	port = int(os.environ.get('PORT', 5000))
	debug = False if env == 'production' else True
	app.run(host='0.0.0.0', port=port, debug=debug)
	# Careful with the debug mode..