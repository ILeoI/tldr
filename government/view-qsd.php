<?php
    require_once "../inc/db-session-include.php";
    requireUserType($conn, "government");

    // Check for viewing GET
    if (!isset($_GET["viewing"])) {
        header("location: view-qsds.php");
        exit();
    }

    $viewingID = $_GET["viewing"];

    // Check to see if user is in database and a supervisor/qsd 
    if (!checkUserType($conn, "qsd", $viewingID)) {
        header("location: view-qsds.php");
        exit();
    }

    // Load QSD
    $sql = "SELECT * FROM Users WHERE id = '$viewingID';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $viewingUser = mysqli_fetch_assoc($result);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../scripts/menu.js" defer></script>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <title>TLDR: Viewing QSD: <?php echo $viewingUser["firstName"] . " " . $viewingUser["lastName"] ?></title>
</head>
<body>
    <?php require_once "government-menu.php" ?>
    <h2>Learners</h2>
    <?php
        $sql = "SELECT Users.id, Users.firstName, Users.lastName, Users.licenceNo 
                FROM Users 
                JOIN SupervisorLearners ON Users.id = SupervisorLearners.learnerID 
                WHERE SupervisorLearners.supervisorID = '$viewingID';";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li>{$row['firstName']} {$row['lastName']}, " . $row["licenceNo"] . " <a href=\"view-student.php?viewing=" . $row["id"] . "\">View</a></li>";
                }
            }
            mysqli_free_result($result);
        }
        mysqli_close($conn);
        ?>
</body>
</html>