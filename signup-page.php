<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="">
    <meta name="description" content="">
    <title>Signup</title>
    <link rel="stylesheet" href="Style/login.css" />
    <script src="sign-up.js" defer></script>
</head>

<body>
    <h1 class="page-title" id="signup-page-header">Signup Page</h1>
    <form id="signup-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <label for="email">E-mail</label> <br>
        <input type="email" placeholder="E-mail" id="email" name="email"> <br>

        <label for="password">Password</label> <br>
        <input type="text" placeholder="Password" id="password" name="password" minlength="8"> <br>

        <label for="confirm-password">Confirm Password</label> <br>
        <input type="text" placeholder="Confirm Password" id="confirm-password" name="confirm-password" minlength="8">

        <input type="submit" value="Sign up">
    </form>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm_password = filter_input(INPUT_POST, "confirm-password", FILTER_SANITIZE_SPECIAL_CHARS);

    
}

?>