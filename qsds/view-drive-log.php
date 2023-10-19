<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "supervisor");

$viewingID = "0";
if (isset($_GET["learnerID"])) {
    $viewingID = $_GET["learnerID"];
    if (!checkUserType($conn, "learner", $viewingID)) {
        header("location: supervisor-home-page.php");
        exit();
    }
} else {
    header("location: supervisor-home-page.php");
    exit();
}

$sql = "SELECT * FROM Users JOIN SupervisorLearners ON Users.id = SupervisorLearners.learnerID WHERE id = '$viewingID';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $viewingUser = mysqli_fetch_assoc($result);
        $licenceNo = $viewingUser["licenceNo"];
        $name = $viewingUser["firstName"] . " " . $viewingUser["lastName"];
    } else {
        header("location: supervisor-home-page.php");
    }
    mysqli_free_result($result);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/drive-table.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
    <title>TLDR: Viewing Drive Log For <?php echo $name ?></title>
</head>

<body>
    <?php require_once "supervisor-menu.php" ?>
    <div class="center">
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

        $sql = "SELECT * FROM Drives JOIN Users ON Drives.supervisorLicenceNumber = Users.licenceNo WHERE Drives.learnerLicenceNo = '$licenceNo' ORDER BY Drives.driveDate;";

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