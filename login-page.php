<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="">
    <meta name="description" content="">
    <title>Login</title>
    <link rel="stylesheet" href="Styles/style.css" />
</head>
<body>
    <h1 class="page-title" id="login-page-header">Login Page</h1>
    <form id="login-form" action="home-page.php" method="POST">
        <label for="username">Username</label> <br>
        <input type="text" placeholder="Username" id="username" name="username"> <br>

        <label for="password">Password</label> <br>
        <input type="text" placeholder="Password" id="password" name="password"> <br>

        <input type="submit" value="Login">
    </form>
</body>
</html>