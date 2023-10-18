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
</head>

<body>
    <?php require_once "learner-menu.php"; ?>

    <div>
        <?php
            $sql = "SELECT * FROM InstructorInfo;";
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        foreach ($e as $row) {
                            echo $e;
                        }
                    }
                }
            }
        ?>
    </div>
</body>

</html>