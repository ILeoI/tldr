<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLDR: Find An Instructor</title>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/home-page.css" />
    <script src="../scripts/menu.js" defer></script>
    <script src="../scripts/table-filter.js" defer></script>
</head>

<body>
    <?php require_once "learner-menu.php"; ?>

    <?php
    $id = $_SESSION["userID"];
    $sql = "SELECT * FROM InstructorLearners WHERE learnerID = '$id';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $entry = mysqli_fetch_assoc($result);
        }
    }
    ?>

    <div <?php echo isset($entry) ? "" : "style='display: none'" ?> class="centre">
        <?php
        echo "<p>You already have an instructor.<br>If you wish to have another instructor, please ask them to release you or contact support.</p>";
        ?>
    </div>

    <div <?php echo isset($entry) ? "style='display: none'" : "" ?>>
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for Instructors...">
        </div>
        <table id="filterableTable">
            <tr>
                <th>Instructor Name</th>
                <th>Serviceable Area</th>
                <th>View About Me</th>
            </tr>
            <?php
            $sql = "SELECT * FROM InstructorInfo JOIN Users ON Users.id = InstructorInfo.instructorID;";
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $name = $row["firstName"] . " " . $row["lastName"];
                        $serviceableArea = $row["serviceableArea"];
                        echo "<tr>";
                        echo "<td>$name</td>";
                        echo "<td>$serviceableArea</td>";
                        echo "<td><a href='view-instructor.php?viewing={$row["id"]}'>View</a></td>";
                        echo "</tr>";
                    }
                }
                mysqli_free_result($result);
            }
            ?>
        </table>
    </div>
</body>

</html>

<?php mysqli_close($conn) ?>