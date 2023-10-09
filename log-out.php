<?php
    require_once "inc/db-session-include.php";

    $_SESSION["userID"] = null;
    header("location: index.php");
    exit();
?>