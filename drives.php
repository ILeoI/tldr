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

    <h1>Verify Drive</h1>

    <div class="center" id="verify-drive">

        <?php

        $sql = "SELECT *, FROM Drives, WHERE verified=0;";

        if ($result = mysqli_query($conn, $sql)) {

            if (mysqli_num_rows($result) > 0) {


                echo "<ul id=\"verify-drive\">";
                while ($row = mysqli_fetch_assoc($result)) {
                }
                echo "</ul>";

                mysqli_free_result($result);
            }
        }
        mysqli_close($conn);

        ?>

    </div>

    <h1>Drive History</h1>

    <div class="center" id="drive-history">

        <?php
        require_once "inc/dbconn.inc.php";

        $sql = "SELECT * FROM Drives;";

        if ($result = mysqli_query($conn, $sql)) {

            if (mysqli_num_rows($result) > 0) {


                echo "<ul id=\"history\">";
                while ($row = mysqli_fetch_assoc($result)) {
                    $XX = $row["id"];
                    echo "<li>" . $row["id"] . "</li>";
                    echo "<li>" . $row["userID"] . "</li>";
                    echo "<li>" . $row["driveDate"] . "</li>";
                    echo "<li>" . $row["startTime"] . "</li>";
                    echo "<li>" . $row["endTime"] . "</li>";
                    echo "<li>" . $row["fromLoc"] . "</li>";
                    echo "<li>" . $row["toLoc"] . "</li>";
                    echo "<li>" . $row["conditionRoad"] . "</li>";
                    echo "<li>" . $row["conditionWeather"] . "</li>";
                    echo "<li>" . $row["conditionTraffic"] . "</li>";
                    echo "<li>" . $row["daytime"] . "</li>";
                    echo "<li>" . $row["supervisingDriverID"] . "</li>";
                    echo "<li>" . $row["verified"] . "</li>";
                }
                echo "</ul>";

                mysqli_free_result($result);
            }
        }
        mysqli_close($conn);

        // id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        // userID int NOT NULL,
        // driveDate date,
        // startTime time,
        // endTime time,
        // fromLoc varchar(100),
        // toLoc varchar(100),
        // conditionRoad varchar(5),
        // conditionWeather varchar(5),
        // conditionTraffic varchar(5),
        // daytime boolean,
        // supervisingDriverID int NOT NULL,
        // verified boolean DEFAULT 0


        ?>


    </div>


</body>

</html>

