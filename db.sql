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
    licenceNo varchar(6),
    hasTempPassword boolean DEFAULT 0
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
    supervisorLicenceNumber varchar(6) NOT NULL,
    driveDate date,
    startTime time,
    endTime time,
    duration time GENERATED ALWAYS AS (TIMEDIFF(endTime, startTime)),
    fromLoc varchar(100),
    toLoc varchar(100),
    conditionRoadType varchar(20),
    conditionRoadCapacity varchar(20),
    conditionWeather varchar(20),
    conditionTraffic varchar(20),
    daytime boolean,
    learnerLicenceNo varchar(6) NOT NULL,
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
    status int DEFAULT 0,
    time DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    lessonType VARCHAR(25) NOT NULL,
    amount int DEFAULT 80
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
    lessonType varchar(25),
    location VARCHAR(255) NOT NULL,
    status varchar(10),
    amount int DEFAULT 80
);

CREATE TABLE bookingRequests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    instructorID int NOT NULL,
    learnerID int NOT NULL,
    time DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    lessonType VARCHAR(25) NOT NULL,
    verified boolean DEFAULT 0
);

CREATE TABLE InstructorInfo (
    instructorID INT PRIMARY KEY,
    serviceableArea varchar(40),
    aboutMe varchar(512)
);

CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges on tldr.Users to dbadmin@localhost;
GRANT all privileges on tldr.Drives to dbadmin@localhost;
GRANT all privileges on tldr.LogbookCBTA to dbadmin@localhost;
GRANT all privileges on tldr.InvoiceDetails to dbadmin@localhost;
GRANT all privileges on tldr.PaymentDetails to dbadmin@localhost;
GRANT all privileges on tldr.InstructorLearners to dbadmin@localhost;
GRANT all privileges on tldr.SupervisorLearners to dbadmin@localhost;
GRANT all privileges on tldr.Bookings to dbadmin@localhost;
GRANT all privileges on tldr.bookingRequests to dbadmin@localhost;
GRANT all privileges on tldr.InstructorInfo to dbadmin@localhost;


-- Students
INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, learner, licenceNo) 
VALUES("student@tldr.com", "password", "0400000000", "Student", "Driver", "2023-06-15", 1, "LN0000");
INSERT INTO PaymentDetails(userID, cardNumber, cardExpiryMonth, cardExpiryYear, cardCVV) VALUES(1, 1111222233334444, 10, 26, 012);

INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, learner, licenceNo) 
VALUES("student2@tldr.com", "password", "0400000004", "Student2", "Driver2", "2013-09-12", 1, "LN0005");
INSERT INTO PaymentDetails(userID, cardNumber, cardExpiryMonth, cardExpiryYear, cardCVV) VALUES(2, 9999000011112222, 10, 26, 012);

INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, learner, licenceNo) 
VALUES("student3@tldr.com", "password", "0400000005", "Student3", "Driver3", "2014-08-17", 1, "LN0006");
INSERT INTO PaymentDetails(userID, cardNumber, cardExpiryMonth, cardExpiryYear, cardCVV) VALUES(3, 5555666677778888, 10, 26, 012);

-- Instructor
INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, instructor, licenceNo) 
VALUES("instructor@tldr.com", "password", "0400000001", "Instructor", "Driver", "1999-05-12", 1, "LN0001");

INSERT INTO InstructorInfo(instructorID, serviceableArea, aboutMe)
VALUES (4, "Mitcham and Marion", "I'm passionate about teaching safe and confident driving skills to new drivers. With years of experience, I'm dedicated to helping learners master the road. Let's embark on a journey towards responsible and skilled driving together!");

-- QSD
INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, supervisor, licenceNo) 
VALUES("qsd@tldr.com", "password", "0400000002", "Supervisor", "Driver", "1969-05-12", 1, "LN0003");

-- Government
INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, government, licenceNo) 
VALUES("government@tldr.com", "password", "0400000003", "Government", "Driver", "1969-05-12", 1, "LN0004");


INSERT INTO InstructorLearners(instructorID, learnerID) VALUES(4, 1);
INSERT INTO SupervisorLearners(supervisorID, learnerID) VALUES(5, 1);

INSERT INTO PaymentDetails(userID, bsb, accountNumber) VALUES (4, 123456, 87654321);

INSERT INTO Bookings(instructorID, learnerID, time, location, lessonType) VALUES(4, 1, "2023-10-01 12:40:00", "1 Name Street, Suburb", "CBTA");
INSERT INTO Bookings(instructorID, learnerID, time, location, lessonType) VALUES(4, 1, "2023-10-08 12:40:00", "1 Name Street, Suburb", "Practice Lesson");
INSERT INTO Bookings(instructorID, learnerID, time, location, lessonType) VALUES(4, 1, "2023-10-15 12:40:00", "1 Name Street, Suburb", "CBTA");

INSERT INTO InvoiceDetails(instructorID, learnerID, time, location, lessonType, amount, status) VALUES(4, 1, "2023-10-01 12:40:00", "1 Name Street, Suburb", "CBTA", 75, 0);
INSERT INTO InvoiceDetails(instructorID, learnerID, time, location, lessonType, amount, status) VALUES(4, 1, "2023-10-08 12:40:00", "1 Name Street, Suburb", "Practice Lesson", 50, 0);
INSERT INTO InvoiceDetails(instructorID, learnerID, time, location, lessonType, amount, status) VALUES(4, 1, "2023-10-15 12:40:00", "1 Name Street, Suburb", "CBTA", 50, 0);


-- Insert Drives for students
INSERT INTO Drives(supervisorLicenceNumber, driveDate, startTime, endTime, fromLoc, toLoc, conditionRoadType, conditionRoadCapacity, conditionWeather, conditionTraffic, daytime, learnerLicenceNo)
VALUES("LN0003",  "2023-09-21", "12:30", "14:30", "Port Noarlunga", "Tonsley", "Sealed", "Busy Road", "Dry", "l", 1, "LN0000");

INSERT INTO Drives(supervisorLicenceNumber, driveDate, startTime, endTime, fromLoc, toLoc, conditionRoadType, conditionRoadCapacity, conditionWeather, conditionTraffic, daytime, learnerLicenceNo)
VALUES("LN0003",  "2023-09-22", "12:30", "14:30", "Port Noarlunga", "Tonsley", "Sealed", "Busy Road", "Dry", "l", 1, "LN0000");

INSERT INTO Drives(supervisorLicenceNumber, driveDate, startTime, endTime, fromLoc, toLoc, conditionRoadType, conditionRoadCapacity, conditionWeather, conditionTraffic, daytime, learnerLicenceNo)
VALUES("LN0003",  "2023-09-23", "12:30", "14:30", "Port Noarlunga", "Tonsley", "Sealed", "Busy Road", "Dry", "l", 1, "LN0000");
    