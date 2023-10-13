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
    <script src="../scripts/home.js" defer></script>
    <script src="../scripts/menu.js" defer></script>
    <script src="../scripts/table-filter.js" defer></script>


    <title>TLDR: View Instructors</title>
</head>

<body>

    <?php require_once "government-menu.php"; ?>
    <div class="table-container">
    <br>
    <ul>
    <div class="search-container">
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for Instructors...">
    </div>
        <?php
        $sql = "SELECT * FROM Users WHERE instructor = '1';";
       
        echo "<table id='govTable'>
        <caption>Instructors:</caption>
        <tr>
            <th>Instructor ID</th>
            <th>Instructor Name</th>
            <th></th>
          

        </tr>";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['firstName']} {$row['lastName']}</td>
                    <td><a href='view-instructor.php?viewing={$row["id"]}'>View</a></td>
                </tr>";
        }
                }
                else {
                    echo "<tr><td colspan='3'>No ins found.</td></tr>";
                }
            }
        
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
    </ul>
    </div>
</body>

</html>
