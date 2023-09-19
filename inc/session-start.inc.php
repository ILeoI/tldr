<?php
    session_start();
    if(!isset($_SESSION["userID"])) {
        header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/login-page.php");
    }
?>