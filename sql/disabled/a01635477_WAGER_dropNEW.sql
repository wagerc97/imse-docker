/*******************************************************************************
This SQL script is part of the physical design of my DBS project:
"Pharmaceutical Company" for Milestone 3.
This code defines DELETE statements to get rid of all 
TABLES, SEQUENCES, TRIGGERS and STORED PROCEDURES that were created.

-- ----------------------- DELETE STATEMENTS ------------------------------------

Clemens Wager, 01635477
University of Vienna
VU Database Systems
SS2021

*******************************************************************************/

-- ------------------------------------------------------------------------------
-- DELETE TABLES
-- ------------------------------------------------------------------------------
-- original ordner
-- DROP TABLE IF EXISTS Client CASCADE;
-- DROP TABLE IF EXISTS Product CASCADE;
-- DROP TABLE IF EXISTS Orders CASCADE;
-- DROP TABLE IF EXISTS Campaign CASCADE;
-- DROP TABLE IF EXISTS Employee CASCADE;
-- DROP TABLE IF EXISTS Marketing_emp CASCADE;
-- DROP TABLE IF EXISTS Advertises CASCADE;
-- DROP TABLE IF EXISTS General_Manager CASCADE;
-- DROP TABLE IF EXISTS Region CASCADE;
-- DROP TABLE IF EXISTS Country CASCADE;


-- new ordner taking FKs into account
DROP TABLE IF EXISTS Orders CASCADE;
DROP TABLE IF EXISTS Advertises CASCADE;
DROP TABLE IF EXISTS Marketing_emp CASCADE;
DROP TABLE IF EXISTS General_Manager CASCADE;
DROP TABLE IF EXISTS Campaign CASCADE;
DROP TABLE IF EXISTS Product CASCADE;
DROP TABLE IF EXISTS Employee CASCADE;
DROP TABLE IF EXISTS Client CASCADE;
DROP TABLE IF EXISTS Country CASCADE;
DROP TABLE IF EXISTS Region CASCADE;




