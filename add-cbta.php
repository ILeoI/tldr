<?php
require_once "inc/session-start.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: CBT&A</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $instructorID = $_SESSION["userID"];
        $driverID = $_SESSION["learnerID"];
        $taskNo = $_GET["task"];
        $sql = array();
        if ($taskNo == 1) {
            if (isChecked("cabin-drill-1")) {
                $sql[] = prepSQL($instructorID, $userID, "cabin-drill-1");
            }

            if (isChecked("cabin-drill-2")) {
                $sql[] = prepSQL($instructorID, $userID, "cabin-drill-2");
            }

            for ($i = 1; $i < 4; $i++) {
                $controlName = getPost("control-$i-name");
                if (isChecked("control-$i-1")) {
                    $sql[] = prepSQLWithValue($instructorID, $userID, "control-$i-1", $controlName);
                }
                if (isChecked("control-$i-2")) {
                    $sql[] = prepSQLWithValue($instructorID, $userID, "control-$i-2", $controlName);
                }
            }

            echo "<pre>";
            print_r($sql);
            echo "</pre>";
        } else if ($taskNo == 2) {
            $start = [isChecked("start-engine1"), isChecked("start-engine2")];
            $end = [isChecked("stop-engine1"), isChecked("stop-engine2")];
            echo "Start Engine: ";
            print_r($start);
            echo "<br>";
            echo "Stop Engine: ";
            print_r($end);
        } else if ($taskNo == 3) {
            $kerb = [isChecked("move-off-kerb1"), isChecked("move-off-kerb2")];
            echo "Kerb: ";
            print_r($kerb);
        } else if ($taskNo == 4) {
            $stop = [isChecked("stop-vehicle1"), isChecked("stop-vehicle2")];
            $secure = [isChecked("stop-roll1"), isChecked("stop-roll2")];
            echo "Stop vehicle: ";
            print_r($stop);
            echo "<br>";
            echo "Secure vehicle: ";
            print_r($secure);
        } else if ($taskNo == 5) {
            $stopgo = [isChecked("park-brake1"), isChecked("park-brake2")];
            echo "Stop & Go: ";
            print_r($stopgo);
        } else if ($taskNo == 6) {
            $changeGear = array();
            for ($i = 1; $i < 6; $i++) {
                $changeGear[] = isChecked("change-gear$i");
            }
            echo "Change Gears: ";
            print_r($changeGear);
            echo "<br>";
            $selectGear = array();
            for ($i = 1; $i < 6; $i++) {
                $selectGear[] = isChecked("select-valid-gear$i");
            }
            echo "Select Gears: ";
            print_r($selectGear);
        } else if ($taskNo == 7) {
            for ($i = 1; $i < 3; $i++) {
                $left = array();
                $right = array();
                for ($j = 1; $j < 5; $j++) {
                    $left[] = isChecked("steer-forward-left$i$j");
                    $right[] = isChecked("steer-forward-right$i$j");
                }

                echo "Left forward turns: ";
                print_r($left);
                echo "<br>";
                echo "Right forward turns: ";
                print_r($right);
                echo "<br>";

                $reverse = isChecked("steer-reverse-left$i");
                echo "Left reverse turn: ";
                echo "$reverse";
                echo "<br>";
                echo "<br>";
            }
        } else if ($taskNo == 8) {
        }

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }
    ?>
</body>

</html>

<?php
function isChecked($name)
{
    if (isset($_POST[$name])) {
        return 1;
    } else {
        return 0;
    }
}

function getPost($name)
{
    return $_POST[$name];
}

function prepSQLWithValue($instructorID, $userID, $assessmentName, $assessmentValue)
{
    return "INSERT INTO LogbookCBTA(instructorID, driverID, completeDate, assessmentItemName, completed, assessmentValue) VALUES('$instructorID', '$userID', now(), '$assessmentName', '1', '$assessmentValue');";
}

function prepSQL($instructorID, $userID, $assessmentName)
{
    return "INSERT INTO LogbookCBTA(instructorID, driverID, completeDate, assessmentItemName, completed) VALUES('$instructorID', '$userID', now(), '$assessmentName', '1');";
}
?>