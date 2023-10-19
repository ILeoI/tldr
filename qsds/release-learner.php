<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "supervisor");

$viewingID = "0";
if (isset($_GET["learnerID"])) {
    $viewingID = $_GET["learnerID"];
    if (!checkUserType($conn, "learner", $viewingID)) {
        header("location: supervisor-home-page.php");
        exit();
    }
} else {
    header("location: supervisor-home-page.php");
    exit();
}

$sql = "SELECT * FROM Users JOIN SupervisorLearners ON Users.id = SupervisorLearners.learnerID WHERE id = '$viewingID';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $sql = "DELETE FROM SupervisorLearners WHERE learnerID = '$viewingID';";
        try {
            mysqli_query($conn, $sql);
        header("location: supervisor-home-page.php?feedback=5");
        } catch (mysqli_sql_exception) {
            header("location: supervisor-home-page.php?feedback=0");
        }
        echo $sql;
    } else {
        header("location: supervisor-home-page.php?feedback=0");
    }
    mysqli_free_result($result);
}

mysqli_close($conn);
