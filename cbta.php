<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: CBT&A</title>
    <script src="scripts/cbta.js" defer></script>
    <link rel="stylesheet" href="style/cbta.css" />
</head>

<body>
    <label>Task:</label>
    <select name="task-selector" id="task-selector" onchange="changeTasks()">
        <option value="1">Task 1</option>
        <option value="2">Task 2</option>
        <option value="3">Task 3</option>
        <option value="4">Task 4</option>
        <option value="5">Task 5</option>
        <option value="6">Task 6</option>
        <option value="7">Task 7</option>
        <option value="8">Task 8</option>
    </select>

    <form id="task1" name="task1" class="hidden" action="add-cbta.php?task=1" method="POST">
        <label for="cabin-drill">Cabin drill:</label>
        <input type="checkbox" name="cabin-drill-1" id="cabin-drill-1">
        <input type="checkbox" name="cabin-drill-2" id="cabin-drill-2">
        <br>
        <label>Controls <i>(selected from the respective groups)</i></label><br>

        <label for="control-1-name">Control 1:</label>
        <select name="control-1-name" id="control-1-name">
            <option value="Brake">Brake</option>
            <option value="Accelerator">Accelerator</option>
            <option value="Steering wheel">Steering wheel</option>
            <option value="Gear level">Gear lever</option>
        </select>
        <input type="checkbox" name="control-1-1" id="control-1-1">
        <input type="checkbox" name="control-1-2" id="control-1-2">
        <br>

        <label for="control-2-name">Control 2:</label>
        <select name="control-2-name" id="control-2-name">
            <option value="Clutch">Clutch</option>
            <option value="Accelerator">Park brake</option>
            <option value="Steering wheel">Warning device</option>
            <option value="Gear level">Signals</option>
        </select>
        <input type="checkbox" name="control-2-1" id="control-2-1">
        <input type="checkbox" name="control-2-2" id="control-2-2">
        <br>

        <label for="control-3-name">Control 3:</label>
        <select name="control-3-name" id="control-3-name">
            <option value="Heater/demister">Heater/demister</option>
            <option value="Wipers and washers">Wipers and washers</option>
            <option value="Warning lights">Warning lights</option>
            <option value="Vehicle lights">Vehicle lights</option>
            <option value="Gauges">Gauges</option>
        </select>
        <input type="checkbox" name="control-3-1" id="control-3-1">
        <input type="checkbox" name="control-3-2" id="control-3-2">
        <br>

        <input type="submit" value="Save">
    </form>

    <form id="task2" name="task2" class="hidden">
        <label>Starting the engine:</label>
        <input type="checkbox" name="start-engine1">
        <input type="checkbox" name="start-engine2">
        <br>

        <label>Stopping the engine:</label>
        <input type="checkbox" name="stop-engine1">
        <input type="checkbox" name="stop-engine2">
        <br>

        <input type="submit" value="Save">
    </form>

    <form id="task3" name="task3" class="hidden">
        <label>Move off from the kerb:</label>
        <input type="checkbox" name="move-off-kerb1">
        <input type="checkbox" name="move-off-kerb2">
        <br>

        <input type="submit" value="Save">
    </form>

    <form name="task4" id="task4" class="hidden">
        <label>Stop the vehicle <i>(include slowing)</i>:</label>
        <input type="checkbox" name="stop-vehicle1">
        <input type="checkbox" name="stop-vehicle2">
        <br>

        <label>Secure the vehicle to prevent rolling <i>(a prolonged stop)</i>:</label>
        <input type="checkbox" name="stop-roll1">
        <input type="checkbox" name="stop-roll2">
        <br>

        <input type="submit" value="Save">
    </form>

    <form name="task5" id="task5" class="hidden">
        <label>Stop and go <i>(using the park brake)</i>:</label>
        <input type="checkbox" name="park-brake1">
        <input type="checkbox" name="park-brake2">
        <br>

        <input type="submit" value="Save">
    </form>

    <form name="task6" id="task6" class="hidden">
        <label>(1) Change gears up and down <i>(100% accurate and a minimum of 5
                demonstrations)</i></label>
        <br>
        <input type="checkbox" name="change-gear1">
        <input type="checkbox" name="change-gear2">
        <input type="checkbox" name="change-gear3">
        <input type="checkbox" name="change-gear4">
        <input type="checkbox" name="change-gear5">
        <br>
        <label>
            (2) Accurately select appropriate gears for varying speeds <i>(100% accuracy and a
                minimum of 5 demonstrations)</i></label>
        <br>
        <input type="checkbox" name="select-valid-gear1">
        <input type="checkbox" name="select-valid-gear2">
        <input type="checkbox" name="select-valid-gear3">
        <input type="checkbox" name="select-valid-gear4">
        <input type="checkbox" name="select-valid-gear5">
        <br>

        <input type="submit" value="Save">
    </form>

    <form name="task7" id="task7" class="hidden">
        <h4>Demonstration 1</h4>
        <label>(1) Steer in a forward direction <i>(minimum of 4 left and 4 right turns)</i></label>
        <ul>
            <li>
                <label>100% <i>(left)</i></label>
                <input type="checkbox" name="steer-forward-left11">
                <input type="checkbox" name="steer-forward-left12">
                <input type="checkbox" name="steer-forward-left13">
                <input type="checkbox" name="steer-forward-left14">
            </li>
            <li>
                <label>100% <i>(right)</i></label>
                <input type="checkbox" name="steer-forward-right11">
                <input type="checkbox" name="steer-forward-right12">
                <input type="checkbox" name="steer-forward-right13">
                <input type="checkbox" name="steer-forward-right14">
            </li>
        </ul>
        <label>(2) Steer in reverse <i>(minimum of 1 left reverse)</i></label>
        <ul>
            <li>
                <label>100% <i>(left reverse)</i></label>
                <input type="checkbox" name="steer-reverse-left1">
            </li>
        </ul>
        <h4>Demonstration 2</h4>
        <label>(1) Steer in a forward direction <i>(minimum of 4 left and 4 right turns)</i></label>
        <ul>
            <li>
                <label>100% <i>(left)</i></label>
                <input type="checkbox" name="steer-forward-left21">
                <input type="checkbox" name="steer-forward-left22">
                <input type="checkbox" name="steer-forward-left23">
                <input type="checkbox" name="steer-forward-left24">
            </li>
            <li>
                <label>100% <i>(right)</i></label>
                <input type="checkbox" name="steer-forward-right21">
                <input type="checkbox" name="steer-forward-right22">
                <input type="checkbox" name="steer-forward-right23">
                <input type="checkbox" name="steer-forward-right24">
            </li>
        </ul>
        <label>(2) Steer in reverse <i>(minimum of 1 left reverse)</i></label>
        <ul>
            <li>
                <label>100% <i>(left reverse)</i></label>
                <input type="checkbox" name="steer-reverse-left2">
            </li>
        </ul>
        <br>

        <input type="submit" value="Save">
    </form>

    <form name="task8" id="task8" class="hidden">

    </form>
</body>

</html>