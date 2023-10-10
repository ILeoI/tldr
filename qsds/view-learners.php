<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "supervisor");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: Your Learners</title>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
</head>

<body>
    <?php
    require_once "supervisor-menu.php"
    ?>
    <br>

    <form action="add-learner.php" method="post">
        <label for="learner-ln-input">Add a learner here: </label>
        <input type="text" name="learner-ln-input" id="learner-ln-input" placeholder="License Number" required>
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

    // generates a list of the instructors students with a link to view their CBT&A.
    $supervisorID = $_SESSION["userID"];
    $sql = "SELECT Users.id, Users.firstName, Users.lastName, Users.licenseNo 
                FROM Users 
                JOIN SupervisorLearners ON Users.id = SupervisorLearners.learnerID 
                WHERE SupervisorLearners.supervisorID = '$supervisorID';";
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
    ?>
</body>

</html>

<?php
mysqli_close($conn);
?>