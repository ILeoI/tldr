<?php
require_once "../inc/db-session-include.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST);
    foreach (array_keys($_POST) as $id) {
        $sql = "SELECT * FROM BookingRequests WHERE id = $id;";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $entry = mysqli_fetch_assoc($result);
                $instructorID = $entry["instructorID"];
                $learnerID = $entry["learnerID"];
                $time = $entry["time"];
                $location = $entry["location"];
                $lessonType = $entry["lessonType"];
                $newSQL = "INSERT INTO Bookings(instructorID, learnerID, time, location, lessonType) 
                           VALUES('$instructorID', '$learnerID', '$time', '$location', '$lessonType');";
                $deleteSQL = "DELETE FROM BookingRequests WHERE id = $id;";
                try {
                    mysqli_query($conn, $newSQL);
                    mysqli_query($conn, $deleteSQL);
                } catch (mysqli_sql_exception) {
                }
                mysqli_free_result($result);
                mysqli_close($conn);

                header("Location: your-bookings.php"); // Redirect back to your bookings page
                exit();
            }
        }
    }
}
