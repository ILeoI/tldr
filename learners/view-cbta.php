<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: View CBT&A</title>
    <link rel="stylesheet" href="../style/view-cbta.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
</head>

<?php 
require_once "learner-menu.php";

$db_result = array();
$value_result = array();
$sql = "SELECT assessmentItemName, assessmentValue FROM LogbookCBTA WHERE completed = '1' AND driverID = '" . $_SESSION["userID"] . "';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["assessmentValue"] != NULL) {
                $value_result[$row["assessmentItemName"]] = $row["assessmentValue"];
            }
            $db_result[] = $row["assessmentItemName"];
        }
    }
}
mysqli_free_result($result);

?>

<body>

    <?php
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

    ?>

    <div class="whitebox">
        <h1></h1>
    </div>

    <div class="task1">
        <h4>Task 1</h4>
        <label for="cabin-drill">Cabin drill:</label>
        <input type="checkbox" name="cabin-drill-1" id="cabin-drill-1" <?php echo (in_array("cabin-drill-1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="cabin-drill-2" id="cabin-drill-2" <?php echo (in_array("cabin-drill-2", $db_result) ? "checked" : "") ?> disabled>
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
        <input type="checkbox" name="control-1-1" id="control-1-1" <?php echo (in_array("control-1-1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="control-1-2" id="control-1-2" <?php echo (in_array("control-1-2", $db_result) ? "checked" : "") ?> disabled>
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
        <input type="checkbox" name="control-2-1" id="control-2-1" <?php echo (in_array("control-2-1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="control-2-2" id="control-2-2" <?php echo (in_array("control-2-2", $db_result) ? "checked" : "") ?> disabled>
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
        <input type="checkbox" name="control-3-1" id="control-3-1" <?php echo (in_array("control-3-1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="control-3-2" id="control-3-2" <?php echo (in_array("control-3-2", $db_result) ? "checked" : "") ?> disabled>
        <br>
    </div>

    <div class="task2">
        <h4>Task 2</h4>
        <label>Starting the engine:</label>
        <input type="checkbox" name="start-engine1" <?php echo (in_array("start-engine1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="start-engine2" <?php echo (in_array("start-engine2", $db_result) ? "checked" : "") ?> disabled>
        <br>

        <label>Stopping the engine:</label>
        <input type="checkbox" name="stop-engine1" <?php echo (in_array("stop-engine1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="stop-engine2" <?php echo (in_array("stop-engine2", $db_result) ? "checked" : "") ?> disabled>
        <br>

    </div>

    <div class="task3">
        <h4>Task 3</h4>

        <label>Move off from the kerb:</label>
        <input type="checkbox" name="move-off-kerb1" <?php echo (in_array("move-off-kerb1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="move-off-kerb2" <?php echo (in_array("move-off-kerb2", $db_result) ? "checked" : "") ?> disabled>
        <br>

    </div>

    <div class="task4">
        <h4>Task 4</h4>
        <label>Stop the vehicle <i>(include slowing)</i>:</label>
        <input type="checkbox" name="stop-vehicle1" <?php echo (in_array("stop-vehicle1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="stop-vehicle2" <?php echo (in_array("stop-vehicle2", $db_result) ? "checked" : "") ?> disabled>
        <br>

        <label>Secure the vehicle to prevent rolling <i>(a prolonged stop)</i>:</label>
        <input type="checkbox" name="stop-roll1" <?php echo (in_array("stop-roll1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="stop-roll2" <?php echo (in_array("stop-roll2", $db_result) ? "checked" : "") ?> disabled>
        <br>
    </div>

    <div class="task5">
        <h4>Task 5</h4>
        <label>Stop and go <i>(using the park brake)</i>:</label>
        <input type="checkbox" name="park-brake1" <?php echo (in_array("park-brake1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="park-brake2" <?php echo (in_array("park-brake2", $db_result) ? "checked" : "") ?> disabled>
        <br>

    </div>

    <div class="task6">
        <h4>Task 6</h4>
        <label>(1) Change gears up and down <i>(100% accurate and a minimum of 5
                demonstrations)</i></label>
        <br>
        <input type="checkbox" name="change-gear1" <?php echo (in_array("change-gear1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="change-gear2" <?php echo (in_array("change-gear2", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="change-gear3" <?php echo (in_array("change-gear3", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="change-gear4" <?php echo (in_array("change-gear4", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="change-gear5" <?php echo (in_array("change-gear5", $db_result) ? "checked" : "") ?> disabled>
        <br>
        <label>
            (2) Accurately select appropriate gears for varying speeds <i>(100% accuracy and a
                minimum of 5 demonstrations)</i></label>
        <br>
        <input type="checkbox" name="select-valid-gear1" <?php echo (in_array("select-valid-gear1", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="select-valid-gear2" <?php echo (in_array("select-valid-gear2", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="select-valid-gear3" <?php echo (in_array("select-valid-gear3", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="select-valid-gear4" <?php echo (in_array("select-valid-gear4", $db_result) ? "checked" : "") ?> disabled>
        <input type="checkbox" name="select-valid-gear5" <?php echo (in_array("select-valid-gear5", $db_result) ? "checked" : "") ?> disabled>
        <br>

    </div>

    <div class="task7">
        <h4>Task 7</h4>
        <h5>Demonstration 1</h5>
        <label>(1) Steer in a forward direction <i>(minimum of 4 left and 4 right turns)</i></label>
        <ul>
            <li>
                <label>100% <i>(left)</i></label>
                <input type="checkbox" name="steer-forward-left11" <?php echo (in_array("steer-forward-left11", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-left12" <?php echo (in_array("steer-forward-left12", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-left13" <?php echo (in_array("steer-forward-left13", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-left14" <?php echo (in_array("steer-forward-left14", $db_result) ? "checked" : "") ?> disabled>
            </li>
            <li>
                <label>100% <i>(right)</i></label>
                <input type="checkbox" name="steer-forward-right11" <?php echo (in_array("steer-forward-right11", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-right12" <?php echo (in_array("steer-forward-right12", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-right13" <?php echo (in_array("steer-forward-right13", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-right14" <?php echo (in_array("steer-forward-right14", $db_result) ? "checked" : "") ?> disabled>
            </li>
        </ul>
        <label>(2) Steer in reverse <i>(minimum of 1 left reverse)</i></label>
        <ul>
            <li>
                <label>100% <i>(left reverse)</i></label>
                <input type="checkbox" name="steer-reverse-left1" <?php echo (in_array("steer-reverse-left1", $db_result) ? "checked" : "") ?> disabled>
            </li>
        </ul>
        <h5>Demonstration 2</h5>
        <label>(1) Steer in a forward direction <i>(minimum of 4 left and 4 right turns)</i></label>
        <ul>
            <li>
                <label>100% <i>(left)</i></label>
                <input type="checkbox" name="steer-forward-left21" <?php echo (in_array("steer-forward-left21", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-left22" <?php echo (in_array("steer-forward-left22", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-left23" <?php echo (in_array("steer-forward-left23", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-left24" <?php echo (in_array("steer-forward-left24", $db_result) ? "checked" : "") ?> disabled>
            </li>
            <li>
                <label>100% <i>(right)</i></label>
                <input type="checkbox" name="steer-forward-right21" <?php echo (in_array("steer-forward-right21", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-right22" <?php echo (in_array("steer-forward-right22", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-right23" <?php echo (in_array("steer-forward-right23", $db_result) ? "checked" : "") ?> disabled>
                <input type="checkbox" name="steer-forward-right24" <?php echo (in_array("steer-forward-right24", $db_result) ? "checked" : "") ?> disabled>
            </li>
        </ul>
        <label>(2) Steer in reverse <i>(minimum of 1 left reverse)</i></label>
        <ul>
            <li>
                <label>100% <i>(left reverse)</i></label>
                <input type="checkbox" name="steer-reverse-left2" <?php echo (in_array("steer-reverse-left2", $db_result) ? "checked" : "") ?> disabled>
            </li>
        </ul>
        <br>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>