<?php
    require_once "../inc/dbconn.inc.php";
    require_once "../inc/session-start.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TLDR: Student</title>
</head>
<body>
    <h1>Your Students</h1>
    <?php
        $instructorID = $_SESSION["userID"];
        $sql = "SELECT * FROM InstructorLearners WHERE instructorID = '$instructorID';";
        if ($result = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($result) > 0) {
                echo "<ul>";
                while ($row = mysqli_fetch_assoc($result)) {
                    $learnerID = $row["learnerID"];
                    $sql = "SELECT * FROM users WHERE id = '$learnerID';";
                    if ($result = mysqli_query($conn, $sql)) {
                        if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<li><label>". $row["firstName"] . " " . $row["lastName"] . " </label><a href=\"cbta.php?learnerID=" . $row["id"] ."\">View CBT&A</a></li>";
                        }
                    }
                }
                echo "</ul>";
            }
        }
    ?>
</body>
</html>