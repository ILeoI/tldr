<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/drive-table.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
    <title>TLDR: Your Drives</title>
</head>

<body>

    <?php
    require_once "learner-menu.php";
    ?>


    <div class="center" id="container">
        <?php

        $licenceNo = "";

        $sql = "SELECT licenceNo FROM Users WHERE id = '" . $_SESSION["userID"] . "';";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $licenceNo = $row["licenceNo"];
            }
        }
        mysqli_free_result($result);

        echo "<form action='verify-drive.php' method='post'>";

        echo '<table class="tg">
        <caption>Verify Drive</caption>
        <colgroup>
        <col style="width: 60px">
        <col style="width: 65px">
        <col style="width: 65px">
        <col style="width: 65px">
        <col style="width: 80px">
        <col style="width: 80px">
        <col style="width: 65px">
        <col style="width: 65px">
        <col style="width: 65px">
        <col style="width: 90px">
        <col style="width: 90px">
        <col style="width: 75px">
        <col style="width: 90px">
        </colgroup>
        <thead>
        <tr>
            <td class="cells" rowspan="2">Date</td>
            <td class="cells" colspan="3">Time</td>
            <td class="cells" colspan="2">Location (Suburb)</td>
            <td class="cells" colspan="3">Conditions</td>
            <td class="cells" colspan="2">Qualified Supervising Driver</td>
            <td class="cells" rowspan="2">Daytime</td>
            <td class="cells" rowspan="2">Learner\'s<br>Verification</td>

        </tr>
        <tr>
            <td class="cells">Start<br>am/pm</td>
            <td class="cells">Finish<br>am/pm</td>
            <td class="cells">Duration<br></td>
            <td class="cells">From</td>
            <td class="cells">To</td>
            <td class="cells">Road</td>
            <td class="cells">Weather</td>
            <td class="cells">Traffic</td>
            <td class="cells">Name</td>
            <td class="cells">Licence No.</td>
        </tr>
        </thead>';

        $sql = "SELECT Drives.driveDate, Drives.startTime, Drives.endTime,
                       Drives.duration, Drives.fromLoc, Drives.toLoc,
                       Drives.conditionRoadType, Drives.conditionRoadCapacity, Drives.conditionWeather,
                       Drives.conditionTraffic, Drives.supervisorLicenceNumber, Drives.id,
                       Drives.daytime, Users.firstName, Users.lastName 
                       FROM Drives JOIN Users ON Drives.supervisorLicenceNumber = Users.licenceNo WHERE Drives.verified=0 AND Drives.learnerLicenceNo = '$licenceNo';";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<br>";
                    $day = $row['daytime'] ? "Day" : "Night";
                    $name = $row["firstName"] . " " . $row["lastName"];
                    echo "<tr>
                            <td>{$row['driveDate']}</td>
                            <td>{$row['startTime']}</td>
                            <td>{$row['endTime']}</td>
                            <td>{$row['duration']}</td>
                            <td>{$row['fromLoc']}</td>
                            <td>{$row['toLoc']}</td>
                            <td>{$row['conditionRoadType']} {$row['conditionRoadCapacity']}</td>
                            <td>{$row['conditionWeather']}</td>
                            <td>{$row['conditionTraffic']}</td>
                            <td>$name</td>
                            <td>{$row['supervisorLicenceNumber']}</td>
                            <td>$day</td>
                            <td><input type='checkbox' name='{$row["id"]}'/><br><a class='reject' href='remove-invalid-drive.php?driveID={$row["id"]}'>Reject</a></td>
                          </tr>";
                }

                echo "
                <tr>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td style='background-color: white'></td>
                    <td><input type='submit' id='submit-verify' value='Verify'/></td>
                </tr>";
            } else {
                echo "<tr><td colspan='13'>No Drives To Verify</td></tr>";
            }
        }
        mysqli_free_result($result);


        echo "</table>";
        echo "</form><br>";

        ?>

        <?php

        echo '<table class="tg">
        <caption>Drive History</caption>
        <colgroup>
        <col style="width: 60px">
        <col style="width: 65px">
        <col style="width: 65px">
        <col style="width: 65px">
        <col style="width: 80px">
        <col style="width: 80px">
        <col style="width: 65px">
        <col style="width: 65px">
        <col style="width: 65px">
        <col style="width: 90px">
        <col style="width: 90px">
        <col style="width: 75px">
        <col style="width: 90px">
        </colgroup>
        <thead>
        <tr>
            <td class="cells" rowspan="2">Date</td>
            <td class="cells" colspan="3">Time</td>
            <td class="cells" colspan="2">Location (Suburb)</td>
            <td class="cells" colspan="3">Conditions</td>
            <td class="cells" colspan="2">Qualified Supervising Driver</td>
            <td class="cells" rowspan="2">Daytime</td>
            <td class="cells" rowspan="2">Learner\'s<br>Verification</td>

        </tr>
        <tr>
            <td class="cells">Start<br>am/pm</td>
            <td class="cells">Finish<br>am/pm</td>
            <td class="cells">Duration<br></td>
            <td class="cells">From</td>
            <td class="cells">To</td>
            <td class="cells">Road</td>
            <td class="cells">Weather</td>
            <td class="cells">Traffic</td>
            <td class="cells">Name</td>
            <td class="cells">Licence No.</td>
        </tr>
        </thead>';

        $sql = "SELECT * FROM Drives JOIN Users ON Drives.supervisorLicenceNumber = Users.licenceNo WHERE Drives.verified=1 AND Drives.learnerLicenceNo = '$licenceNo';";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $day = $row['daytime'] ? "Day" : "Night";
                    $name = $row["firstName"] . " " . $row["lastName"];

                    echo "<tr>
                        <td>{$row['driveDate']}</td>
                        <td>{$row['startTime']}</td>
                        <td>{$row['endTime']}</td>
                        <td>{$row['duration']}</td>
                        <td>{$row['fromLoc']}</td>
                        <td>{$row['toLoc']}</td>
                        <td>{$row['conditionRoadType']} {$row['conditionRoadCapacity']}</td>
                        <td>{$row['conditionWeather']}</td>
                        <td>{$row['conditionTraffic']}</td>
                        <td>$name</td>
                        <td>{$row['supervisorLicenceNumber']}</td>
                        <td>$day</td>
                        <td>Verified</td>
                        <td></td>
                      </tr>";
                }
            } else {
                echo "<tr><td colspan='14'>No Drives Completed</td></tr>";
            }
        }
        mysqli_free_result($result);

        echo "</table>";
        mysqli_close($conn);
        ?>


    </div>
</body>

</html>