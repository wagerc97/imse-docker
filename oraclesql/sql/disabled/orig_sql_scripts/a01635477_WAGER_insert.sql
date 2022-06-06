/*******************************************************************************
This SQL script is part of the physical design of my DBS project:
"Pharmaceutical Company" for Milestone 3.
This code defines INSERT statements that populates the tables with test data
and test the database constraints.  

------------------------- INSERT STATEMENTS ------------------------------------

Clemens Wager, 01635477
University of Vienna
VU Database Systems
SS2021

*******************************************************************************/

--------------------------------------------------------------------------------
-- INSERT DATA
--------------------------------------------------------------------------------

-- REGION
INSERT INTO Region (Region_Name) VALUES ('DACH region');
INSERT INTO Region (Region_Name) VALUES ('British Isles');
INSERT INTO Region (Region_Name) VALUES ('Benelux states');
INSERT INTO Region (Region_Name) VALUES ('Nordic region');
-- test constraint of unique name
    INSERT INTO Region (Region_Name) VALUES ('Nordic region');
-- test constraint of name not null
    INSERT INTO Region (Region_Name) VALUES ('');


-- COUNTRY
INSERT INTO Country VALUES ('Germany',          1);
INSERT INTO Country VALUES ('Austria',          1);
INSERT INTO Country VALUES ('Switzerland',      1);
INSERT INTO Country VALUES ('United Kingdom',   2);
INSERT INTO Country VALUES ('Ireland',          2);
INSERT INTO Country VALUES ('Belgium',          3);
INSERT INTO Country VALUES ('Netherlands',      3);
INSERT INTO Country VALUES ('Luxemburg',        3);
INSERT INTO Country VALUES ('Sweden',           4);
INSERT INTO Country VALUES ('Norway',           4);
INSERT INTO Country VALUES ('Finland',          4);
INSERT INTO Country VALUES ('Denmark',          4);
-- test constraint of unique name
    INSERT INTO Country VALUES ('Belgium',3);
-- test FK constraint
    INSERT INTO Country VALUES ('testland',0);
    INSERT INTO Country VALUES ('testland',99);


-- CLIENT
INSERT INTO Client (Client_Name, Country_Name) VALUES ('Celesio',             'Germany');
INSERT INTO Client (Client_Name, Country_Name) VALUES ('Shopapotheke',        'Austria');
INSERT INTO Client (Client_Name, Country_Name) VALUES ('Lloyds Pharmacy',     'Ireland');
INSERT INTO Client (Client_Name, Country_Name) VALUES ('Alliance Healthcare', 'Netherlands');
INSERT INTO Client (Client_Name, Country_Name) VALUES ('D.I.O. Drogist',      'Netherlands');
INSERT INTO Client (Client_Name, Country_Name) VALUES ('Mediq',               'Netherlands');
INSERT INTO Client (Client_Name, Country_Name) VALUES ('Asda',                'United Kingdom');
INSERT INTO Client (Client_Name, Country_Name) VALUES ('Tesco',               'United Kingdom');
-- test constraint not null
    INSERT INTO Client (Client_Name, Country_Name) VALUES ('Tesco','');


-- PRODUCT
INSERT INTO Product VALUES (1892, 'Docilla', 17.23, 'Neuroscience');
INSERT INTO Product VALUES (2874, 'Greenwald', 12.63, 'Neuroscience');
INSERT INTO Product VALUES (3746, 'Freddi', 43.55, 'Oncology');
INSERT INTO Product VALUES (3459, 'Paine', 21.87, 'Cardiovascular / Metabolism'); 
INSERT INTO Product VALUES (9693, 'Stanwood', 19.79, 'Infectious Diseases / Vaccines');
INSERT INTO Product VALUES (4769, 'Lory', 9.44, 'Other');
INSERT INTO Product VALUES (1455, 'Berl', 28.82, 'Immunology');
-- test constraint unique name
    INSERT INTO Product VALUES (1455, 'Remicade', 28.82, 'Immunology');


-- CAMPAIGN
INSERT INTO Campaign VALUES (1892, 'The Best',  to_date('2002-10-01', 'YYYY-MM_DD'),  to_date('2006-01-31', 'YYYY-MM_DD'));
INSERT INTO Campaign VALUES (4769, 'To the stars',  to_date('2012-04-01', 'YYYY-MM_DD'),  to_date('2013-03-31', 'YYYY-MM_DD'));
INSERT INTO Campaign VALUES (2874, 'Where we begin',  to_date('2013-04-01', 'YYYY-MM_DD'),  to_date('2013-05-31', 'YYYY-MM_DD'));
INSERT INTO Campaign VALUES (2874, 'Back again',  to_date('2015-07-01', 'YYYY-MM_DD'),  to_date('2015-12-31', 'YYYY-MM_DD'));
INSERT INTO Campaign VALUES (9693, 'The Best',  to_date('2009-02-01', 'YYYY-MM_DD'),  to_date('2009-11-30', 'YYYY-MM_DD'));
--test check constraint date range feasible
    INSERT INTO Campaign VALUES (9693, 'FAKE Date', to_date('2019-02-01', 'YYYY-MM_DD'),  to_date('2007-11-30', 'YYYY-MM_DD'));
--test check constraints with two campaigns that have the same name 
    INSERT INTO Campaign VALUES (1892, 'The Bestfake',  to_date('2002-10-01', 'YYYY-MM_DD'),  to_date('2006-01-31', 'YYYY-MM_DD'));
    INSERT INTO Campaign VALUES (9693, 'The Bestfake',  to_date('2009-02-01', 'YYYY-MM_DD'),  to_date('2009-11-30', 'YYYY-MM_DD'));
--test check constraints with two campaigns that promote the same product 
    INSERT INTO Campaign VALUES (2874, 'same product 1',  to_date('2013-04-01', 'YYYY-MM_DD'),  to_date('2013-05-31', 'YYYY-MM_DD'));
    INSERT INTO Campaign VALUES (2874, 'same product 2',  to_date('2015-07-01', 'YYYY-MM_DD'),  to_date('2015-12-31', 'YYYY-MM_DD'));


-- EMPLOYEE
INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader, Hire_date) VALUES
    ('Ann', 'Smith', 'F', 2000.99, NULL, to_date('2000-01-01', 'YYYY-MM_DD'));
INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader, Hire_date) VALUES
    ('Bob', 'Mayers', 'M', 1950, NULL, to_date('2001-01-01', 'YYYY-MM_DD'));

INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader, Hire_date) VALUES
    ('Claire', 'Briggs', 'D', 1500, 1, to_date('2012-07-01', 'YYYY-MM_DD'));

INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader, Hire_date) VALUES
    ('Daniel', 'Gustavo', 'M', 1800, 1, to_date('2004-03-01', 'YYYY-MM_DD'));

INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader, Hire_date) VALUES
    ('Emil', 'Billson', 'M', 1600, 2, to_date('2001-01-01', 'YYYY-MM_DD'));

INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader, Hire_date) VALUES
    ('Francisca', 'Williams', 'F', 1900, 2, to_date('2001-03-01', 'YYYY-MM_DD'));

INSERT INTO Employee (Firstname, Lastname, Gender, team_leader, Hire_date) VALUES
    ('Gustavo', 'Anglesi', 'M', 2, to_date('2015-01-01', 'YYYY-MM_DD'));

INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader, Hire_date) VALUES
    ('Helen', 'Pairre', 'F', 1660, 2, to_date('2018-09-01', 'YYYY-MM_DD'));

-- test constraint on gender
    INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader, Hire_date) VALUES
    ('wrong', 'gender', 'Z', 1660, 2, to_date('2018-09-01', 'YYYY-MM_DD'));
-- test constraint DEFAULT Salary
    INSERT INTO Employee (Firstname, Lastname, Gender, team_leader, Hire_date) VALUES
    ('default', 'salary', 'M', 2, to_date('2015-01-01', 'YYYY-MM_DD'));
-- test recruitement data not null
    INSERT INTO Employee (Firstname, Lastname, Gender, Salary, team_leader) VALUES
    ('no', 'req date', 'F', 1660, 2);


-- MARKETING_EMPLOYEE
INSERT INTO Marketing_emp VALUES (5, 'E_commerce');
INSERT INTO Marketing_emp VALUES (6, 'Product_marketing');


-- ADVERTISES
INSERT INTO Advertises VALUES (5, 1455); 
INSERT INTO Advertises VALUES (6, 3746);
-- test uniqueness of PK of advertises
    INSERT INTO Advertises VALUES (6, 3746);


-- GENERAL_MANAGER
INSERT INTO General_Manager VALUES (203, 1);
INSERT INTO General_Manager VALUES (204, 2);
INSERT INTO General_Manager VALUES (207, 3);
INSERT INTO General_Manager VALUES (208, 4);
-- test if region has to exist
    INSERT INTO General_Manager VALUES (208, 9);
-- test 1 to 1 relation 
    INSERT INTO General_Manager VALUES (208, 4);
    INSERT INTO General_Manager VALUES (207, 4);
    INSERT INTO General_Manager VALUES (208, 5);


-- ORDERS
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 1, to_date('2007-02-06', 'YYYY-MM_DD'), 5000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 1, to_date('2007-08-06', 'YYYY-MM_DD'), 6000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 1, to_date('2008-02-06', 'YYYY-MM_DD'), 10000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 1, to_date('2008-08-06', 'YYYY-MM_DD'), 7000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (9693, 1, to_date('2009-02-05', 'YYYY-MM_DD'), 2000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (3746, 2, to_date('2008-11-15', 'YYYY-MM_DD'), 20000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 2, to_date('2010-12-05', 'YYYY-MM_DD'), 23000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (9693, 3, to_date('2017-12-05', 'YYYY-MM_DD'), 75000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 3, to_date('2018-05-07', 'YYYY-MM_DD'), 12000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (9693, 3, to_date('2018-12-31', 'YYYY-MM_DD'), 5000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 4, to_date('2009-10-31', 'YYYY-MM_DD'), 9000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 4, to_date('2010-04-01', 'YYYY-MM_DD'), 50000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (4769, 4, to_date('2016-08-10', 'YYYY-MM_DD'), 35000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 5, to_date('2020-09-09', 'YYYY-MM_DD'), 10000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 7, to_date('2012-07-01', 'YYYY-MM_DD'), 40000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (2874, 7, to_date('2013-04-23', 'YYYY-MM_DD'), 45000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 7, to_date('2014-06-06', 'YYYY-MM_DD'), 6000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (1892, 8, to_date('2010-12-05', 'YYYY-MM_DD'), 35000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (9693, 8, to_date('2014-09-03', 'YYYY-MM_DD'), 10000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (4769, 8, to_date('2018-05-23', 'YYYY-MM_DD'), 15000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (2874, 6, to_date('2014-09-08', 'YYYY-MM_DD'), 6000);
INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (4769, 6, to_date('2018-12-07', 'YYYY-MM_DD'), 8000);
-- test constraint of unique id
    INSERT INTO Orders VALUES (10, 4769, 6, to_date('2018-12-07', 'YYYY-MM_DD'), 8000);
-- test constraint of multiple order by one company in one day
    INSERT INTO Orders (ID_product, ID_client, Order_date, Quantity) VALUES (4769, 6, to_date('2018-12-07', 'YYYY-MM_DD'), 8000);
