<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");

foreach (array_keys($_POST) as $id) {
    $sql = "UPDATE Drives SET verified = '1' WHERE id = '$id';";
    try {
        mysqli_query($conn, $sql);
    } catch (mysqli_sql_exception) {
    }
}

mysqli_close($conn);
header("location: view-drives.php");
