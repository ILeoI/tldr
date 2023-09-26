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
    <title>Add-Drives</title>
</head>

<body>

    <div class="center" id="add-drive-form">
        <form id="add-drive" action="add-drive.php" method="POST">
            <h1>Add Drive</h1>
            <ul>

                <li>
                    <label for="permit-num">Learner Permit</label><br>
                    <input type="text" name="permit-num" pattern="([A-Za-z]{2})+([0-9]{4})" required>
                </li>
                <li>
                    <label for="date">Date</label><br>
                    <input type="date" name="date" required>
                </li>

                <li>
                    <div class="time">
                        <div class="left">
                            <label for="start-time">Start Time</label><br>
                            <input type="time" name="start-time" required>
                        </div>
                        <div>
                            <label for="end-time">End Time</label><br>
                            <input type="time" name="end-time" required>
                        </div>
                    </div>

                </li>

                <li>
                    <div class="time">
                        <div class="left">
                            <label for="start-location">Start Location</label><br>
                            <input type="text" name="start-location" class="text" placeholder="Suburb" required>
                        </div>
                        <div>
                            <label for="furthest-location">Furthest Location</label><br>
                            <input type="text" name="furthest-location" class="text" placeholder="Suburb" required>
                        </div>
                    </div>

                </li>

                <li>
                    <label>Road Type</label><br>
                    <input type="radio" name="road-type" value="s" required><label>Sealed</label>
                    <input type="radio" name="road-type" value="us" required><label>Unsealed</label><br>
                    <input type="radio" name="road-traffic" value="qs" required><label>Quiet Street</label>
                    <input type="radio" name="road-traffic" value="br" required><label>Busy Road</label>
                    <input type="radio" name="road-traffic" value="mlr" required><label>Multi-laned Road</label>
                </li>

                <li>
                    <label>Weather</label><br>
                    <input type="radio" name="weather" value="dry" required><label for="dry">Dry</label>
                    <input type="radio" name="weather" value="wet" required><label for="wet">Wet</label>
                </li>

                <li>
                    <label>Traffic Density</label><br>
                    <input type="radio" name="traffic-density" value="L" required><label>Light</label>
                    <input type="radio" name="traffic-density" value="M" required><label>Medium</label>
                    <input type="radio" name="traffic-density" value="H" required><label>Heavy</label>
                </li>

                <li>
                    <div class="toggle">
                        <input type="radio" name="time" value="1" required><label>Daytime</label>
                        <input type="radio" name="time" value="0" required><label>Night-time</label>
                    </div>
                </li>

            </ul>
            <input type="submit" class="submit" value="Submit">

        </form>
    </div>

</body>

</html>
<?php
$supervisingDriverID = "";

$sql = "SELECT licenseNo FROM Users WHERE id = '" . $_SESSION["userID"] . "';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $supervisingDriverID = $row["licenseNo"];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    print_r($_POST);

    $driveDate = $_POST["date"];
    $startTime = $_POST["start-time"];
    $endTime = $_POST["end-time"];
    $fromLoc = filter_input(INPUT_POST, "start-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $toLoc = filter_input(INPUT_POST, "furthest-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $road = $_POST["road-type"] . ' ' . $_POST["road-traffic"];
    $conditionWeather = $_POST["weather"];
    $conditionTraffic = $_POST["traffic-density"];
    $daytime = $_POST["time"];
    $learnerID = $_POST["learnerLicenseNo"];;
    $verified = 0;

    $sql = "INSERT INTO Drives(supervisorLicenseNumber, learnerLicenseNo, driveDate, startTime, endTime, fromLoc, toLoc, conditionRoad, conditionWeather, conditionTraffic, daytime, learnerLicenseNo, verified) 
            VALUES('$supervisingDriverID', '$learnerID', '$driveDate', '$startTime', '$endTime', '$fromLoc', '$toLoc', '$road', '$conditionWeather', '$conditionTraffic', '$daytime', '$learnerLicenseNo''$verified');";

    try {
        mysqli_query($conn, $sql);
        echo "Drive Added";
    } catch (mysqli_sql_exception) {
        echo "nice try buddy";
    }
}

?>