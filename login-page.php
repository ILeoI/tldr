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
    <title>Login</title>
    <link rel="stylesheet" href="style/login.css" />
    <script src="scripts/login.js" defer></script>
</head>


<body>
    <div class="login">
        <h1 class="page-title" id="login-page-header">Login Page</h1>
        <form id="login-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <label for="email">E-mail</label> <br>
            <input type="text" placeholder="E-mail" id="email" name="email"> <br>

            <label for="password">Password</label> <br>
            <input type="password" placeholder="Password" id="password" name="password"> <br>

            <input type="checkbox" onclick="togglePassword()" id="password-toggle" name="password-toggle">
            <label for="password-toggle">Show Password</label> <br>

            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "SELECT * FROM users WHERE email = '$email';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"]) || 1) {
            $_SESSION["userID"] = $row["id"];
            header("location: home-page.php");
        } else {
            incorrectInfo();
        }
    } else {
        incorrectInfo();
    }
}

function incorrectInfo() {
    echo "<p style=\"color: red;\">Incorrect account information!<br><a style=\"color: black; text-decoration: none\" href=\"forgot-password.php\">Forgot Password?</a></p>";
}

?>