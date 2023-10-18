<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $toBePaid = array();
    foreach (array_keys($_POST) as $id) {
        $toBePaid[] = $id;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/pay-invoice.css" />
    <script src="../scripts/pay-invoices.js" defer></script>
    <style>
        .hidden {
            display: none
        }
    </style>
    <title>TLDR: Pay Invoice</title>
</head>

<body>
    <div class="content">
        <br>
        <h1>Invoices to be paid</h1>
        <?php
        $sql = "SELECT * FROM InvoiceDetails WHERE ";
        for ($i = 0; $i < count($toBePaid); $i++) {
            $sql .= "id = '{$toBePaid[$i]}' ";
            if ($i < count($toBePaid) - 1) {
                $sql .= "OR ";
            }
        }
        $sql .= ";";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $totalAmount = 0;
                echo "<ul>";
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row["id"];
                    $amount = $row["amount"];
                    $totalAmount += $amount;
                    echo "<li>$" . number_format($amount, 2) . "</li>";
                }
                echo "</ul>";
                echo "Total: $" . number_format($totalAmount, 2);
            }
            mysqli_free_result($result);
        }
        ?>
        <br>
        <div jd="payment-options">
            <input type="radio" name="payment-options" id="on-file" value="on-file" checked>
            <label for="on-file">On File</label>
            <input type="radio" name="payment-options" id="input" value="input">
            <label for="input">Another Card</label>
        </div>
        <div id="input-payment">
            <form action="submit-payment.php" method="POST">
                <br>
                <label>Input Payment</label> <br>
                
                <label for="cardNumber">Card Number:</label>
                <input type="text" class="cardInput" name="cardNumber" required> <br>
                
                <label for="cardExpiry">Card Expiry:</label>
                <input type="number" name="cardExpiryMonth" class="cardExpiry cardInput" required />/<input type="number" name="cardExpiryYear" class="cardExpiry cardInput" required /> <br>
                
                <label for="cardCCv">Card CCV:</label>
                <input type="text" name="cardCCV" class="cardInput" required> <br>

                <?php
                foreach ($toBePaid as $id) {
                    echo "<input type='text' name='$id' hidden>";
                }
                ?>

                <br>
                <input type="submit" value="Pay">
                <br>
                <br>
            </form>
        </div>
        <div id="file-payment">
            <?php
            $sql = "SELECT * FROM PaymentDetails WHERE userID = {$_SESSION["userID"]}";
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    $entry = mysqli_fetch_assoc($result);
                    $cardNumber = $entry["cardNumber"];
                    $cardNumber = substr($cardNumber, 12);
                    echo "Paying with card ending with: " . $cardNumber;
                }
            }
            mysqli_free_result($result);
            mysqli_close($conn);
            ?>

            <form action="submit-payment.php" method="POST">
                <?php
                foreach ($toBePaid as $id) {
                    echo "<input type='text' name='$id' hidden>";
                }
                ?>
                <br>
                <input type="submit" value="Pay">
                <br>
                <br>
            </form>
        </div>
    </div>
</body>

</html>