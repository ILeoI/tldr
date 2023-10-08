<?php
require_once "../inc/db-session-include.php";

// preload all the information about the user and their instructor
$viewingID = "0";
if (isset($_GET["viewing"])) {
    $viewingID = $_GET["viewing"];
} else {
    header("location: view-students.php");
}

$sql = "SELECT * FROM Users WHERE id = '$viewingID';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $viewingUser = mysqli_fetch_assoc($result);
    }
}
mysqli_free_result($result);
$sql = "SELECT * FROM InstructorLearners INNER JOIN Users WHERE instructorID = Users.id AND learnerID = '$viewingID';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $instructorUser = mysqli_fetch_assoc($result);
    }
}
mysqli_free_result($result);

class AssessmentItem
{
    public $name;
    public $date;
}

$db_result = array();
$value_result = array();
$sql = "SELECT assessmentItemName, assessmentValue, completeDate FROM LogbookCBTA WHERE completed = '1' AND driverID = '" . $viewingID . "';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["assessmentValue"] != NULL) {
                $value_result[$row["assessmentItemName"]] = $row["assessmentValue"];
            }
            $db_result[$row["assessmentItemName"]] = $row["completeDate"];
        }
    }
}
mysqli_free_result($result);

function isSelectedOption($value_result, $name, $i)
{
    if (isset($value_result["control-$i-1"])) {
        if ($value_result["control-$i-1"] == $name) {
            echo "selected";
        }
    } else if (isset($value_result["control-$i-2"])) {
        if ($value_result["control-$i-2"] == $name) {
            echo "selected";
        }
    }
}

function isChecked(string $name, array $array)
{
    if (isset($array[$name])) {
        return true;
    }
    return false;
}

function getCompleteDate(string $name, array $array)
{
    return $array[$name];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../scripts/menu.js" defer></script>
    <script src="../scripts/collapsible.js" defer></script>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/collapsible.css" />
    <title>TLDR: Viewing A Student</title>
</head>

<body>
    <!-- Load the government menu -->
    <?php require_once "government-menu.php"; ?>

    <!-- Show what student is being viewed -->
    <h1>Viewing Student: <?php echo $viewingUser["firstName"] . " " . $viewingUser["lastName"]; ?></h1>
    <!-- Show who their instructor is -->
    <h2>Instructor:</h2>
    <label><?php echo $instructorUser["firstName"] . " " . $instructorUser["lastName"] . ", <a href=\"view-instructor.php?viewing=" . $instructorUser["id"] . "\">View</a>"; ?></label><br><br>
    <!-- Show their drives -->
    <button class="collapsible">View Drives</button>
    <div class="content">
        <?php

        $sql = "SELECT * FROM Drives WHERE learnerLicenseNo = '{$viewingUser["licenseNo"]}';";

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
        mysqli_free_result($result);

        echo "</table>";
        ?>
    </div>
    <br>
    <button class="collapsible">View CBT&A</button>
    <div class="content">
        <div class="task1">
            <h4>Task 1</h4>
            <label for="cabin-drill">Cabin drill:</label>
            <input type="checkbox" name="cabin-drill-1" id="cabin-drill-1" <?php echo (isChecked("cabin-drill-1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="cabin-drill-2" id="cabin-drill-2" <?php echo (isChecked("cabin-drill-2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("cabin-drill-2", $db_result)) echo "Completed on " . getCompleteDate("cabin-drill-2", $db_result) ?></label>
            <br>
            <label>Controls <i>(selected from the respective groups)</i></label><br>

            <label for="control-1-name">Control 1:</label>
            <select name="control-1-name" id="control-1-name" <?php if (isset($value_result["control-1-1"]) || isset($value_result["control-1-2"])) {
                                                                    echo "disabled";
                                                                } ?>>
                <option <?php isSelectedOption($value_result, "Brake", 1) ?> value="Brake">Brake</option>
                <option <?php isSelectedOption($value_result, "Accelerator", 1) ?> value="Accelerator">Accelerator</option>
                <option <?php isSelectedOption($value_result, "Steering wheel", 1) ?> value="Steering wheel">Steering wheel</option>
                <option <?php isSelectedOption($value_result, "Gear lever", 1) ?> value="Gear lever">Gear lever</option>
            </select>
            <input type="checkbox" name="control-1-1" id="control-1-1" <?php echo (isChecked("control-1-1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="control-1-2" id="control-1-2" <?php echo (isChecked("control-1-2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("control-1-2", $db_result)) echo "Completed on " . getCompleteDate("control-1-2", $db_result) ?></label>
            <br>

            <label for="control-2-name">Control 2:</label>
            <select name="control-2-name" id="control-2-name" <?php if (isset($value_result["control-2-1"]) || isset($value_result["control-2-2"])) {
                                                                    echo "disabled";
                                                                } ?>>
                <option <?php isSelectedOption($value_result, "Clutch", 2) ?> value="Clutch">Clutch</option>
                <option <?php isSelectedOption($value_result, "Park brake", 2) ?> value="Park brake">Park brake</option>
                <option <?php isSelectedOption($value_result, "Warning device", 2) ?> value="Warning device">Warning device</option>
                <option <?php isSelectedOption($value_result, "Signals", 2) ?> value="Signals">Signals</option>
            </select>
            <input type="checkbox" name="control-2-1" id="control-2-1" <?php echo (isChecked("control-2-1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="control-2-2" id="control-2-2" <?php echo (isChecked("control-2-2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("control-2-2", $db_result)) echo "Completed on " . getCompleteDate("control-2-2", $db_result) ?></label>
            <br>

            <label for="control-3-name">Control 3:</label>
            <select name="control-3-name" id="control-3-name" <?php if (isset($value_result["control-3-1"]) || isset($value_result["control-3-2"])) {
                                                                    echo "disabled";
                                                                } ?>>
                <option <?php isSelectedOption($value_result, "Heater/demister", 3) ?> value="Heater/demister">Heater/demister</option>
                <option <?php isSelectedOption($value_result, "Wipers and washers", 3) ?> value="Wipers and washers">Wipers and washers</option>
                <option <?php isSelectedOption($value_result, "Warning lights", 3) ?> value="Warning lights">Warning lights</option>
                <option <?php isSelectedOption($value_result, "Vehicle lights", 3) ?> value="Vehicle lights">Vehicle lights</option>
                <option <?php isSelectedOption($value_result, "Gauges", 3) ?> value="Gauges">Gauges</option>
            </select>
            <input type="checkbox" name="control-3-1" id="control-3-1" <?php echo (isChecked("control-3-1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="control-3-2" id="control-3-2" <?php echo (isChecked("control-3-2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("control-3-2", $db_result)) echo "Completed on " . getCompleteDate("control-3-2", $db_result) ?></label>
            <br>
        </div>

        <div class="task2">
            <h4>Task 2</h4>
            <label>Starting the engine:</label>
            <input type="checkbox" name="start-engine1" <?php echo (isChecked("start-engine1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="start-engine2" <?php echo (isChecked("start-engine2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("start-engine2", $db_result)) echo "Completed on " . getCompleteDate("start-engine2", $db_result) ?></label>
            <br>

            <label>Stopping the engine:</label>
            <input type="checkbox" name="stop-engine1" <?php echo (isChecked("stop-engine1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="stop-engine2" <?php echo (isChecked("stop-engine2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("stop-engine2", $db_result)) echo "Completed on " . getCompleteDate("stop-engine2", $db_result) ?></label>
            <br>

        </div>

        <div class="task3">
            <h4>Task 3</h4>

            <label>Move off from the kerb:</label>
            <input type="checkbox" name="move-off-kerb1" <?php echo (isChecked("move-off-kerb1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="move-off-kerb2" <?php echo (isChecked("move-off-kerb2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("move-off-kerb2", $db_result)) echo "Completed on " . getCompleteDate("move-off-kerb2", $db_result) ?></label>
            <br>

        </div>

        <div class="task4">
            <h4>Task 4</h4>
            <label>Stop the vehicle <i>(include slowing)</i>:</label>
            <input type="checkbox" name="stop-vehicle1" <?php echo (isChecked("stop-vehicle1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="stop-vehicle2" <?php echo (isChecked("stop-vehicle2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("stop-vehicle2", $db_result)) echo "Completed on " . getCompleteDate("stop-vehicle2", $db_result) ?></label>
            <br>

            <label>Secure the vehicle to prevent rolling <i>(a prolonged stop)</i>:</label>
            <input type="checkbox" name="stop-roll1" <?php echo (isChecked("stop-roll1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="stop-roll2" <?php echo (isChecked("stop-roll2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("stop-roll2", $db_result)) echo "Completed on " . getCompleteDate("stop-roll2", $db_result) ?></label>
            <br>
        </div>

        <div class="task5">
            <h4>Task 5</h4>
            <label>Stop and go <i>(using the park brake)</i>:</label>
            <input type="checkbox" name="park-brake1" <?php echo (isChecked("park-brake1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="park-brake2" <?php echo (isChecked("park-brake2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("park-brake2", $db_result)) echo "Completed on " . getCompleteDate("park-brake2", $db_result) ?></label>
            <br>

        </div>

        <div class="task6">
            <h4>Task 6</h4>
            <label>(1) Change gears up and down <i>(100% accurate and a minimum of 5
                    demonstrations)</i></label>
            <br>
            <input type="checkbox" name="change-gear1" <?php echo (isChecked("change-gear1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="change-gear2" <?php echo (isChecked("change-gear2", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="change-gear3" <?php echo (isChecked("change-gear3", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="change-gear4" <?php echo (isChecked("change-gear4", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="change-gear5" <?php echo (isChecked("change-gear5", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("change-gear5", $db_result)) echo "Completed on " . getCompleteDate("change-gear5", $db_result) ?></label>
            <br>
            <label>
                (2) Accurately select appropriate gears for varying speeds <i>(100% accuracy and a
                    minimum of 5 demonstrations)</i></label>
            <br>
            <input type="checkbox" name="select-valid-gear1" <?php echo (isChecked("select-valid-gear1", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="select-valid-gear2" <?php echo (isChecked("select-valid-gear2", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="select-valid-gear3" <?php echo (isChecked("select-valid-gear3", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="select-valid-gear4" <?php echo (isChecked("select-valid-gear4", $db_result) ? "checked" : "") . " disabled" ?>>
            <input type="checkbox" name="select-valid-gear5" <?php echo (isChecked("select-valid-gear5", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("select-valid-gear5", $db_result)) echo "Completed on " . getCompleteDate("select-valid-gear5", $db_result) ?></label>
            <br>

        </div>

        <div class="task7">
            <h4>Task 7</h4>
            <h5>Demonstration 1</h5>
            <label>(1) Steer in a forward direction <i>(minimum of 4 left and 4 right turns)</i></label>
            <ul>
                <li>
                    <label>100% <i>(left)</i></label>
                    <input type="checkbox" name="steer-forward-left11" <?php echo (isChecked("steer-forward-left11", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-left12" <?php echo (isChecked("steer-forward-left12", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-left13" <?php echo (isChecked("steer-forward-left13", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-left14" <?php echo (isChecked("steer-forward-left14", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("steer-forward-left14", $db_result)) echo "Completed on " . getCompleteDate("steer-forward-left14", $db_result) ?></label>
                </li>
                <li>
                    <label>100% <i>(right)</i></label>
                    <input type="checkbox" name="steer-forward-right11" <?php echo (isChecked("steer-forward-right11", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-right12" <?php echo (isChecked("steer-forward-right12", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-right13" <?php echo (isChecked("steer-forward-right13", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-right14" <?php echo (isChecked("steer-forward-right14", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("steer-forward-right14", $db_result)) echo "Completed on " . getCompleteDate("steer-forward-right14", $db_result) ?></label>
                </li>
            </ul>
            <label>(2) Steer in reverse <i>(minimum of 1 left reverse)</i></label>
            <ul>
                <li>
                    <label>100% <i>(left reverse)</i></label>
                    <input type="checkbox" name="steer-reverse-left1" <?php echo (isChecked("steer-reverse-left1", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("steer-reverse-left1", $db_result)) echo "Completed on " . getCompleteDate("steer-reverse-left1", $db_result) ?></label>
                </li>
            </ul>
            <h5>Demonstration 2</h5>
            <label>(1) Steer in a forward direction <i>(minimum of 4 left and 4 right turns)</i></label>
            <ul>
                <li>
                    <label>100% <i>(left)</i></label>
                    <input type="checkbox" name="steer-forward-left21" <?php echo (isChecked("steer-forward-left21", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-left22" <?php echo (isChecked("steer-forward-left22", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-left23" <?php echo (isChecked("steer-forward-left23", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-left24" <?php echo (isChecked("steer-forward-left24", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("steer-forward-left24", $db_result)) echo "Completed on " . getCompleteDate("steer-forward-left24", $db_result) ?></label>
                </li>
                <li>
                    <label>100% <i>(right)</i></label>
                    <input type="checkbox" name="steer-forward-right21" <?php echo (isChecked("steer-forward-right21", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-right22" <?php echo (isChecked("steer-forward-right22", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-right23" <?php echo (isChecked("steer-forward-right23", $db_result) ? "checked" : "") . " disabled" ?>>
                    <input type="checkbox" name="steer-forward-right24" <?php echo (isChecked("steer-forward-right24", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("steer-forward-right24", $db_result)) echo "Completed on " . getCompleteDate("steer-forward-right24", $db_result) ?></label>
                </li>
            </ul>
            <label>(2) Steer in reverse <i>(minimum of 1 left reverse)</i></label>
            <ul>
                <li>
                    <label>100% <i>(left reverse)</i></label>
                    <input type="checkbox" name="steer-reverse-left2" <?php echo (isChecked("steer-reverse-left2", $db_result) ? "checked" : "") . " disabled" ?>><label><?php if (isChecked("steer-reverse-left2", $db_result)) echo "Completed on " . getCompleteDate("steer-reverse-left2", $db_result) ?></label>
                </li>
            </ul>
            <br>
        </div>
    </div>
    <br>
    <button class="collapsible">View Account</button>
    <div class="content">
        <?php
        $id = $viewingID;
        $sql = "SELECT *
                FROM users
                LEFT JOIN PaymentDetails ON users.id = PaymentDetails.userID
                WHERE users.id = $id;";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);

                $cardNumber = $user['cardNumber'] !== null ? $user['cardNumber'] : '';
                $cardExpiryMonth = $user['cardExpiryMonth'] !== null ? $user['cardExpiryMonth'] : '';
                $cardExpiryYear = $user['cardExpiryYear'] !== null ? $user['cardExpiryYear'] : '';
                $cardCVV = $user['cardCVV'] !== null ? $user['cardCVV'] : '';

                echo '
                <div class="immutable-account-info">
                    <table>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>Email: </td>
                            <td>' . $user['email'] . '</td>
                        </tr>
                        <tr>
                            <td>Phone Number: </td>
                            <td>' . $user['phoneNumber'] . '</td>
                        </tr>
                        <tr>
                            <td>License Number: </td>
                            <td>' . $user['licenseNo'] . '</td>
                        </tr>
                        <tr>
                            <td>First Name: </td>
                            <td>' . $user['firstName'] . '</td>
                        </tr>
                        <tr>
                            <td>Last Name: </td>
                            <td>' . $user['lastName'] . '</td>
                        </tr>
                        <tr>
                            <td>Card Number: </td>
                            <td>' . $cardNumber . '</td>
                        </tr>
                        <tr>
                            <td>Expiry Month: </td>
                            <td>' . $cardExpiryMonth . '</td>
                        </tr>
                        <tr>
                            <td>Expiry Year: </td>
                            <td>' . $cardExpiryYear . '</td>
                        </tr>
                        <tr>
                            <td>CVV: </td>
                            <td>' . $cardCVV . '</td>
                        </tr>
                        <tr>
                            <td> 
                                <button id="edit-account" class="edit-account-button">Edit Account</button> 
                            </td>
                        </tr>
                    </table>
                </div>';

                echo '
                <div class="editable-account-info">
                    <form action="edit-account.php" method="POST">
                        <table>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>Email: </td>
                                <td><input type="text" value="' . $user['email'] . '"></td>
                            </tr>
                            <tr>
                                <td>Phone Number: </td>
                                <td><input type="text" value="' . $user['phoneNumber'] . '"></td>
                            </tr>
                            <tr>
                                <td>License Number: </td>
                                <td><input type="text" value="' . $user['licenseNo'] . '"></td>
                            </tr>
                            <tr>
                                <td>First Name: </td>
                                <td><input type="text" value="' . $user['firstName'] . '"></td>
                            </tr>
                            <tr>
                                <td>Last Name: </td>
                                <td><input type="text" value="' . $user['lastName'] . '"></td>
                            </tr>
                            <tr>
                                <td>Card Number: </td>
                                <td><input type="text" value="' . $cardNumber . '"></td>
                            </tr>
                            <tr>
                                <td>Expiry Month: </td>
                                <td><input type="text" value="' . $cardExpiryMonth . '"></td>
                            </tr>
                            <tr>
                                <td>Expiry Year: </td>
                                <td><input type="text" value="' . $cardExpiryYear . '"></td>
                            </tr>
                            <tr>
                                <td>CVV: </td>
                                <td><input type="text" value="' . $cardCVV . '"></td>
                            </tr>
                            <tr>
                                <td> 
                                    <input type="submit" id="save-account" class="save-account-button" value="Save Account">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>';
            }
        } else {
            echo 'Error fetching user data: ' . mysqli_error($conn);
        }
        mysqli_free_result($result); ?>
    </div>
</body>

</html>