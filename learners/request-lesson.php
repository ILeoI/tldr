<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $learnerID = $_SESSION["userID"];
    $sql = "SELECT * FROM InstructorLearners INNER JOIN Users WHERE instructorID = Users.id AND learnerID = '$learnerID';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $instructorUser = mysqli_fetch_assoc($result)["id"];
        }
    }


    $time = $_POST['time'];
    $location = $_POST['location'];
    $lessonType = $_POST['LessonType'];

    // Insert data into bookingRequests table
    $sql = "INSERT INTO bookingRequests (learnerID, instructorID, time, location, lessonType)
            VALUES ('$learnerID', '$instructorUser', '$time', '$location', '$lessonType')";

    if (mysqli_query($conn, $sql)) {
        echo "Booking request submitted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    header("location: view-lessons.php");
    exit(); 

    
}
