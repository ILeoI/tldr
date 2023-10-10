<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "instructor");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Jacob">
    <meta name="description" content="HomePage">
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

    <div class="table-container">
        <?php
        $sql = "SELECT Users.firstName, Users.lastName, bookings.time, bookings.location
                FROM bookings
                JOIN Users ON bookings.learnerID = Users.id
                WHERE bookings.instructorID = '$id';";

        echo "<table>
                <tr>
                    <caption>Your Bookings</caption>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Location</th> 
                </tr>";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['firstName']} {$row['lastName']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['location']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No bookings found.</td></tr>";
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

    <div class="table-container">
    <form action="process_verify_booking.php" method="post">
        <?php
        $sql = "SELECT Users.firstName, Users.lastName, bookingRequests.id, bookingRequests.time, bookingRequests.location
                FROM bookingRequests
                JOIN Users ON bookingRequests.learnerID = Users.id
                WHERE bookingRequests.instructorID = '$id' AND verified = '0';";

        echo "<table>
                <tr>
                    <caption>Student Booking Requests</caption>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Location</th> 
                    <th>Verify</th>
                </tr>";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['firstName']} {$row['lastName']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['location']}</td>
                            <td><input type='checkbox' name='{$row["id"]}'/></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No booking requests found.</td></tr>";
            }
        }

        mysqli_free_result($result);
        echo "</table>";
        ?>

        <div class="button-container">
            <input type="submit" class="add-lesson-button" value= verify> 
        </div>
    </form>
</div>


</body>

</html>

<?php
mysqli_close($conn);
?>