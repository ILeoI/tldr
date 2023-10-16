<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "instructor");

if (isset($_GET["learnerID"])) {
    $sql = "DELETE FROM InstructorLearners WHERE learnerID = '" . $_GET["learnerID"] . "';";
    try {
        mysqli_query($conn, $sql);
        header("location: students.php?feedback=5");
        exit();
    } catch (mysqli_sql_exception) {
        header("location: students.php?feedback=0");
        exit();
    }
} else {
    header("location: students.php");
}
