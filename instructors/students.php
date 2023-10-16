<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "instructor");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: Your Students</title>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/home-page.css" />
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
    <br>

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
        } else if ($feedback == "5") {
            echo "<p>Student removed successfully</p>";
        }
     }

    ?>

    <table>
        <tr>
            <th>Student Name</th>
            <th>License Number</th>
            <th>Edit CBT&A</th>
            <th>Release Student</th>
        </tr>
        <?php
        // generates a list of the instructors students with a link to view their CBT&A.
        $instructorID = $_SESSION["userID"];
        $sql = "SELECT Users.id, Users.firstName, Users.lastName, Users.licenseNo 
            FROM Users 
            JOIN InstructorLearners ON Users.id = InstructorLearners.learnerID 
            WHERE InstructorLearners.instructorID = '$instructorID';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["firstName"] . " " . $row["lastName"] . "</td>";
                    echo "<td>" . $row["licenseNo"] . "</td>";
                    echo "<td><a href=\"cbta.php?learnerID=" . $row["id"] . "\">View CBT&A</a></td>";
                    echo "<td><a href=\"release-student.php?learnerID=" . $row["id"] . "\">Release</a></td>";
                    echo "</tr>";
                }
            }
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
    </table>
</body>

</html>