<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/dbconn.inc.php";

// starts the session
// if a user is not logged in, send them to the login page
session_start();
if (!isset($_SESSION["userID"])) {
    header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/login-page.php");
    exit();
}

function requireUserType(mysqli $conn, string $type)
{
    $sql = "SELECT learner, supervisor, instructor, government FROM Users WHERE id = '{$_SESSION["userID"]}';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (!isset($row[$type])) {
                header("location: " . $_SERVER['DOCUMENT_ROOT'] . "home-page.php");
            }
        }
    }
}
