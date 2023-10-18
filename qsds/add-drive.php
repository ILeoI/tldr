<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "supervisor");

$supervisingDriverID = "";

$sql = "SELECT licenseNo FROM Users WHERE id = '" . $_SESSION["userID"] . "';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $supervisorLicenseNo = $row["licenseNo"];
    }
}

mysqli_free_result($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driveDate = $_POST["date"];
    $startTime = $_POST["start-time"];
    $endTime = $_POST["end-time"];
    $fromLoc = filter_input(INPUT_POST, "start-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $toLoc = filter_input(INPUT_POST, "furthest-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $roadType = $_POST["road-type"];
    $roadCapacity = $_POST["road-capacity"];
    $conditionWeather = $_POST["weather"];
    $conditionTraffic = $_POST["traffic-density"];
    $daytime = $_POST["time"];
    $learnerLicenseNo = $_POST["permit-number"];;
    $verified = 0;

    $sql = "INSERT INTO Drives(supervisorLicenseNumber, driveDate, startTime, endTime, fromLoc, toLoc, conditionRoadType, conditionRoadCapacity, conditionWeather, conditionTraffic, daytime, learnerLicenseNo) 
            VALUES('$supervisorLicenseNo', '$driveDate', '$startTime', '$endTime', '$fromLoc', '$toLoc', '$roadType', '$roadCapacity', '$conditionWeather', '$conditionTraffic', '$daytime', '$learnerLicenseNo');";

    try {
        mysqli_query($conn, $sql);
        $feedback = 1;
    } catch (mysqli_sql_exception) {
        $feedback = 0;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Coby Murphy">
    <link rel="stylesheet" href="../style/drives.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/autofill.css" />
    <script src="../scripts/menu.js" defer></script>
    <script src="../scripts/add-drive.js" defer></script>
    <script src="../scripts/suburbs.js" defer></script>
    <script src="../scripts/suburbs-optimised.js" defer></script>
    <script src="../scripts/autofill-suburb.js" defer></script>
    <title>TLDR: Add Drives</title>
</head>

<body>
    <?php
    require_once "supervisor-menu.php";
    ?>

    <div class="center" id="add-drive-form">
        <form id="add-drive" action="add-drive.php" method="POST">
            <h1>Add Drive</h1>
            <?php
            if (isset($feedback)) {
                if ($feedback == 1) {
                    echo "<p style='color: green'>Drive added successfully</p>";
                } else {
                    echo "<p style='color: red'>Drive failed to be added</p>";
                }
            }
            ?>
            <ul>
                <li>
                    <label for="permit-number">Learner Permit</label><br>
                    <?php
                    $sql = "SELECT Users.licenseNo, Users.firstName, Users.lastName FROM Users JOIN SupervisorLearners ON Users.id = SupervisorLearners.learnerID;";
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<select name='permit-number' id='permit-number' required>";
                            echo "<option value='none' disabled selected>...</option>";
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row["licenseNo"]}'>{$row["firstName"]} {$row["lastName"]} - {$row["licenseNo"]}</option>";
                            }
                            echo "</select>";
                        } else {
                            echo "<input type='text' name='permit-number' pattern='([A-Za-z]{2})+([0-9]{4})' required>";
                        }
                    }
                    ?>
                </li>
                <li>
                    <label for="date">Date</label><br>
                    <input type="date" name="date" id="date" required>
                </li>

                <li>
                    <div class="time">
                        <div class="left">
                            <label for="start-time">Start Time</label><br>
                            <input type="time" name="start-time" id="start-time" required>
                        </div>
                        <div>
                            <label for="end-time">End Time</label><br>
                            <input type="time" name="end-time" id="end-time" required>
                        </div>
                    </div>

                </li>

                <li>
                    <div class="time">
                        <div class="left">
                            <label for="start-location">Start Location</label><br>
                            <input type="text" name="start-location" id="start-location" class="autofill" placeholder="Suburb" required>
                        </div>
                        <div>
                            <label for="furthest-location">Furthest Location</label><br>
                            <input type="text" name="furthest-location" id="furthest-location" class="autofill" placeholder="Suburb" required>
                        </div>
                    </div>

                </li>

                <li>
                    <label>Road Type</label><br>
                    <input type="radio" name="road-type" value="Sealed" id="road-type-sealed" required><label for="road-type-sealed">Sealed</label>
                    <input type="radio" name="road-type" value="Unsealed" id="road-type-unsealed" required><label for="road-type-unsealed">Unsealed</label><br>
                    <input type="radio" name="road-capacity" value="Quiet Street" id="road-capacity-qs" required><label for="road-capacity-qs">Quiet Street</label>
                    <input type="radio" name="road-capacity" value="Busy Road" id="road-capacity-br" required><label for="road-capacity-br">Busy Road</label>
                    <input type="radio" name="road-capacity" value="Multi-lane Road" id="road-capacity-mlr" required><label for="road-capacity-mlr">Multi-lane Road</label>
                </li>

                <li>
                    <label>Weather</label><br>
                    <input type="radio" name="weather" id="weather-dry" value="Dry" required><label for="weather-dry">Dry</label>
                    <input type="radio" name="weather" id="weather-wet" value="Wet" required><label for="weather-wet">Wet</label>
                </li>

                <li>
                    <label>Traffic Density</label><br>
                    <input type="radio" name="traffic-density" id="traffic-density-l" value="Light" required><label for="traffic-density-l">Light</label>
                    <input type="radio" name="traffic-density" id="traffic-density-m" value="Medium" required><label for="traffic-density-m">Medium</label>
                    <input type="radio" name="traffic-density" id="traffic-density-h" value="Heavy" required><label for="traffic-density-h">Heavy</label>
                </li>

                <li>
                    <label>Time of Drive</label><br>
                    <div class="toggle">
                        <input type="radio" name="time" id="time-day" value="1" required><label for="time-day">Day Time</label>
                        <input type="radio" name="time" id="time-night" value="0" required><label for="time-night">Night Time</label>
                    </div>
                </li>

            </ul>
            <input type="submit" class="submit" value="Submit">

        </form>
    </div>

</body>

</html>

<?php
mysqli_close($conn);
?>