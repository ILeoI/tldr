SET @@AUTOCOMMIT = 1;

DROP DATABASE IF EXISTS tldr;
CREATE DATABASE tldr;

USE tldr;

CREATE TABLE Users (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email varchar(100) UNIQUE,
    password varchar(100),
    phoneNumber varchar(10),
    firstName varchar(100),
    lastName varchar(100),
    dob date,
    learner boolean DEFAULT 0,
    instructor boolean DEFAULT 0,
    supervisor boolean DEFAULT 0,
    licenseNo varchar(6)
) AUTO_INCREMENT = 1;

CREATE TABLE Drives (
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
    supervisingDriverID int NOT NULL,
    verified boolean DEFAULT 0
) AUTO_INCREMENT = 1;

CREATE TABLE LogbookCBTA (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    instructorID int NOT NULL,
    driverID int NOT NULL,
    completeDate date,
    unitNo int,
    taskNo int,
    assessmentNo int,
    completed boolean DEFAULT 0
) AUTO_INCREMENT = 1;

CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges on tldr.Users to dbadmin@localhost;
GRANT all privileges on tldr.Drives to dbadmin@localhost;
GRANT all privileges on tldr.LogbookCBTA to dbadmin@localhost;