<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: View lessons</title>
    <link rel="stylesheet" href="../style/menu-style.css" />
</head>

<body>
    <?php require_once "learner-menu.php"; ?>
    <h1>Upcoming Lessons</h1>
    <div class="table-container">
        <table>
            <tr>
                <caption>Upcoming Lessons</caption>
                <th>With</th>
                <th>Time</th>
                <th>Location</th>
            </tr>
            <?php
            $sql = "SELECT Users.firstName, Users.lastName, bookings.time, bookings.location
                    FROM Bookings
                    JOIN Users on bookings.instructorID = Users.id
                    WHERE Bookings.learnerID = '{$_SESSION["userID"]}'
                    AND now() < Bookings.time;";
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row["firstName"]} {$row["lastName"]}</td>";
                        echo "<td>{$row['time']}</td>";
                        echo "<td>{$row['location']}</td>";
                        echo "</tr>";
                    }
                }
            }
            ?>
        </table>
    </div>
    <h1>Past Lessons</h1>
    <div class="table-container">
        <table>
            <tr>
                <caption>Past Lessons</caption>
                <th>With</th>
                <th>Time</th>
                <th>Location</th>
            </tr>
            <?php
            $sql = "SELECT Users.firstName, Users.lastName, bookings.time, bookings.location
                    FROM Bookings
                    JOIN Users on bookings.instructorID = Users.id
                    WHERE Bookings.learnerID = '{$_SESSION["userID"]}'
                    AND now() >= Bookings.time;";
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row["firstName"]} {$row["lastName"]}</td>";
                        echo "<td>{$row['time']}</td>";
                        echo "<td>{$row['location']}</td>";
                        echo "</tr>";
                    }
                }
            }
            ?>
        </table>
    </div>
</body>

</html>