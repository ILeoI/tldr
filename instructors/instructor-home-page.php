<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "instructor");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: Home Page</title>
    <link rel="stylesheet" href="../style/home-page.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/home.js" defer></script>
    <script src="../scripts/menu.js" defer></script>
</head>

<body>
    <?php
    require_once "instructor-menu.php";

    // Assuming $conn is the connection to your database

    // Retrieve instructor's name
    $id = $_SESSION["userID"];
    $sql = "SELECT firstName, lastName FROM Users WHERE id = '$id';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<p>Welcome " . $row["firstName"] . " " . $row["lastName"] . ".</p>";
        }
    }
    mysqli_free_result($result);
    ?>

<<<<<<< HEAD
    <div class="table-container">
        <?php
        // Retrieve instructor's bookings
        $sql = "SELECT Users.firstName, Users.lastName, bookings.time, bookings.location, bookings.lessonType
                FROM bookings
                JOIN Users ON bookings.learnerID = Users.id
                WHERE bookings.instructorID = '$id';";
=======
    <!-- Instructor's bookings -->
    <div id="instructor-bookings">
        <div class="table-container">
            <table>
                <tr>
                    <caption>Your Bookings For This Week</caption>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Type</th>
                </tr>

                <?php
                // Retrieve instructor's bookings
                $sql = "SELECT Users.firstName, Users.lastName, bookings.time, bookings.location, bookings.lessonType
                FROM bookings
                JOIN Users ON bookings.learnerID = Users.id
                WHERE bookings.instructorID = '$id'
                AND bookings.time > now() 
                AND bookings.time < DATE_ADD(now(), INTERVAL 1 WEEK);";
>>>>>>> 154358643156dc8d1a5f2a6e9c42fc728e173e99

        echo "<table>
                <tr>
                    <caption>Your Bookings</caption>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Location</th> 
                    <th>Type</th>
                </tr>";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['firstName']} {$row['lastName']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['lessonType']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No bookings found.</td></tr>";
            }
        }

        mysqli_free_result($result);
        echo "</table>";
        ?>
    </div>

    <div class="button-container">
        <a href="add-lesson.php">
            <button class="add-lesson-button">Add Lesson</button>
        </a>
    </div>

</body>

</html>

<?php
mysqli_close($conn);
?>