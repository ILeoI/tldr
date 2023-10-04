<?php
require_once "inc/dbconn.inc.php";
require_once "inc/session-start.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLDR: View Invoice</title>
</head>

<body>
    <!-- Generate the invoice from the database -->
    <h1>Invoice</h1>
    <ul>
        <li>Invoice ID: #4141</li>
        <li>Instructor: Instructor Driver</li>
        <li>Student: Student Driver</li>
        <li>Location: Bedford Park</li>
        <li>Status: PAID</li>
        <li>Time of Lesson: 14:00</li>
        <li>Date of Lesson: 29/11/2023</li>
        <li>Time liaid: 15:00</li>
        <li>Date liaid: 29/11/2023</li>
        <p>Amount To Be Paid</p>
        <li>$42.00</li>
    </ul>
</body>

</html>