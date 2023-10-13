<?php

require_once "../inc/db-session-include.php";
requireUserType($conn, "government");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="">
    <meta name="description" content="HomePage">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: View Accounts</title>
    <link rel="stylesheet" href="../style/home-page.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/home.js" defer></script>
    <script src="../scripts/menu.js" defer></script>
    <script src="../scripts/table-filter.js" defer></script>

</head>

<body>
    <!-- Load the government menu -->
    <?php require_once "government-menu.php"; ?>
    <br>
    <table>
        <tr>
            <td>Name</td>
            <td>License Number</td>
            <td>User Type</td>
            <td>View Account</td>
            <td>View TLDR Info</td>
        </tr>
        <?php
        // Creates a list with all users if supervisor is 1
        $sql = "SELECT * FROM Users;";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row["instructor"] == 1) {
                        $type = "instructor";
                    } else if ($row["learner"] == 1) {
                        $type = "student";
                    } else if ($row["supervisor"] == 1) {
                        $type = "qsd";
                    } else if ($row["government"] == 1) {
                        $type = "government";
                    }
                    echo "<tr>";
                    echo "<td>" . $row["firstName"] . " " . $row["lastName"] . "</td>";
                    echo "<td>" . $row["licenseNo"] . "</td> ";
                    echo "<td>" . ucfirst(($type)) ."</td>";
                    if ($type != "government") {
                        echo "<td><a href=\"view-account.php?viewing=" . $row["id"] . "\">View</a></td>";   
                        echo "<td><a href=\"view-$type.php?viewing=" . $row["id"] . "\">View</a></td>";
                    }    
                    echo "</tr>";
                }
            }
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
    </table>
</body>

</html>