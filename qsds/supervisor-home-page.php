<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "supervisor");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/your-learner.css" />
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

    <div class="center">

        <form action="add-learner.php" method="post">
            <?php
            if (isset($_GET["feedback"])) {
                $feedback = $_GET["feedback"];
                if ($feedback == "0") {
                    echo "<p style='color: red'>Something went wrong</p>";
                } else if ($feedback == "1") {
                    echo "<p style='color: red'>Student already assigned instructor</p>";
                } else if ($feedback == "2") {
                    echo "<p style='color: red'>Invalid Licence number</p>";
                } else if ($feedback == "3") {
                    echo "<p style='color: green'>Student added successfully</p>";
                } else if ($feedback == "5") {
                    echo "<p style='color: green'>Student removed successfully</p>";
                }
            }
            ?>
            <label class="special1" for="learner-ln-input">Add a learner here: </label>
            <input type="text" name="learner-ln-input" id="learner-ln-input" placeholder="Licence Number" required>
            <input type="submit" value="Add">
        </form>

        <?php

        // generates a list of the instructors students with a link to view their CBT&A.
        $supervisorID = $_SESSION["userID"];
        $sql = "SELECT Users.id, Users.firstName, Users.lastName, Users.licenceNo 
                FROM Users 
                JOIN SupervisorLearners ON Users.id = SupervisorLearners.learnerID 
                WHERE SupervisorLearners.supervisorID = '$supervisorID';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td><label>" . $row["firstName"] . " " . $row["lastName"] . " - " . $row["licenceNo"] . " </label></td>
                            <td><a href=\"view-drive-log.php?learnerID=" . $row["id"] . "\">View Drive Log</a></td>
                            <td><a href=\"release-learner.php?learnerID=" . $row["id"] . "\">Release Learner</a></td>
                        </tr>";
                    }
                echo "</table>";
            }
        }
        mysqli_free_result($result);
        ?>
    </div>

</body>

</html>