<?php
require_once "inc/dbconn.inc.php";
?>

<div></div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="">
    <meta name="description" content="">
    <title>Sign Up</title>
    <link rel="stylesheet" href="Style/login.css" />
    <script src="scripts/sign-up.js" defer></script>
</head>

<body>
    <h1 class="page-title" id="signup-page-header">Signup Page</h1>
    <form id="signup-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <div class="input-field">
            <label for="email">E-mail</label> <br>
            <input type="email" placeholder="E-mail" id="email" name="email" required> <br>
        </div>
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
        <div class="input-field">
            <input type="radio" id="user-type-learner" name="user-type" value="learner">
            <label for="user-type-learner" id="learner-label">Learner</label>

            <input type="radio" id="user-type-qsd" name="user-type" value="supervisor">
            <label for="user-type-qsd" id="learner-label">QSD</label>

            <input type="radio" id="user-type-instructor" name="user-type" value="instructor">
            <label for="user-type-instructor" id="learner-label">Instructor</label> <br>
        </div>
        <input type="checkbox" onclick="togglePassword()" id="password-toggle" name="password-toggle">
        <label for="password-toggle">Show Password</label> <br>

        <input type="submit" value="Sign up">
    </form>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $firstName = filter_input(INPUT_POST, "first-name", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, "last-name", FILTER_SANITIZE_SPECIAL_CHARS);
    $dob = $_POST["dob"];
    $phoneNumber = filter_input(INPUT_POST, "phone-number", FILTER_SANITIZE_SPECIAL_CHARS);
    $licenseNumber = filter_input(INPUT_POST, "license-number", FILTER_SANITIZE_SPECIAL_CHARS);
    $userType = $_POST["user-type"];

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, $userType, licenseNo) 
            VALUES('$email', '$hash_password', '$phoneNumber', '$firstName', '$lastName', '$dob', 1, '$licenseNumber');";

    try {
        mysqli_query($conn, $sql);
        echo "acc created<br>";
        echo "<a href=\"login-page.php\">Login</a>";
    } catch (mysqli_sql_exception) {
        echo "<p style=\"color: red;\">This account already exists!<br><a href=\"forgot-password.php\" style=\"color: black; text-decoration: none;\">Forgot Password?</a></p>";
    }
}

?>