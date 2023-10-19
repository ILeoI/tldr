<?php

require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");

$driveID = "0";
if (isset($_GET["driveID"])) {
    $driveID = $_GET["driveID"];
    $sql = "SELECT 1 FROM Users JOIN Drives ON Users.licenceNo = Drives.learnerLicenceNo WHERE Drives.id = '$driveID' AND Users.id = '" . getID() . "';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $sql = "DELETE FROM Drives WHERE id = '$driveID';";
            try {
                mysqli_query($conn, $sql);
            } catch (mysqli_sql_exception) {
            }
            header("location: view-drives.php");
            exit();
        } else {
            header("location: view-drives.php");
            exit();
        }
    }
} else {
    header("location: view-drives.php");
    exit();
}
