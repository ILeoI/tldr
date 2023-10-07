<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";

foreach (array_keys($_POST) as $id) {
    $sql = "UPDATE Drives SET verified = '1' WHERE id = '$id';";
    try {
        mysqli_query($conn, $sql);
    } catch (mysqli_sql_exception) {
        echo "no";
    }
}

header("location: view-drives.php");

?>