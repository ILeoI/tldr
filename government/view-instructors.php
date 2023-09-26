<?php
    require_once "../inc/dbconn.inc.php";
    require_once "../inc/session-start.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLDR: View Instructors</title>
</head>
<body>
    <h1>Instructors</h1>
    <ul>
    <?php
        $sql = "SELECT * FROM Users WHERE instructor = '1';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li>" . $row["firstName"] . " " . $row["lastName"] . "</li>";
                }
            }
        }
    ?>
    </ul>
</body>
</html>