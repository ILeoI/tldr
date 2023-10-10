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
    <script src="../scripts/collapsible.js" defer></script>
    <link rel="stylesheet" href="../style/collapsible.css" />
    <script src="../scripts/government-edit-account.js" defer></script>
    <title>TLDR: Viewing <?php echo $viewingUser["firstName"] . " " . $viewingUser["lastName"] ?></title>
    <style>
        .hidden {
            display: none
        }
    </style>
</head>

<body>
    <?php require_once "government-menu.php" ?>

    <?php
    if (isset($_GET["feedback"])) {
        $feedback = $_GET["feedback"];
        if ($feedback == "0") {
            echo "<p class=\"feedback\">Personal Details changed successfully</p>";
        } else if ($feedback == "1") {
            echo "<p class=\"feedback\">Failed to change Personal Details</p>";
        } else if ($feedback == "2") {
            echo "<p class=\"feedback\">Payment Details changed successfully</p>";
        } else if ($feedback == "3") {
            echo "<p class=\"feedback\">Failed to change Payment Details</p>";
        }
    }
    ?>

    <!-- Personal details -->
    <button class="collapsible">View Account Details</button>
    <div class="content">
        <div id="personal-account-info">
            <br>
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
            <button id="edit-account">Edit Account</button>
        </div>
        <div id="editable-personal-account-info" class="hidden">
            <BR>
            <form action="edit-account.php?id=<?php echo $viewingID ?>" method="post">
                <table>
                    <caption>Personal Details</caption>
                    <?php
                    $keys = [
                        "First Name" => 'firstName',
                        "Last Name" => 'lastName',
                        "Date Of Birth" => 'dob',
                        "Phone Number" => 'phoneNumber',
                        "License Number" => 'licenseNo'
                    ];

                    foreach ($keys as $key => $value) {
                        echo "<tr>";
                        echo "<td>" . $key . ": </td>";
                        echo "<td><input type=\"text\" name=\"$value\"placeholder=\"" . $viewingUser[$value] . "\"></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <input type="submit" value="Save">
            </form>
        </div>
    </div>
    <br>
    <!-- Payment details for learner -->
    <div id="hider" <?php if ($type != "learner") echo "style=\"display: none\"" ?>>
        <button class="collapsible">View Payment Details</button>
        <div class="content">
            <div id="card-payment-details">
                <table>
                    <caption>Payment Details</caption>
                    <?php
                    $keys = [
                        "Card Number" => 'cardNumber',
                        "Card Expiry" => 'exp',
                        "Card CVV" => 'cardCVV',
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
                <button id="edit-learner-payment">Edit Payment Details</button>
            </div>
            <div id="editable-card-payment-details" class="hidden">
                <form action="edit-account.php?id=<?php echo $viewingID ?>" method="post">
                    <table>
                        <caption>Edit Payment Details</caption>
                        <?php
                        $keys = [
                            "Card Number" => 'cardNumber',
                            "Card Expiry" => 'exp',
                            "Card CVV" => 'cardCVV',
                        ];

                        foreach ($keys as $key => $value) {
                            echo "<tr>";
                            echo "<td>" . $key . ": </td>";
                            if ($value == "exp")
                                echo "<td><input type=\"text\" name=\"cardExpiryMonth\" placeholder=\"" . $viewingUser["cardExpiryMonth"] . "\">/<input type=\"text\" name=\"cardExpiryYear\" placeholder=\"" . $viewingUser["cardExpiryYear"] . "\"></td>";
                            else if ($value == "cardNumber")
                                echo "<td><input type=\"text\" name=\"cardNumber\" placeholder=\"" . $viewingUser[$value] . "\"></td>";
                            else
                                echo "<td><input type=\"text\" name=\"cardCVV\" placeholder=\"" . $viewingUser[$value] . "\"></td>";
                            echo "</tr>";
                        }

                        ?>
                    </table>
                    <input type="submit" value="Save Details">
                </form>
            </div>
        </div>
    </div>
    <!-- Payment details for instructor -->
    <div <?php if ($type != "instructor") echo "style=\"display: none\"" ?>>
        <button class="collapsible">View Account Details</button>
        <div class="content">
            <div id="instructor-payment-info">
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
                <button id="edit-instructor-payment">Edit Payment Details</button>
            </div>
            <div id="editable-instructor-payment-info" class="hidden">
                <form action="edit-account.php?id=<?php echo $viewingID ?>" method="post">
                    <table>
                        <caption>Edit Payment Details</caption>
                        <?php
                        $keys = [
                            "BSB Number" => 'bsb',
                            "Account Number" => 'accountNumber',
                        ];

                        foreach ($keys as $key => $value) {
                            echo "<tr>";
                            echo "<td>" . $key . ": </td>";
                            echo "<td><input type=\"text\" name=\"$value\" placeholder=\"{$viewingUser[$value]}\"></td>";
                            echo "</tr>";
                        }

                        ?>
                    </table>
                    <input type="submit">
                </form>
            </div>
        </div>
    </div>
</body>

</html>