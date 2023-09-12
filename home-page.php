<?php
    require_once "inc/session-start.inc.php";
    require_once "inc/dbconn.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="">
    <meta name="description" content="">
    <title>TLDR: Home Page</title>
</head>
<body>
    <h1 class="page-title" id="home-page-header">Home Page</h1>
    <?php
        $id = $_SESSION["userID"];
        $sql = "SELECT firstName, lastName FROM Users WHERE id = '$id';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<p>Welcome " . $row["firstName"] . " " . $row["lastName"] .".</p>";
            }
        }
    ?>
</body>
</html>