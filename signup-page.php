<?php
require_once "inc/dbconn.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="">
    <meta name="description" content="">
    <title>Signup</title>
    <link rel="stylesheet" href="Style/login.css" />
    <script src="scripts/sign-up.js" defer></script>
</head>

<body>
    <h1 class="page-title" id="signup-page-header">Signup Page</h1>
    <form id="signup-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <label for="email">E-mail</label> <br>
        <input type="email" placeholder="E-mail" id="email" name="email" required> <br>

        <label for="password">Password</label> <br>
        <input type="password" placeholder="Password" id="password" name="password" minlength="8" required> <br>

        <label for="confirm-password">Confirm Password</label> <br>
        <input type="password" placeholder="Confirm Password" id="confirm-password" name="confirm-password" minlength="8" required> <br>
       
        <input type="radio" id="user-type-learner" name="user-type" value="Learner">
        <label for="user-type-learner" id="learner-label">Learner</label>
        <input type="radio" id="user-type-qsd" name="user-type" value="QSD">
        <label for="user-type-qsd" id="learner-label">QSD</label>
        <input type="radio" id="user-type-instructor" name="user-type" value="Instructor"> 
        <label for="user-type-instructor" id="learner-label">Instructor</label> <br>

        <input type="checkbox" onclick="togglePassword()" id="password-toggle" name="password-toggle">
        <label for="password-toggle">Show Password</label> <br>

        <input type="submit" value="Sign up">
    </form>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users(email, password) VALUES('$email', '$hash_password');";

    try {
        mysqli_query($conn, $sql);
        echo "acc created<br>";
        echo "<a href=\"login-page.php\">Login</a>";
    } catch (mysqli_sql_exception) {
        echo "error/acc already exists";
    }
}

?>