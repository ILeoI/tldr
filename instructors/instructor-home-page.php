<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Jacob">
    <meta name="description" content="HomePage">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: Home Page</title>
    <link rel="stylesheet" href="style/home-page.css" />
    <script src="scripts/home.js" defer></script>
</head>

<body>
    <h1 class="page-title" id="home-page-header">
        <div class="dropdown">
            <button class="dropbtn">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </button>
            <div class="dropdown-content">
                <a href="add-drive.php">Add drives</a>
                <a href="instructors/cbta.php">CBTA</a>
                <a href="instructors/students.php">Your Students</a>
                <a href="instructors/my-account.php">Account</a>
            </div>
        </div>
        <label>Home Page</label>
    </h1>
    <?php
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
    ?>

    <div class="table-container">
        <?php
        // Retrieve instructor's bookings
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

        echo "</table>";
        ?>
    </div>

    <div class="button-container">
        <a href="instructors/add-lesson.php">
            <button class="add-lesson-button">Add Lesson</button>
        </a>
    </div>

</body>

</html>
