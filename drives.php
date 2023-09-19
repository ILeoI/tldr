<?php
require_once "inc/dbconn.inc.php";
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
        $licenseNo = "";

        $sql = "SELECT licenseNo FROM Users WHERE id = '" . $_SESSION["userID"] . "';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $licenseNo = $row["licenseNo"];
            }
        }


        $sql = "SELECT * FROM Drives WHERE verified=0 AND learnerLicenseNo = '$licenseNo';";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<ul id=\"verify-drive\">";
                while ($row = mysqli_fetch_assoc($result)) {
                    print_r($row);
                }
                echo "</ul>";

                mysqli_free_result($result);
            }
        }

        ?>

    </div>

    <h1>Drive History</h1>

    <div class="center" id="drive-history">

        <?php

        $sql = "SELECT * FROM Drives WHERE verified=1 AND learnerLicenseNo = '$licenseNo';";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {

                echo "<ul id=\"history\">";

                while ($row = mysqli_fetch_assoc($result)) {
                    print_r($row);

                }
                echo "</ul>";

                mysqli_free_result($result);
            }
        }
        mysqli_close($conn);
        ?>


    </div>

    
</body>

</html>

<?php 




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    

    print_r($_POST);

    $learnerID = 1;
    $driveDate = $_POST["date"];
    $startTime = $_POST["start-time"];
    $endTime = $_POST["end-time"];
    $fromLoc = filter_input(INPUT_POST, "start-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $toLoc = filter_input(INPUT_POST, "furthest-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $road = $_POST["road-type"] . ' ' . $_POST["road-traffic"]; 
    $conditionWeather = $_POST["weather"];
    $conditionTraffic = $_POST["traffic-density"];
    $daytime = $_POST["time"];
    $supervisingDriverID = 555;
    $verified = 1;
    
    $sql = "INSERT INTO Drives(userID, driveDate, startTime, endTime, fromLoc, toLoc, conditionRoad, conditionWeather, conditionTraffic, daytime, supervisingDriverID, verified) 
            VALUES('$learnerID', '$driveDate', '$startTime', '$endTime', '$fromLoc', '$toLoc', '$road', '$conditionWeather', '$conditionTraffic', '$daytime', '$supervisingDriverID', '$verified');";

    try {
        mysqli_query($conn, $sql);
        echo "Drive Added<br>";
    } catch (mysqli_sql_exception) {
        echo "nice try buddy";
    }
}

?>
