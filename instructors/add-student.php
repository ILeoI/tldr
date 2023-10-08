<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "instructor");

// This script takes the license number of a student,
// checks if they are already assigned/doesn't exists
// then adds the relation in the database.
// Provides appropriate feed back via GET to students.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $licenseNumber = $_POST["student-ln-input"];
    $instructorID = $_SESSION["userID"];
    $sql = "SELECT id, supervisor, instructor, government FROM Users WHERE licenseNo = '$licenseNumber';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $learnerID = $row["id"];
            if (isset($row["supervisor"]) || isset($row["instructor"]) || isset($row["government"])) {
                header("location: students.php?feedback=4");
                exit();
            }
            $sql = "SELECT * FROM InstructorLearners WHERE learnerID = '$learnerID';";
            mysqli_free_result(($result));
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    header("location: students.php?feedback=1");
                } else {
                    $sql = "INSERT INTO InstructorLearners(instructorID, learnerID) VALUES('$instructorID', '$learnerID');";
                    try {
                        mysqli_query($conn, $sql);
                        header("location: students.php?feedback=3");
                    } catch (mysqli_sql_exception) {
                        header("location: students.php?feedback=0");
                    }
                }
            }
            mysqli_free_result($result);
        } else {
            header("location: students.php?feedback=2");
        }
    }
}
mysqli_close($conn);
