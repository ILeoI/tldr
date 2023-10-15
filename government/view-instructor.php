<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "government");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/home-page.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/collapsible.css" />
    <script src="../scripts/home.js" defer></script>
    <script src="../scripts/menu.js" defer></script>
    <script src="../scripts/collapsible.js" defer></script>
    <title>TLDR: Viewing An Instructor</title>
</head>

<body>
    <!-- Load the government menu -->
    <?php require_once "government-menu.php"; ?>

    <!-- Get instructors information -->
    <?php
    $viewingID = "0";
    if (isset($_GET["viewing"])) {
        $viewingID = $_GET["viewing"];
    } else {
        header("location: view-instructors.php");
    }

    $sql = "SELECT firstName, lastName FROM Users WHERE id = '$viewingID';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
        }
    }

    echo "<h2>Viewing {$row['firstName']} {$row['lastName']}</h2>";
    ?>

    <!-- Get list of instructor's students -->
    <button class="collapsible">Current Students</button>
    <div class="content">
        <ul style="height: 100%; float: left; padding-bottom: 25px">
            <?php
            $sql = "SELECT Users.id, Users.firstName, Users.lastName, Users.licenseNo 
                    FROM Users 
                    JOIN InstructorLearners ON Users.id = InstructorLearners.learnerID 
                    WHERE InstructorLearners.instructorID = '$viewingID';";

            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li>{$row['firstName']} {$row['lastName']}, " . $row["licenseNo"] . " <a href=\"view-student.php?viewing=" . $row["id"] . "\">View</a></li>";
                    }
                }
            }
            ?>
        </ul>
    </div>
    <br>

    <!-- Get their future bookings and invoices by comparing the booking date with now()-->
    <button class="collapsible">Future Bookings</button>
    <div class="content">
        <br>
        <div class="table-container">
            <?php
            // Retrieve instructor's bookings
            $sql = "SELECT Users.firstName, Users.lastName, bookings.time, bookings.location
                FROM bookings
                JOIN Users ON bookings.learnerID = Users.id
                WHERE bookings.instructorID = '$viewingID' AND bookings.time >= now();";

            echo "<table>
                <tr>
                    <th>Student Name</th>
                    <th>Date & Time</th>
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
    </div>
    <br>

    <!-- Get their past bookings and invoices -->
    <button class="collapsible">Past Bookings</button>
    <div class="content">
        <br>
        <div class="table-container">
            <?php
            // Retrieve instructor's bookings
            $sql = "SELECT Users.firstName, Users.lastName, bookings.time, bookings.location
                FROM bookings
                JOIN Users ON bookings.learnerID = Users.id
                WHERE bookings.instructorID = '$viewingID' AND bookings.time < now();";

            echo "<table>
                <tr>
                    <th>Student Name</th>
                    <th>Date & Time</th>
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
    </div>
</body>

</html>