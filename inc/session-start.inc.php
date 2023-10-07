<?php
    // starts the session
    // if a user is not logged in, send them to the login page
    session_start();
    if(!isset($_SESSION["userID"])) {
        header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/login-page.php");
    }
?>