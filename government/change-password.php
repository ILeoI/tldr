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
        exit();
    } catch (mysqli_sql_exception) {
        header("location: view-account.php?viewing='$userID'&feedback=1");
        exit();
    }

    print_r($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLDR: Change Password</title>
    <script src="../scripts/menu.js" defer></script>
    <link rel="stylesheet" href="../style/menu-style.css" />
</head>

<body>
    <?php require_once "government-menu.php" ?>

    <form action="change-password.php" method="post">
        <label for="new-password">New Password:</label>
        <input type="text" id="new-password" name="new-password">
        <br>
        <input type="submit">
    </form>
</body>

</html>