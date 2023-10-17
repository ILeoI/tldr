<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");

foreach (array_keys($_POST) as $id) {
    print_r($_POST);
    $sql = "UPDATE Drives SET verified = '1' WHERE id = '$id';";
    echo $sql;
    try {
        mysqli_query($conn, $sql);
        echo "woo";
    } catch (mysqli_sql_exception) {
        echo "no";
    }
}

mysqli_close($conn);
// header("location: view-drives.php");
