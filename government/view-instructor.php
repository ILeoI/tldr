<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../scripts/menu.js" defer></script>
    <link rel="stylesheet" href="../style/menu-style.css" />
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
    <h2>Students:</h2>
    <ul>
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

    <!-- Get their bookings and invoices -->
    <h2>Bookings</h2>
    <div class="table-container">
        <?php
        // Retrieve instructor's bookings
        $sql = "SELECT Users.firstName, Users.lastName, bookings.time, bookings.location
                FROM bookings
                JOIN Users ON bookings.learnerID = Users.id
                WHERE bookings.instructorID = '$viewingID';";

        echo "<table>
                <tr>
                    <caption>Their Bookings</caption>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Location</th> 
                    <th>Invoice</th>
                </tr>";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['firstName']} {$row['lastName']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['location']}</td>
                            <td><a href='../view-invoice.php?invoiceID=id'>View</a></td>
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
</body>

</html>