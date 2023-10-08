<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "government");

// Check for viewing GET
if (!isset($_GET["viewing"])) {
    header("location: view-accounts.php");
    exit();
}

$viewingID = $_GET["viewing"];

// Load User
$sql = "SELECT * FROM Users WHERE id = '$viewingID';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $viewingUser = mysqli_fetch_assoc($result);
        if ($viewingUser["instructor"] == 1) {
            $type = "instructor";
        } else if ($viewingUser["learner"] == 1) {
            $type = "learner";
        } else if ($viewingUser["supervisor"] == 1) {
            $type = "qsd";
        } else if ($viewingUser["government"] == 1) {
            $type = "government";
        }
    }
    // User not found 
    else {
        header("location: view-accounts.php");
        exit();
    }
}

// Join Payment Details onto $viewingUser for Instructor and Learner only
if ($type == "learner" || $type == "instructor") {
    $sql = "SELECT * FROM Users JOIN PaymentDetails ON id = PaymentDetails.userID WHERE id = '$viewingID';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $viewingUser = mysqli_fetch_assoc($result);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../scripts/menu.js" defer></script>
    <link rel="stylesheet" href="../style/menu-style.css" />
    <title>TLDR: Viewing <?php echo $viewingUser["firstName"] . " " . $viewingUser["lastName"] ?></title>
</head>

<body>
    <?php require_once "government-menu.php" ?>

    <div class="content">
        <div id="personal-account-info">
            <table>
                <caption>Personal Details</caption>
                <?php
                $keys = [
                    "Name" => 'name',
                    "Date Of Birth" => 'dob',
                    "Phone Number" => 'phoneNumber',
                    "License Number" => 'licenseNo'
                ];

                foreach ($keys as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . $key . ": </td>";
                    if ($key == "Name")
                        echo "<td>" . $viewingUser["firstName"] . " " . $viewingUser["lastName"] . "</td>";
                    else
                        echo "<td>" . $viewingUser[$value] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <div id="card-payment-details" <?php if ($type != "learner") echo "style=\"display: none\"" ?>>
            <table>
                <caption>Payment Details</caption>
                <?php
                $keys = [
                    "Card Number" => 'cardNumber',
                    "Card Expiry" => 'exp',
                    "Card CVV" => 'phoneNumber',
                ];

                foreach ($keys as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . $key . ": </td>";
                    if ($value == "exp")
                        echo "<td>" . $viewingUser["cardExpiryMonth"] . "/" . $viewingUser["cardExpiryYear"] . "</td>";
                    else if ($value == "cardNumber")
                        echo "<td>" . chunk_split($viewingUser[$value], 4) . "</td>";
                    else
                        echo "<td>" . $viewingUser[$value] . "</td>";
                    echo "</tr>";
                }

                ?>
            </table>
        </div>
        <div id="card-payment-details" <?php if ($type != "instructor") echo "style=\"display: none\"" ?>>
            <table>
                <caption>Payment Details</caption>
                <?php
                $keys = [
                    "BSB Number" => 'bsb',
                    "Account Number" => 'accountNumber',
                ];

                foreach ($keys as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . $key . ": </td>";
                    if ($value == "accountNumber")
                        echo "<td>" . chunk_split($viewingUser[$value], 4, " ") . "</td>";
                    else if ($value == "bsb")
                        echo "<td>" . substr(chunk_split($viewingUser[$value], 3, "-"), 0, strlen($viewingUser[$value]) + 1) . "</td>";
                    echo "</tr>";
                }

                ?>
            </table>
        </div>
</body>

</html>