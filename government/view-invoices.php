<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "government");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: View Invoices</title>
    <link rel="stylesheet" href="../style/home-page.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/home.js" defer></script>
    <script src="../scripts/menu.js" defer></script>
    <script src="../scripts/table-filter.js" defer></script>

</head>

<body>
    <?php
    require_once "government-menu.php";
    $id = $_SESSION["userID"];
    ?>

    <div class="search-container">
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for invoices...">
    </div>


    <div class="table-container">
        <?php
        $sql = "SELECT invoicedetails.*, 
        Instructor.firstName as IFirstName, 
        Instructor.lastName as ILastName, 
        Learner.firstName as LFirstName, 
        Learner.lastName as LLastName 
        FROM invoicedetails 
        LEFT JOIN Users as Instructor ON invoicedetails.instructorID = Instructor.id 
        LEFT JOIN Users as Learner ON invoicedetails.learnerID = Learner.id";



        echo "<table id='invoiceTable'>
            <caption>Total Invoices</caption>
            <tr>
                <th>Invoice ID</th>
                <th>Instructor Name</th>
                <th>Instructor ID</th>
                <th>Student Name</th>
                <th>Student ID
                <th>Time</th>
                <th>Location</th> 
                <th>Type</th>
                <th>Amount</th>
                <th>Status</th>

            </tr>";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['IFirstName']} {$row['ILastName']}</td>
                            <td>{$row['instructorID']}</td>
                            <td>{$row['LFirstName']} {$row['LLastName']}</td>
                            <td>{$row['learnerID']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['lessonType']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['status']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No invoices found.</td></tr>";
            }
        }

        mysqli_free_result($result);
        echo "</table>";
        ?>
    </div>
</body>

</html>