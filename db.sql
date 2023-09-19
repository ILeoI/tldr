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

CREATE TABLE InstructorLearners (
    instructorID int NOT NULL,
    learnerID int NOT NULL,

    PRIMARY KEY(instructorID, learnerID)
);

CREATE TABLE SupervisorLearners (
    supervisorID int NOT NULL,
    learnerID int NOT NULL,

    PRIMARY KEY(supervisorID, learnerID)
);


CREATE TABLE Drives (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userID int NOT NULL,
    driveDate date,
    startTime time,
    endTime time,
    duration time GENERATED ALWAYS AS (TIMEDIFF(endTime, startTime)),
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
    assessmentItemName varchar(25),
    completed boolean DEFAULT 0,
    assessmentValue varchar(15) DEFAULT NULL
) AUTO_INCREMENT = 1;

CREATE TABLE InvoiceDetails (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    learnerID int,
    instructorID int,
    paymentAmount int
) AUTO_INCREMENT = 1;

CREATE TABLE PaymentDetails (
    userID int NOT NULL PRIMARY KEY,
    cardNumber varchar(16),
    cardExpiryMonth int,
    cardExpiryYear int,
    cardCVV int
);

CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
     instructorID int NOT NULL,
    learnerID int NOT NULL,
    time DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL
);

CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges on tldr.Users to dbadmin@localhost;
GRANT all privileges on tldr.Drives to dbadmin@localhost;
GRANT all privileges on tldr.LogbookCBTA to dbadmin@localhost;
GRANT all privileges on tldr.InvoiceDetails to dbadmin@localhost;
GRANT all privileges on tldr.PaymentDetails to dbadmin@localhost;
GRANT all privileges on tldr.InstructorLearners to dbadmin@localhost;