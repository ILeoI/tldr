SET @@AUTOCOMMIT = 1;

DROP DATABASE IF EXISTS tldr;
CREATE DATABASE tldr;

USE tldr;

CREATE TABLE Users (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(100),
    password varchar(100),
    email varchar(100),
    firstName varchar(100),
    lastName varchar(100),
    dob date,
    instructor boolean DEFAULT 0,
    supervisor boolean DEFAULT 0,
    licenseNo varchar(7)
) AUTO_INCREMENT = 1;

CREATE TABLE Logbook (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userID int NOT NULL,
    driveDate date,
    startTime time,
    endTime time,
    duration int, 
    fromLoc varchar(100),
    toLoc varchar(100),
    conditionRoad varchar(5),
    conditionWeather varchar(5),
    conditionTraffic varchar(5),
    daytime boolean,
    supervisingDriverID int NOT NULL
) AUTO_INCREMENT = 1;

CREATE TABLE DrivingTest (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    instructorID int NOT NULL,
    driverID int NOT NULL,
) AUTO_INCREMENT = 1;

CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges ON tldr.Users to dbadmin@localhost;