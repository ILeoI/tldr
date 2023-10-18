<?php
require_once "inc/db-session-include.php";

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

<div></div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/signup.css" />
    <script src="scripts/sign-up.js" defer></script>
    <title>TLDR: Complete Account</title>
</head>

<body>
    <h1 class="page-title" id="signup-page-header">Complete Account</h1>
    <form action="complete-account.php" method="POST">
    <div class="input-fields">
            <table>
                <tr>
                    <td>
                        <label for="password">Password</label> <br>
                        <input type="password" class="sign-up-input" placeholder="Password" id="password" name="password" minlength="8" required> <br>
                    </td>
                    <td>
                        <label for="confirm-password">Confirm Password</label> <br>
                        <input type="password" class="sign-up-input" placeholder="Confirm Password" id="confirm-password" name="confirm-password" minlength="8" required> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="first-name">First Name</label> <br>
                        <input type="text" class="sign-up-input" id="first-name" name="first-name" required placeholder="First Name"> <br>
                    </td>
                    <td>
                        <label for="last-name">Last Name</label> <br>
                        <input type="text" class="sign-up-input" id="last-name" name="last-name" required placeholder="Last Name"> <br>

                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="dob">Date of birth</label> <br>
                        <input type="date" class="sign-up-input" id="dob" name="dob" required> <br>

                    </td>
                    <td>
                        <label for="license-number">License Number</label> <br>
                        <input type="text" class="sign-up-input" id="license-number" name="license-number" required placeholder="License Number"> <br>
                    </td>
                </tr>
            </table>
        </div>
        <div class="submit-div">
            <input type="checkbox" onclick="togglePassword()" id="password-toggle" name="password-toggle">
            <label for="password-toggle">Show Password</label>

            <input type="submit" class="sign-up-submit" value="Sign Up">
        </div>
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

    $sql = "UPDATE Users 
            SET password = '$hashedPassword', 
            firstName ='$firstName', 
            lastName = '$lastName', 
            dob = '$dob', 
            phoneNumber = '$phoneNumber', 
            licenseNo = '$licenseNumber', 
            hasTempPassword='0' 
            WHERE id = {$_SESSION["userID"]}";

    echo $sql;

    try {
        mysqli_query($conn, $sql);
        header("location: home-page.php");
    } catch (mysqli_sql_exception $e) {
        header("location: home-page.php");
    }
}

mysqli_close($conn);

?>