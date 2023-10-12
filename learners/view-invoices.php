<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Jacob">
    <meta name="description" content="HomePage">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: View Invoices</title>
    <link rel="stylesheet" href="../style/home-page.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/home.js" defer></script>
    <script src="../scripts/menu.js" defer></script>
</head>

<body>
    <?php
    require_once "learner-menu.php";
    $id = $_SESSION["userID"];
    ?>

    <div class="outstanding-invoives">
        <form action="pay-invoice.php" method="POST">
            <table>
                <caption>Outstanding Invoices</caption>
                <tr>
                    <th>Invoice ID</th>
                    <th>Instuctor Name</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
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
                    JOIN Users ON InvoiceDetails.instructorID = Users.id
                    WHERE InvoiceDetails.learnerID = '$id'
                    AND InvoiceDetails.status = 0;";
                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo 
                            "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['firstName']} {$row['lastName']}</td>
                                <td>{$row['time']}</td>
                                <td>{$row['location']}</td>
                                <td>{$row['lessonType']}</td>
                                <td>{$row['amount']}</td>
                                <td><input type='checkbox' name='{$row['id']}'></td>
                            </tr>"; 
                        }
                    } else {
                        echo "<tr><td colspan='7'>No invoices found.</td></tr>";
                    }
                }

                mysqli_free_result($result);
                ?>
            </table>
            <div class="button-container">
                <input type="submit" class="add-lesson-button" value="Pay Invoice"> 
            </div>
        </form>
    </div>

    <div class="paid-invoives">
        <table>
            <caption>Paid Invoices</caption>
            <tr>
                <th>Invoice ID</th>
                <th>Instuctor Name</th>
                <th>Time</th>
                <th>Location</th>
                <th>Type</th>
                <th>Amount</th>
            </tr>
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
                    JOIN Users ON InvoiceDetails.instructorID = Users.id
                    WHERE InvoiceDetails.learnerID = '$id'
                    AND InvoiceDetails.status = '1';";
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['firstName']} {$row['lastName']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['lessonType']}</td>
                            <td>" . '$' . "{$row['amount']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No invoices found.</td></tr>";
                }
            }

            mysqli_free_result($result);
            ?>
        </table>
    </div>
</body>

</html>