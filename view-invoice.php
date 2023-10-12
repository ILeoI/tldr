<?php
require_once "inc/db-session-include.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLDR: View Invoice</title>
</head>

<body>
<?php
    
    //Generate the invoice from the database -->
     ?>
    <h1>Invoice</h1>
    <table>
        <tr>
            <td>Invoice ID</td>
            <td>#4141</td>
        </tr>
        <tr>
            <td>Instructor</td>
            <td>Instructor Driver</td>
        </tr>
        <tr>
            <td>Student</td>
            <td>Student Driver</td>
        </tr>
        <tr>
            <td>Location</td>
            <td>Bedford Park</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>PAID</td>
        </tr>
        <tr>
            <td>Time of Lesson</td>
            <td>14:00</td>
        </tr>
        <tr>
            <td>Date of Lesson</td>
            <td>29/11/2023</td>
        </tr>
        <tr>
            <td>Time Paid</td>
            <td>15:00</td>
        </tr>
        <tr>
            <td>Date Paid</td>
            <td>29/11/2023</td>
        </tr>
        <tr>
            <td>Amount To Be Paid</td>
            <td>$42.00</td>
        </tr>
    </table>
    
</body>

</html>
