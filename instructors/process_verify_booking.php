<?php
require_once "../inc/db-session-include.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST);
    foreach (array_keys($_POST) as $id) {
        if (str_starts_with($id, "amount")) {
            continue;
        }
        $sql = "SELECT * FROM BookingRequests WHERE id = $id;";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $entry = mysqli_fetch_assoc($result);
                $instructorID = $entry["instructorID"];
                $learnerID = $entry["learnerID"];
                $time = $entry["time"];
                $location = $entry["location"];
                $lessonType = $entry["lessonType"];
                $amount = $_POST["amount-" . $id];
                $newSQL = "INSERT INTO Bookings(instructorID, learnerID, time, location, lessonType, amount) 
                           VALUES('$instructorID', '$learnerID', '$time', '$location', '$lessonType','$amount');";
                $invoiceSQL = "INSERT INTO InvoiceDetails(instructorID, learnerID, time, location, lessonType, amount)
                               VALUES('$instructorID', '$learnerID', '$time', '$location', '$lessonType','$amount');";

                $deleteSQL =  "DELETE FROM BookingRequests WHERE id = $id;";
                echo $newSQL . "<br>";
                echo $invoiceSQL . "<br>";
                echo $deleteSQL . "<br>";
                try {
                    mysqli_query($conn, $invoiceSQL);
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
