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
    <link rel="stylesheet" href="style/signup.css" />
    <script src="scripts/sign-up.js" defer></script>
</head>

<body>
    <h1 class="page-title" id="signup-page-header">Signup Page</h1>
    <form id="signup-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <div class="input-fields">
            <table>
                <tr>
                    <td>
                        <label for="email">E-mail</label> <br>
                        <input type="email" class="sign-up-input" placeholder="E-mail" id="email" name="email" required> <br>
                    </td>
                    <td>
                        <label for="phone-number">Phone Number</label> <br>
                        <input type="text" class="sign-up-input" id="phone-number" name="phone-number" minlength="10" required placeholder="Phone Number"> <br>
                    </td>
                </tr>
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
                        <label for="licence-number">Licence Number</label> <br>
                        <input type="text" class="sign-up-input" id="licence-number" name="licence-number" required placeholder="Licence Number"> <br>
                    </td>
                </tr>
                <tr>
                    <td colspan=2 style="text-align: center">
                        Choose A Role
                    </td>
                </tr>
                <tr>
                    <td class="radio-input">
                        <input type="radio" id="user-type-learner" name="user-type" value="learner">
                        <label for="user-type-learner" id="learner-label">Learner Driver</label>
                    </td>
                    <td class="radio-input">
                        <input type="radio" id="user-type-qsd" name="user-type" value="supervisor">
                        <label for="user-type-qsd" id="learner-label">Supervising Driver</label>
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
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $firstName = filter_input(INPUT_POST, "first-name", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, "last-name", FILTER_SANITIZE_SPECIAL_CHARS);
    $dob = $_POST["dob"];
    $phoneNumber = filter_input(INPUT_POST, "phone-number", FILTER_SANITIZE_SPECIAL_CHARS);
    $licenceNumber = filter_input(INPUT_POST, "licence-number", FILTER_SANITIZE_SPECIAL_CHARS);
    $userType = $_POST["user-type"];

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users(email, password, phoneNumber, firstName, lastName, dob, $userType, licenceNo) 
            VALUES('$email', '$hash_password', '$phoneNumber', '$firstName', '$lastName', '$dob', 1, '$licenceNumber');";

    try {
        mysqli_query($conn, $sql);
        echo "acc created<br>";
        $sql = "SELECT id FROM Users WHERE email = '$email';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $id = mysqli_fetch_assoc($result)["id"];
                $sql = "INSERT INTO PaymentDetails(userID) VALUES('$id');";
                mysqli_query($conn, $sql);
            }
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        echo "<a href=\"login-page.php\">Login</a>";
    } catch (mysqli_sql_exception) {
        echo "<p style=\"color: red;\">This account already exists!<br><a href=\"forgot-password.php\" style=\"color: black; text-decoration: none;\">Forgot Password?</a></p>";
    }
}

?>