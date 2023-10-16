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
    <script src="../scripts/home.js" defer></script>
    <script src="../scripts/menu.js" defer></script>
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
            <caption>Your Invoices</caption>
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
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['firstName']} {$row['lastName']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['lessonType']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['status']}</td>
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
</body>

</html>
