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
    <title>TLDR: View Instructors</title>
</head>
<body>
<?php require_once "government-menu.php"; ?>

    <br>
    <ul>
    <?php
        $sql = "SELECT * FROM Users WHERE instructor = '1';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li>" . $row["firstName"] . " " . $row["lastName"] . ", <a href='view-instructor.php?instructorID={$row["id"]}'>View</a></li>";
                }
            }
        }
        mysqli_free_result($result);
        mysqli_close($conn);
    ?>
    </ul>
</body>
</html>