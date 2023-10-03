<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";

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
    <?php require_once "supervisor-menu.php"; ?>

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
                            <td>License Number: </td>
                            <td>' . $user['licenseNo'] . '</td>
                        </tr>
                        <tr>
                            <td>First Name: </td>
                            <td>' . $user['firstName'] . '</td>
                        </tr>
                        <tr>
                            <td>Last Name: </td>
                            <td>' . $user['lastName'] . '</td>
                        </tr>
                        
                    </table>
                </div>';
        }
    } else {
        echo 'Error fetching user data: ' . mysqli_error($conn);
    }
    mysqli_free_result($result);

    ?>

    <div class="button-container">
        <a href="change-password.php">
            <button class="add-lesson-button">Change Password</button>
        </a>
    </div>

    <div id="edit-payment-form" style="display: none;">
        <form method="post">
            Card Number: <input type="text" name="cardNumber" value="<?php echo $cardNumber; ?>"><br>
            Expiry Month: <input type="text" name="cardExpiryMonth" value="<?php echo $cardExpiryMonth; ?>"><br>
            Expiry Year: <input type="text" name="cardExpiryYear" value="<?php echo $cardExpiryYear; ?>"><br>
            CVV: <input type="text" name="cardCVV" value="<?php echo $cardCVV; ?>"><br>
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