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
    <link rel="stylesheet" href="style/my-account.css" />
</head>

<body>
    <h1 class="page-title">My Account</h1>
    <?php
        $id = $_SESSION["userID"];
        $sql = "SELECT email, phoneNumber, licenseNo, firstName, lastName FROM Users WHERE id = '$id';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                echo '<div class="account-info">
                        <table>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>' . $user['email'] . '</td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>' . $user['phoneNumber'] . '</td>
                            </tr>
                            <tr>
                                <td>License Number</td>
                                <td>' . $user['licenseNo'] . '</td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td>' . $user['firstName'] . '</td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>' . $user['lastName'] . '</td>
                            </tr>
                            <!-- Add more rows for other fields as needed -->
                        </table>
                    </div>';
            } else {
                echo 'No user found.';
            }
        } else {
            echo 'Error fetching user data: ' . mysqli_error($conn);
        }
    ?>
</body>

</html>
