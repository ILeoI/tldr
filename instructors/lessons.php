<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST["student"];
    $time = $_POST["time"];
    $location = $_POST["location"];
    $instructorID = $_SESSION["userID"];

    // Insert into bookings table
    $sql = "INSERT INTO bookings (instructorID, learnerID, time, location) VALUES ('$instructorID', '$studentID', '$time', '$location');";

    if (mysqli_query($conn, $sql)) {
        header("location: ../home-page.php"); // Redirect to instructor's homepage
        exit(); 
    } else {
        header("location: add-lesson.php?feedback=0"); // Redirect with error message
    }
}
?>
