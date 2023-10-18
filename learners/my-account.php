<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardNumber = $_POST["cardNumber"];
    $cardExpiryMonth = $_POST["cardExpiryMonth"];
    $cardExpiryYear = $_POST["cardExpiryYear"];
    $cardCVV = $_POST["cardCVV"];
    $userID = $_SESSION["userID"];

    $updateSql = "UPDATE PaymentDetails SET cardNumber = '$cardNumber', cardExpiryMonth = $cardExpiryMonth, cardExpiryYear = $cardExpiryYear, cardCVV = $cardCVV WHERE userID = $userID";
    if (mysqli_query($conn, $updateSql)) {
        echo "Payment details updated successfully.";
    } else {
        echo "Error updating payment details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Jacob">
    <meta name="description" content="My Account Page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: My Account</title>
    <link rel="stylesheet" href="../style/my-account.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
</head>

<body>
    <?php require_once "learner-menu.php"; ?>

    <br>

    <?php
    $id = $_SESSION["userID"];
    $sql = "SELECT *
    FROM users
    LEFT JOIN PaymentDetails ON users.id = PaymentDetails.userID
    WHERE users.id = $id;";

    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            $cardNumber = $user['cardNumber'] !== null ? $user['cardNumber'] : '';
            $cardExpiryMonth = $user['cardExpiryMonth'] !== null ? $user['cardExpiryMonth'] : '';
            $cardExpiryYear = $user['cardExpiryYear'] !== null ? $user['cardExpiryYear'] : '';
            $cardCVV = $user['cardCVV'] !== null ? $user['cardCVV'] : '';

            echo '<div class="account-info">
                    <table>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>Email: </td>
                            <td>' . $user['email'] . '</td>
                        </tr>
                        <tr>
                            <td>Phone Number: </td>
                            <td>' . $user['phoneNumber'] . '</td>
                        </tr>
                        <tr>
                            <td>Licence Number: </td>
                            <td>' . $user['licenceNo'] . '</td>
                        </tr>
                        <tr>
                            <td>First Name: </td>
                            <td>' . $user['firstName'] . '</td>
                        </tr>
                        <tr>
                            <td>Last Name: </td>
                            <td>' . $user['lastName'] . '</td>
                        </tr>
                        <tr>
                            <td>Card Number: </td>
                            <td>' . chunk_split($cardNumber, 4, " ") . '</td>
                        </tr>
                        <tr>
                            <td>Expiry Month: </td>
                            <td>' . $cardExpiryMonth . '</td>
                        </tr>
                        <tr>
                            <td>Expiry Year: </td>
                            <td>' . $cardExpiryYear . '</td>
                        </tr>
                        <tr>
                            <td>CVV: </td>
                            <td>' . $cardCVV . '</td>
                        </tr>
                        <td> 
                        <button id="edit-payment-button" class="add-lesson-button">Edit Payment</button>
                    </td>
                
                <td> 
                    <a href="change-password.php">
                        <button id ="change-password" class ="add-lesson-button"> Change Password</button> 
                    </a>
                </td>
                        </tr>
                    </table>
                </div>';
        }
    } else {
        echo 'Error fetching user data: ' . mysqli_error($conn);
    }
    mysqli_free_result($result);

    ?>



    <div id="edit-payment-form" style="display: none;">
        <form method="post">
            Card Number: <input type="text" name="cardNumber" value="<?php echo $cardNumber; ?>"><br>
            Expiry Month:<input type="text" name="cardExpiryMonth" value="<?php echo $cardExpiryMonth; ?>"><br>
            Expiry Year: <input type="text" name="cardExpiryYear" value="<?php echo $cardExpiryYear; ?>"><br>
            CVV:<input type="text" name="cardCVV" value="<?php echo $cardCVV; ?>"><br>
            <input type="submit" value="Save">
        </form>
    </div>

    <script>
        document.getElementById('edit-payment-button').addEventListener('click', function() {
            document.getElementById('edit-payment-form').style.display = 'block';
        });
    </script>
</body>

</html>

<?php
mysqli_close($conn);
?>