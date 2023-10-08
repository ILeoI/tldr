<?php
require_once "../inc/db-session-include.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    $userID = $_SESSION["userID"];

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "Please fill in all fields.";
    } elseif ($newPassword != $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } else {
        $sql = "SELECT password FROM Users WHERE id = '$userID';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        $hashedPassword = $row["password"];

        if (password_verify($currentPassword, $hashedPassword)) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE Users SET password = '$hashedNewPassword' WHERE id = '$userID';";
            mysqli_query($conn, $updateSql);
            $success = "Password updated successfully!";

            header("Location: my-account.php");
            exit();
        } else {
            $error = "Current password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
    <title>TLDR: Change Password</title>
</head>

<body>
    <?php require_once "supervisor-menu.php" ?>

    <?php
    if (isset($error)) {
        echo '<div class="error">' . $error . '</div>';
    } elseif (isset($success)) {
        echo '<div class="success">' . $success . '</div>';
    }
    ?>

    <br>

    <div class="change-password-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword" required><br><br>

            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required><br><br>

            <label for="confirmPassword">Confirm New Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>

            <input type="submit" value="Change Password">
        </form>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>