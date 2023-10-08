<?php
require_once "../inc/db-session-include.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: Your Students</title>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
</head>

<body>
    <?php require_once "instructor-menu.php"; ?>
    <br>
    <form action="add-student.php" method="post">
        <label for="student-ln-input">Add a student here: </label>
        <input type="text" name="student-ln-input" id="student-ln-input" placeholder="License Number" required>
        <input type="submit" value="Add">
    </form>

    <?php
    // Displays feedback if feedback is set
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
        } else if ($feedback == "4") {
            echo "<p>Entered License Number is not a student</p>";
        }
    }


    // generates a list of the instructors students with a link to view their CBT&A.
    $instructorID = $_SESSION["userID"];
    $sql = "SELECT Users.id, Users.firstName, Users.lastName, Users.licenseNo 
            FROM Users 
            JOIN InstructorLearners ON Users.id = InstructorLearners.learnerID 
            WHERE InstructorLearners.instructorID = '$instructorID';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li><label>" . $row["firstName"] . " " . $row["lastName"] . ", " . $row["licenseNo"] . " </label><a href=\"cbta.php?learnerID=" . $row["id"] . "\">View CBT&A</a></li>";
            }
            echo "</ul>";
        }
    }
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</body>

</html>