<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "instructor");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: View Invoices</title>
    <link rel="stylesheet" href="../style/home-page.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/collapsible.css" />
    <script src="../scripts/home.js" defer></script>
    <script src="../scripts/menu.js" defer></script>
    <script src="../scripts/collapsible.js" defer></script>
    <script src="../scripts/table-filter.js" defer></script>
</head>

<body>
    <?php
    require_once "instructor-menu.php";
    $id = $_SESSION["userID"];
    ?>

    <div class="table-container">
        <?php
        $sql = "SELECT Users.firstName, 
                Users.lastName, 
                InvoiceDetails.time, 
                InvoiceDetails.location, 
                InvoiceDetails.lessonType, 
                InvoiceDetails.amount, 
                InvoiceDetails.status,
                InvoiceDetails.id,
                InvoiceDetails.learnerID
                FROM InvoiceDetails
                JOIN Users ON InvoiceDetails.learnerID = Users.id
                WHERE InvoiceDetails.instructorID = '$id';";

        echo "<table>
            <caption>Your Unpaid Invoices</caption>
            <tr>
                <th>Invoice ID</th>
                <th>Student Name</th>
                <th>Time</th>
                <th>Location</th> 
                <th>Type</th>
                <th>Amount</th>
                <th>Status</th>

            </tr>";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row["status"] ? "Paid" : "Unpaid";
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['firstName']} {$row['lastName']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['lessonType']}</td>
                            <td>$" . number_format($row["amount"], 2) . "</td>
                            <td>$status</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No invoices found.</td></tr>";
            }
        }

        mysqli_free_result($result);
        echo "</table>";
        ?>
    </div>
    <br>
    
    <button class="collapsible">Paid Invoices</button>
    <div class="content">
        <br>
        <div class="table-container">
            <div class="search-container">
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for invoices...">
            </div>
            <br>
            <?php
            $sql = "SELECT Users.firstName, 
                Users.lastName, 
                InvoiceDetails.time, 
                InvoiceDetails.location, 
                InvoiceDetails.lessonType, 
                InvoiceDetails.amount, 
                InvoiceDetails.status,
                InvoiceDetails.id,
                InvoiceDetails.learnerID
                FROM InvoiceDetails
                JOIN Users ON InvoiceDetails.learnerID = Users.id
                WHERE InvoiceDetails.instructorID = '$id' AND status = 1;";

            echo "<table id='filterableTable'>
            <caption>Your Paid Invoices</caption>
            <tr>
                <th>Invoice ID</th>
                <th>Student Name</th>
                <th>Time</th>
                <th>Location</th> 
                <th>Type</th>
                <th>Amount</th>
            </tr>";

            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $status = $row["status"] ? "Paid" : "Unpaid";
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['firstName']} {$row['lastName']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['lessonType']}</td>
                            <td>$" . number_format($row["amount"], 2) . "</td>c
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No invoices found.</td></tr>";
                }
            }

            mysqli_free_result($result);
            mysqli_close($conn);
            echo "</table>";
            ?>
        </div>
        <br>
    </div>
</body>

</html>