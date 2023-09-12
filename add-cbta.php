<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: CBT&A</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $taskNo = $_GET["task"];
        echo "Task: $taskNo";
        echo "<br>";
        if ($taskNo == 1) {
            $cabinDrill = [isChecked("cabin-drill-1"), isChecked("cabin-drill-2")];
            echo "Cabin Drill: ";
            print_r($cabinDrill);
            echo "<br>";
            $controlInputs = [[]];
            for ($i = 1; $i < 4; $i++) {
                $controlName = getPost("control-$i-name");
                $controlInput = [isChecked("control-$i-1"), isChecked("control-$i-2")];
                echo "$controlName: ";
                print_r($controlInput);
                echo "<br>";
            }
        } else if ($taskNo == 2) {
            $start = [isChecked("start-engine1"), isChecked("start-engine2")];
            $end = [isChecked("stop-engine1"), isChecked("stop-engine2")];
            echo "Start Engine: ";
            print_r($start);
            echo "<br>";
            echo "End Engine: ";
            print_r($end);

        } else if ($taskNo == 3) {

        } else if ($taskNo == 4) {

        } else if ($taskNo == 5) {

        } else if ($taskNo == 6) {

        } else if ($taskNo == 7) {

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

    function getPost($name) {
        return $_POST[$name];
    }
?>