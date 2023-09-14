<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $instructorID = $_SESSION["userID"];
    if (isset($_SESSION["learnerID"])) {
        $driverID = $_SESSION["learnerID"];
    } else {
        header("location: instructors/cbta.php");
    }
    $taskNo = $_GET["task"];
    $sql = array();
    if ($taskNo == 1) {
        if (isChecked("cabin-drill-1")) {
            $sql[] = prepSQL($instructorID, $driverID, "cabin-drill-1");
        }

        if (isChecked("cabin-drill-2")) {
            $sql[] = prepSQL($instructorID, $driverID, "cabin-drill-2");
        }

        for ($i = 1; $i < 4; $i++) {
            $controlName = getPost("control-$i-name");
            if (isChecked("control-$i-1")) {
                $sql[] = prepSQLWithValue($instructorID, $driverID, "control-$i-1", $controlName);
            }
            if (isChecked("control-$i-2")) {
                $sql[] = prepSQLWithValue($instructorID, $driverID, "control-$i-2", $controlName);
            }
        }

        foreach ($sql as $line) {
            try {
                mysqli_query($conn, $line);
                header("location: cbta.php?learnerID=$driverID");
            } catch (mysqli_sql_exception) {
                echo "nice try buddy";
            }
        }
    } else if ($taskNo == 2) {
        if (isChecked("start-engine1")) {
            $sql[] = prepSQL($instructorID, $driverID, "start-engine1");
        }

        if (isChecked("start-engine2")) {
            $sql[] = prepSQL($instructorID, $driverID, "start-engine2");
        }

        if (isChecked("stop-engine1")) {
            $sql[] = prepSQL($instructorID, $driverID, "stop-engine1");
        }

        if (isChecked("stop-engine2")) {
            $sql[] = prepSQL($instructorID, $driverID, "stop-engine2");
        }

        foreach ($sql as $line) {
            try {
                mysqli_query($conn, $line);
                header("location: cbta.php?learnerID=$driverID");
            } catch (mysqli_sql_exception) {
            }
        }
    } else if ($taskNo == 3) {
        if (isChecked("move-off-kerb1")) {
            $sql[] = prepSQL($instructorID, $driverID, "move-off-kerb1");
        }
        if (isChecked("move-off-kerb2")) {
            $sql[] = prepSQL($instructorID, $driverID, "move-off-kerb2");
        }

        foreach ($sql as $line) {
            try {
                mysqli_query($conn, $line);
                header("location: cbta.php?learnerID=$driverID");
            } catch (mysqli_sql_exception) {
            }
        }
    } else if ($taskNo == 4) {
        if (isChecked("stop-vehicle1")) {
            $sql[] = prepSQL($instructorID, $driverID, "stop-vehicle1");
        }
        if (isChecked("stop-vehicle2")) {
            $sql[] = prepSQL($instructorID, $driverID, "stop-vehicle2");
        }
        if (isChecked("stop-roll1")) {
            $sql[] = prepSQL($instructorID, $driverID, "stop-roll1");
        }
        if (isChecked("stop-roll2")) {
            $sql[] = prepSQL($instructorID, $driverID, "stop-roll2");
        }

        foreach ($sql as $line) {
            try {
                mysqli_query($conn, $line);
                header("location: cbta.php?learnerID=$driverID");
            } catch (mysqli_sql_exception) {
            }
        }
    } else if ($taskNo == 5) {
        if (isChecked("park-brake1")) {
            $sql[] = prepSQL($instructorID, $driverID, "park-brake1");
        }
        if (isChecked("park-brake2")) {
            $sql[] = prepSQL($instructorID, $driverID, "park-brake2");
        }

        foreach ($sql as $line) {
            try {
                mysqli_query($conn, $line);
                header("location: cbta.php?learnerID=$driverID");
            } catch (mysqli_sql_exception) {
            }
        }
    } else if ($taskNo == 6) {
        for ($i = 1; $i < 6; $i++) {
            if (isChecked("change-gear$i")) {
                $sql[] = prepSQL($instructorID, $driverID, "change-gear$i");
            }
        }

        for ($i = 1; $i < 6; $i++) {
            if (isChecked("select-valid-gear$i")) {
                $sql[] = prepSQL($instructorID, $driverID, "select-valid-gear$i");
            }
        }

        foreach ($sql as $line) {
            try {
                mysqli_query($conn, $line);
                header("location: cbta.php?learnerID=$driverID");
            } catch (mysqli_sql_exception) {
            }
        }
    } else if ($taskNo == 7) {
        for ($i = 1; $i < 3; $i++) {
            for ($j = 1; $j < 5; $j++) {
                if (isChecked("steer-forward-left$i$j")) {
                    $sql[] = prepSQL($instructorID, $driverID, "steer-forward-left$i$j");
                }
            }

            for ($j = 1; $j < 5; $j++) {
                if (isChecked("steer-forward-right$i$j")) {
                    $sql[] = prepSQL($instructorID, $driverID, "steer-forward-right$i$j");
                }
            }


            if (isChecked("steer-reverse-left$i")) {
                $sql[] = prepSQL($instructorID, $driverID, "steer-reverse-left$i");
            }
        }

        foreach ($sql as $line) {
            try {
                mysqli_query($conn, $line);
                header("location: cbta.php?learnerID=$driverID");
            } catch (mysqli_sql_exception) {
            }
        }
    } else if ($taskNo == 8) {
    }

}

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
    if (isset($_POST[$name])) {
        return $_POST[$name];
    } else {
        return 0;
    }
}

function prepSQLWithValue($instructorID, $userID, $assessmentName, $assessmentValue)
{
    return "INSERT INTO LogbookCBTA(instructorID, driverID, completeDate, assessmentItemName, completed, assessmentValue) VALUES('$instructorID', '$userID', now(), '$assessmentName', '1', '$assessmentValue');";
}

function prepSQL($instructorID, $userID, $assessmentName)
{
    return "INSERT INTO LogbookCBTA(instructorID, driverID, completeDate, assessmentItemName, completed) VALUES('$instructorID', '$userID', now(), '$assessmentName', '1');";
}
