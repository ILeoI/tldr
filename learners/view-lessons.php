<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TLDR: View lessons</title>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
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
            mysqli_free_result($result);
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
            mysqli_free_result($result);
            ?>
        </table>
    </div>

    <button id="openFormButton">Request a Lesson</button>

<div id="bookingForm" style="display:none;">
    <form action="request-lesson.php" method="post">
        <label for="time">Time:</label>
        <input type="datetime-local" id="time" name="time" required><br><br>
        <label for="location">Location:</label>
        <input type="location" id="location" name="location" required><br><br>
        <label for="LessonType">Lesson Type:</label>
                    <div class="lessonTypes">
                        <input type="radio" name="LessonType" value="Driving Practice" required><label>Driving Practice</label>
                        <input type="radio" name="LessonType" value="CBTA" required><label>CBTA Lesson</label>
                    </div>                
        <input type="submit" value="Submit Request">
    </form>
</div>


<script>
    document.getElementById("openFormButton").addEventListener("click", function() {
        document.getElementById("bookingForm").style.display = "block";
    });


</script>


</form>

</body>

</html>

<?php
mysqli_close($conn);
?>