<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: Student</title>
    <link rel="stylesheet" href="../style/menu-style.css" />
</head>

<body>
    <?php require_once "instructor-menu.php"; ?>
    <h1>Your Students</h1>

    <form action="add-student.php" method="post">
        <label for="student-ln-input">Add a student here: </label>
        <input type="text" name="student-ln-input" id="student-ln-input" placeholder="License Number" required>
        <input type="submit" value="Add">
    </form>

    <?php
    if (isset($_GET["feedback"])) {
        $feedback = $_GET["feedback"];
        if ($feedback == "0") {
            echo "<p>Something went wrong</p>";
        } else if ($feedback == "1") {
            echo "<p>Student already assigned instructor</p>";
        } else if ($feedback == "2") {
            echo "<p>Invalid license number</p>";
        } else if ($feedback == "3") {
            echo "<p>Student added successfully</p>";
        }
    }

    $instructorID = $_SESSION["userID"];
    $sql = "SELECT * FROM InstructorLearners WHERE instructorID = '$instructorID';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                $learnerID = $row["learnerID"];
                $sql = "SELECT firstName, lastName, licenseNo FROM Users WHERE id = '$learnerID';";
                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        echo "<li><label>" . $row["firstName"] . " " . $row["lastName"] . ", " . $row["licenseNo"] . " </label><a href=\"cbta.php?learnerID=" . $learnerID . "\">View CBT&A</a></li>";
                    }
                }
            }
            echo "</ul>";
        }
    }
    ?>
</body>

</html>