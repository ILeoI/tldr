<?php
    require_once "db-session-include.php";

    $_SESSION["userID"] = null;
    header("location: index.php");
?>