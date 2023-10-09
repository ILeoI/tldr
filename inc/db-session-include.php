<?php
require_once "dbconn.inc.php";

// starts the session
// if a user is not logged in, send them to the login page
session_start();
if (!isset($_SESSION["userID"])) {
    header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/login-page.php");
    exit();
} else if ($_SESSION["userID"] == null) {
    header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/login-page.php");
    exit();
}

function requireUserType(mysqli $conn, string $type)
{
    if (!checkUserType($conn, $type, $_SESSION["userID"])) {
        header("location: ../home-page.php");
        exit();
    }
}

function checkUserType(mysqli $conn, string $type, string $id)
{
    if ($type == "qsd")
        $type = "supervisor";
    $sql = "SELECT $type FROM Users WHERE id = '$id';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row[$type] == 1) {
                return true;
            }
        }
    }

    return false;
}
