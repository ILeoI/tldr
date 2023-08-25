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
    instructor boolean DEFAULT 0
) AUTO_INCREMENT = 1;

-- CREATE TABLE Logbook (
--     id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     driver_id int not null,
--     drive_date date,
--     drive_time time
-- ) AUTO_INCREMENT = 1;

-- CREATE TABLE InstructorLogbook (

-- )

CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges ON tldr.Users to dbadmin@localhost;