<?php 

if (isset($_POST["add_drive"])) {
   require_once "inc/dbconn.inc.php"; 
   
    if ($_POST["time"] == "daytime"){
        $daytime = 1;
    } else {
        $daytime = 0;
    }

    $learnerID = 0;
    $driveDate = $_POST["dob"];
    $startTime = $_POST["start-time"];
    $endTime = $_POST["end-time"];
    $duration = 0; //create function to calculate drive time off start and finsih
    $fromLoc = filter_input(INPUT_POST, "start-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $toLoc = filter_input(INPUT_POST, "furthest-location", FILTER_SANITIZE_SPECIAL_CHARS);
    $conditionRoad = $_POST["road-type"];
    $conditionWeather = $_POST["weather"];
    $conditionTraffic = $_POST["traffic-density"];
    $daytime = 
    $supervisingDriverID =
    $verified =
    
    $sql = "INSERT INTO Drive() VALUES(?);";

    $statement = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($statement, $sql); 
    mysqli_stmt_bind_param($statement, 's', htmlspecialchars($_POST["add"])); 

    if (mysqli_stmt_execute($statement)) {
        header("location: drive.php");
    } else {
        echo "mysqli_error($conn)";
    }
    mysqli_close($conn);
}

?>
