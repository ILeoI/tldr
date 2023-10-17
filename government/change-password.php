<?php

require_once "../inc/db-session-include.php";
requireUserType($conn, "government");

// If the page is requested from post update the password of the user
// Send the user back to the previous page with appropriate feedback
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["id"])) {
    $userID = $_GET["id"];
    $newPassword = $_POST["new-password"];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE Users SET password = '$hashedPassword' WHERE id = '$userID';";
    print_r($_GET);
    print_r($_POST);
    echo $sql;
    try {
        mysqli_query($conn, $sql);
        header("location: view-account.php?viewing=$userID&feedback=0");
        exit();
    } catch (mysqli_sql_exception) {
        header("location: view-account.php?viewing=$userID&feedback=1");
        exit();
    }
}

?>

<!-- Get the name of the user you are changing the password for -->
<?php
if (!isset($_GET["id"])) {
    header("location: view-accounts.php");
}

$id = $_GET["id"];
$sql = "SELECT firstName, lastName FROM Users WHERE id = '$id';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row["firstName"] . " " . $row["lastName"];
    }
    mysqli_free_result($result);
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLDR: Change Password for <?php echo $name ?></title>
    <script src="../scripts/menu.js" defer></script>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/changepassword.css" />
</head>

<body>
    <?php require_once "government-menu.php" ?>

    <form action="change-password.php?id=<?php echo $id ?>" method="post">
        <label for="new-password">New Password:</label>
        <input type="text" id="new-password" name="new-password" required>
        <br>
        <input type="submit">
    </form>
    <br>
    <a href="view-account.php?viewing=<?php echo $id ?>">
        <button>Go Back</button>
    </a>
</body>

</html>