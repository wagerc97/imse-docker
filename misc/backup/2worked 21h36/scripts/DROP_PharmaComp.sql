/*******************************************************************************
This SQL script is part of the physical design of my DBS project:
"Pharmaceutical Company" for Milestone 3.
This code defines DELETE statements to get rid of all 
TABLES, SEQUENCES, TRIGGERS and STORED PROCEDURES that were created.

------------------------- DELETE STATEMENTS ------------------------------------

Clemens Wager, 01635477
University of Vienna
VU Database Systems
SS2021

*******************************************************************************/

--------------------------------------------------------------------------------
-- DELETE TABLES
--------------------------------------------------------------------------------
SET FOREIGN_KEY_CHECKS=0;  -- mySQL specific as "CASCADE constraints" does not exist
DROP TABLE PharmaComp.Client CASCADE;
DROP TABLE PharmaComp.Product CASCADE;
DROP TABLE PharmaComp.Orders CASCADE;
DROP TABLE PharmaComp.Campaign CASCADE;
DROP TABLE PharmaComp.Employee CASCADE;
DROP TABLE PharmaComp.Marketing_emp CASCADE;
DROP TABLE PharmaComp.Advertises CASCADE;
DROP TABLE PharmaComp.General_Manager CASCADE;
DROP TABLE PharmaComp.Region CASCADE;
DROP TABLE PharmaComp.Country CASCADE;
SET FOREIGN_KEY_CHECKS=1; -- turn check back on again


--------------------------------------------------------------------------------
-- DELETE STORED PROCEDURES
--------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS PharmaComp.p_delete_client;
DROP PROCEDURE IF EXISTS PharmaComp.p_update_client;
DROP PROCEDURE IF EXISTS PharmaComp.p_delete_employee;
DROP PROCEDURE IF EXISTS PharmaComp.p_update_employee;


/*******************************************************************************
--------------------------------------------------------------------------------
-- DELETE  SEQUENCES AND TRIGGERS
--------------------------------------------------------------------------------
DROP SEQUENCE client_seq;
DROP TRIGGER client_trigger;
*******************************************************************************/

