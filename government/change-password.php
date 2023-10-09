<?php

require_once "../inc/db-session-include.php";
requireUserType($conn, "government");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST["userID"];
    $newPassword = $_POST["new-password"];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE Users SET password = '$hashedPassword' WHERE id = '$userID';";
    try {
        mysqli_query($conn, $sql);
        header("location: view-account.php?viewing='$userID'&feedback=0");
    } catch (mysqli_sql_exception) {
        header("location: view-account.php?viewing='$userID'&feedback=1");
    }
}
