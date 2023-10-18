<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "supervisor");

// This script takes the license number of a learner,
// adds the relation in the database.
// Provides appropriate feed back via GET to view-learners.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $licenseNumber = $_POST["learner-ln-input"];
    $supervisorID = $_SESSION["userID"];
    $sql = "SELECT id, supervisor, instructor, government FROM Users WHERE licenseNo = '$licenseNumber';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $learnerID = $row["id"];
            if ($row["supervisor"] == 1 || $row["instructor"] == 1 || $row["government"] == 1) {
                header("location: supervisor-home-page.php?feedback=2");
                exit();
            }
            $sql = "INSERT INTO SupervisorLearners(supervisorID, learnerID) VALUES('$supervisorID', '$learnerID');";
            try {
                mysqli_query($conn, $sql);
                header("location: supervisor-home-page.php?feedback=3");
            } catch (mysqli_sql_exception) {
                header("location: supervisor-home-page.php?feedback=0");
            }
        } else {
            header("location: supervisor-home-page.php?feedback=2");
        }
    }
}
mysqli_close($conn);
