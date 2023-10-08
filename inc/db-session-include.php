<?php
require_once "dbconn.inc.php";

// starts the session
// if a user is not logged in, send them to the login page
session_start();
if (!isset($_SESSION["userID"])) {
    header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/login-page.php");
    exit();
}

function requireUserType(mysqli $conn, string $type)
{
    $sql = "SELECT $type FROM Users WHERE id = '{$_SESSION["userID"]}';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            print_r($row);

            if ($row[$type] == 0) {
                echo "../home-page.php";
                header("location: ../home-page.php");
                exit();
            }
        }
    }
}
