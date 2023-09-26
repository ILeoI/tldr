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
    government boolean DEFAULT 0,
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
    supervisorLicenseNumber varchar(6) NOT NULL,
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
    learnerLicenseNo varchar(6) NOT NULL,
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
    cardCVV int,
    accountNumber int DEFAULT NULL,
    bsb int DEFAULT NULL
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
GRANT all privileges on tldr.Bookings to dbadmin@localhost;

INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, learner, licenseNo) 
VALUES("student@tldr.com", "password", "0400000000", "Student", "Driver", "2023-06-15", 1, "LN0000");
INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, instructor, licenseNo) 
VALUES("instructor@tldr.com", "password", "0400000001", "Instructor", "Driver", "1999-05-12", 1, "LN0001");
INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, supervisor, licenseNo) 
VALUES("qsd@tldr.com", "password", "0400000002", "Supervisor", "Driver", "1969-05-12", 1, "LN0003");
INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, government, licenseNo) 
VALUES("government@tldr.com", "password", "0400000003", "Government", "Driver", "1969-05-12", 1, "LN0004");


INSERT INTO InstructorLearners(instructorID, learnerID) VALUES(2, 1);
INSERT INTO SupervisorLearners(supervisorID, learnerID) VALUES(3, 1);

INSERT INTO PaymentDetails(userID, bsb, accountNumber) VALUES (2, 012345, 87654321);
INSERT INTO PaymentDetails(userID, cardNumber, cardExpiryMonth, cardExpiryYear, cardCVV) VALUES(1, 111122223333444, 10, 26, 012);

INSERT INTO Bookings(instructorID, learnerID, time, location) VALUES(2, 1, "2023-10-29 12:40:00", "1 Name Street, Suburb");
INSERT INTO Bookings(instructorID, learnerID, time, location) VALUES(2, 1, "2023-17-29 12:40:00", "1 Name Street, Suburb");
INSERT INTO Bookings(instructorID, learnerID, time, location) VALUES(2, 1, "2023-24-29 12:40:00", "1 Name Street, Suburb");