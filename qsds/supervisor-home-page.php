<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "supervisor");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
    <title>TLDR: QSD Home Page</title>

</head>

<body>
    <?php
    require_once "supervisor-menu.php";

    // Retrieve instructor's row containing their information
    $id = $_SESSION["userID"];
    $sql = "SELECT firstName, lastName FROM Users WHERE id = '$id';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<p>Welcome, <b>" . $row["firstName"] . " " . $row["lastName"] . "</b>, to the TLDR System.</p>";
        }
    }
    mysqli_free_result($result);
    ?>

</body>

</html>