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
DROP TABLE Client CASCADE CONSTRAINTS;
DROP TABLE Product CASCADE CONSTRAINTS;
DROP TABLE Orders CASCADE CONSTRAINTS;
DROP TABLE Campaign CASCADE CONSTRAINTS;
DROP TABLE Employee CASCADE CONSTRAINTS;
DROP TABLE Marketing_emp CASCADE CONSTRAINTS;
DROP TABLE Advertises CASCADE CONSTRAINTS;
DROP TABLE General_Manager CASCADE CONSTRAINTS;
DROP TABLE Region CASCADE CONSTRAINTS;
DROP TABLE Country CASCADE CONSTRAINTS;

--------------------------------------------------------------------------------
-- DELETE  SEQUENCES AND TRIGGERS
--------------------------------------------------------------------------------
DROP SEQUENCE client_seq;
DROP TRIGGER client_trigger;

--------------------------------------------------------------------------------
-- DELETE STORED PROCEDURES
--------------------------------------------------------------------------------
DROP PROCEDURE p_delete_client;
DROP PROCEDURE p_update_client;


