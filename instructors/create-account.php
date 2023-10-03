<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/menu-style.css" />
    <title>TLDR: Create Account</title>
</head>

<body>
    <?php
    require_once "instructor-menu.php";
    ?>
    <div>
        <h1>Create An Account For Someone</h1>
        <form action="create-account.php" method="post">
            <label for="email-input">Email:</label>
            <input type="text" name="email-input" id="email-input">
            <br>
            <label for="temp-password">Temporary Password:</label>
            <input type="text" name="temp-password" id="temp-password">
            <br>
            <label>User type:</label>
            <label for="learner-type">Learner</label>
            <input type="radio" name="user-type" id="learner-type" value="learner">
            <label for="qsd-type">Qualified Supervisor</label>
            <input type="radio" name="user-type" id="qsd-type" value="supervisor">
            <br>
            <input type="submit">
        </form>
    </div>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email-input"];
    $tempPassword = $_POST["temp-password"];

    $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);

    $userType = $_POST["user-type"];

    $sql = "INSERT INTO Users(email, password, $userType, hasTempPassword) VALUES('$email', '$hashedPassword', '1', '1');";
    try {
        mysqli_query($conn, $sql);
        echo "Successfully created account!";
    } catch (mysqli_sql_exception) {
        echo "Failed to create account.";
    }
}

?>