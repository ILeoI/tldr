<?php
require_once "inc/dbconn.inc.php";
require_once "inc/session-start.inc.php";

$sql = "SELECT hasTempPassword FROM Users WHERE id = {$_SESSION["userID"]};";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["hasTempPassword"] != 1) {
            header("location: home-page.php");
        }
    }
    mysqli_free_result($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLDR: Complete Account</title>
</head>

<body>
    <h1>Complete Account</h1>
    <form action="complete-account.php" method="POST">
        <div class="input-field">
            <label for="password">Password</label> <br>
            <input type="password" placeholder="Password" id="password" name="password" minlength="8" required> <br>
        </div>
        <div class="input-field">
            <label for="confirm-password">Confirm Password</label> <br>
            <input type="password" placeholder="Confirm Password" id="confirm-password" name="confirm-password" minlength="8" required> <br>
        </div>
        <div class="input-field">
            <label for="first-name">First Name</label>
            <br>
            <input type="text" id="first-name" name="first-name" required placeholder="First Name">
        </div>
        <div class="input-field">
            <label for="last-name">Last Name</label>
            <br>
            <input type="text" id="last-name" name="last-name" required placeholder="Last Name">
        </div>
        <div class="input-field">
            <label for="dob">Date of birth</label>
            <br>
            <input type="date" id="dob" name="dob" required>
        </div>
        <div class="input-field">
            <label for="phone-number">Phone Number</label>
            <br>
            <input type="text" id="phone-number" name="phone-number" minlength="10" required placeholder="Phone Number">
        </div>

        <div class="input-field">
            <label for="license-number">License Number</label>
            <br>
            <input type="text" id="license-number" name="license-number" required placeholder="License Number">
        </div>

        <input type="submit">
    </form>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $firstName = filter_input(INPUT_POST, "first-name", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, "last-name", FILTER_SANITIZE_SPECIAL_CHARS);
    $dob = $_POST["dob"];
    $phoneNumber = filter_input(INPUT_POST, "phone-number", FILTER_SANITIZE_SPECIAL_CHARS);
    $licenseNumber = filter_input(INPUT_POST, "license-number", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "UPDATE User SET password = '$hashedPassword', firstName ='$firstName', lastName = '$lastName', dob = '$dob', phoneNumber = '$phoneNumber', licenseNo = '$licenseNumber', hasTempPassword='0' WHERE id = {$_SESSION["userID"]}";

    try {
        mysqli_query($conn, $sql);
        header("location: home-page.php");
    } catch (mysqli_sql_exception) {
    }
}

mysqli_close($conn);

?>