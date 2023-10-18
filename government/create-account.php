<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "government");

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/home-page.css" />
    <link rel="stylesheet" href="../style/MainForm.css" />
    <title>TLDR: Create Account</title>
</head>

<body>
    <?php
    require_once "government-menu.php";
    ?>
    <div>
        <br>
        <form action="create-account.php" method="post">
            <label for="email-input">Email:</label>
            <input type="text" name="email-input" id="email-input" placeholder="Email" required>
            <br>
            <label for="temp-password">Temporary Password:</label>
            <input type="text" name="temp-password" id="temp-password" placeholder="Temporary Password" required>
            <br>
            <label>User Type</label>
            <div>
                <div class="radio-option">
                    <input type="radio" class="inline-radio" name="user-type" id="learner-type" value="learner" required>
                    <label for="learner-type" class="inline-label">Learner</label>
                </div>
                <div class="radio-option">
                    <input type="radio" class="inline-radio" name="user-type" id="qsd-type" value="supervisor" required>
                    <label for="qsd-type" class="inline-label">Qualified Supervisor</label>
                </div>
                <div class="radio-option">
                    <input type="radio" class="inline-radio" name="user-type" id="instructor-type" value="instructor" required>
                    <label for="instructor-type" class="inline-label">Instructor</label>
                </div>
            </div>
            <br>
            <input type="submit">
        </form>
    </div>
</body>

</html>