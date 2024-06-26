<?php
// Includes database connection info and session info
require_once "../inc/db-session-include.php";
// Checks to see if logged in user is government
// Sends to their respective login page if not
requireUserType($conn, "government");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../scripts/menu.js" defer></script>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <title>TLDR: Government Home Page</title>
</head>

<body>
    
    <!-- Load the government menu -->
    <?php require_once "government-menu.php"; ?>
    <p>
        Welcome to the TLDR system
    </p>
</body>

</html>