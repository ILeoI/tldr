<?php
require_once "inc/dbconn.inc.php";
require_once "inc/session-start.inc.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Coby Murphy">
    <link rel="stylesheet" href="./style/drives.css" />
    <title>Drives</title>
</head>

<body>


    <div class="center" id="drives-container">

        <h1>Verify Drive</h1>


        <div id="verify-drive-container">
            <?php

            $licenseNo = "";

            $sql = "SELECT licenseNo FROM Users WHERE id = '" . $_SESSION["userID"] . "';";
            
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $licenseNo = $row["licenseNo"];
                }
            }

            echo "<form action='verify-drives.php' method='post'>";

            echo "<table>
                <tr>
                    <th>Supervising Driver</th>
                    <th>Date</th>
                    <th>Start Time</th> 
                    <th>End Time</th>
                    <th>Duration</th>
                    <th>Start Location</th>
                    <th>End Location</th>
                    <th>Road Condition</th>
                    <th>Weather Condition</th>
                    <th>Traffic Condition</th>
                    <th>Day Time</th>
                    <th>Permit Number</th>
                    <th>Verify</th>
                </tr>";

            $sql = "SELECT * FROM Drives WHERE verified=0 AND learnerLicenseNo = '$licenseNo';";

            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['supervisorLicenseNumber']}</td>
                            <td>{$row['driveDate']}</td>
                            <td>{$row['startTime']}</td>
                            <td>{$row['endTime']}</td>
                            <td>{$row['duration']}</td>
                            <td>{$row['fromLoc']}</td>
                            <td>{$row['toLoc']}</td>
                            <td>{$row['conditionRoad']}</td>
                            <td>{$row['conditionWeather']}</td>
                            <td>{$row['conditionTraffic']}</td>
                            <td>{$row['daytime']}</td>
                            <td>{$row['learnerLicenseNo']}</td>
                            <td><input type='checkbox' name='{$row["id"]}'/></td>
                          </tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>All drives Verified</td></tr>";
                }
               
            }

            echo "</table>";
            echo "<input type='submit'/>";
            echo "</form>";

            ?>

        </div>

        <div id="drive-history">

            <h1>Drive History</h1>

            <?php

            $sql = "SELECT * FROM Drives WHERE verified=1 AND learnerLicenseNo = '$licenseNo';";

            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {
                        print_r($row);
                    }


                    mysqli_free_result($result);
                }
            }

            echo "<table>
            <tr>
                <th>Supervising Driver</th>
                <th>Date</th>
                <th>Start Time</th> 
                <th>End Time</th>
                <th>Duration</th>
                <th>Start Location</th>
                <th>End Location</th>
                <th>Road Condition</th>
                <th>Weather Condition</th>
                <th>Traffic Condition</th>
                <th>Day Time</th>
                <th>Permit Number</th>
                <th>Verified</th>
            </tr>";

            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <td>{$row['supervisorLicenseNumber']}</td>
                        <td>{$row['driveDate']}</td>
                        <td>{$row['startTime']}</td>
                        <td>{$row['endTime']}</td>
                        <td>{$row['duration']}</td>
                        <td>{$row['fromLoc']}</td>
                        <td>{$row['toLoc']}</td>
                        <td>{$row['conditionRoad']}</td>
                        <td>{$row['conditionWeather']}</td>
                        <td>{$row['conditionTraffic']}</td>
                        <td>{$row['daytime']}</td>
                        <td>{$row['learnerLicenseNo']}</td>
                        <td>{$row['verified']}</td>
                      </tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No Drives Completed</td></tr>";
                }
            }

            echo "</table>";
            mysqli_close($conn);
            ?>

        </div>
    </div>
</body>

</html>