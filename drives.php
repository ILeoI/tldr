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

    <div class="center" id="add-drive-form">
        <form id="add-drive" action="drives.php" method="POST">
            <h1>Add Drive</h1>
            <ul>
                <li>
                    <label for="date">Date</label><br>
                    <input type="date" name="date" required>
                </li>

                <li>
                    <label for="start-time">Start Time</label><br>
                    <input type="time" name="start-time" required>
                </li>

                <li>
                    <label for="end-time">End Time</label><br>
                    <input type="time" name="end-time" required>
                </li>

                <li>
                    <label for="start-location">Start Location</label><br>
                    <input type="text" name="start-location" class="text" placeholder="Suburb" required>
                </li>

                <li>
                    <label for="furthest-location">Furthest Location</label><br>
                    <input type="text" name="furthest-location" class="text" placeholder="Suburb" required>
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
                
                    <input type="radio" name="time" value="1" required><label>Daytime</label>
                    <input type="radio" name="time" value="0" required><label>Night-time</label>
                    
                </li>

            </ul>
            <input type="submit" class="submit" value="Submit">

        </form>
    </div>

    
</body>

</html>

<?php 




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $road = $_POST["road-type"] . ' ' . $_POST["road-traffic"]; 

    print_r($_POST);

    $learnerID = 0;
    $driveDate = $_POST["date"];
    $startTime = $_POST["start-time"];
    $endTime = $_POST["end-time"];
    $duration = 0; //create function to calculate drive time off start and finsih
    $fromLoc = filter_input(INPUT_POST, "start-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $toLoc = filter_input(INPUT_POST, "furthest-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $conditionRoad = $road; 
    $conditionWeather = $_POST["weather"];
    $conditionTraffic = $_POST["traffic-density"];
    $daytime = $_POST["time"];
    $supervisingDriverID = 0;
    $verified = 0;
    
    $sql = "INSERT INTO Drives(userID, driveDate, startTime, endTime, duration, fromLoc, toLoc, 
                        conditonRoad, conditionWeather, conditionTraffic, daytime, supervisingDriverID, verified) 
            VALUES('$learnerID', '$driveDate', '$startTime', '$endTime', '$duration', '$fromLoc', '$toLoc', 
                   '$conditionRoad', '$conditionWeather', '$conditionTraffic', $daytime, '$supervisingDriverID', '$verified');";

    try {
        mysqli_query($conn, $sql);
        echo "Drive Added<br>";
    } catch (mysqli_sql_exception) {
        echo "nice try buddy";
    }
}

?>
