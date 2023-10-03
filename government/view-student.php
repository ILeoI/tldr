<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";

$viewingID = "0";
if (isset($_GET["viewing"])) {
    $viewingID = $_GET["viewing"];
} else {
    header("location: view-students.php");
}

$sql = "SELECT * FROM Users WHERE id = '$viewingID';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $viewingUser = mysqli_fetch_assoc($result);
    }
}
mysqli_free_result($result);
$sql = "SELECT * FROM InstructorLearners INNER JOIN Users WHERE instructorID = Users.id AND learnerID = '$viewingID';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $instructorUser = mysqli_fetch_assoc($result);
    }
}
mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../scripts/menu.js" defer></script>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <title>TLDR: Viewing A Student</title>
</head>

<body>
    <?php require_once "government-menu.php"; ?>

    <h1>Viewing Student: <?php echo $viewingUser["firstName"] . " " . $viewingUser["lastName"]; ?></h1>
    <h2>Instructor: <?php echo $instructorUser["firstName"] . " " . $instructorUser["lastName"]; ?></h2>
    <h2>View Drives</h2>
    
    <h2>View CBT&A</h2>
    <h2>View Account</h2>
</body>

</html>