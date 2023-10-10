<?php

require_once "../inc/db-session-include.php";
requireUserType($conn, "government");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["id"])) {
    $sql = array();
    $id = $_GET["id"];
    $feedback = 0;
    foreach ($_POST as $key => $value) {
        if (!empty($value)) {
            if (str_contains($key, "card") || $key == "bsb" || $key == "accountNumber") {
                $sql[] = "UPDATE PaymentDetails SET $key = '$value' WHERE userID = '$id';";
                $feedback = 2;
            } else {
                $sql[] = "UPDATE Users SET $key = '$value' WHERE id = '$id';";
            }
        }
    }

    foreach ($sql as $var) {
        try {
            mysqli_query($conn, $var);
        } catch (mysqli_sql_exception $e) {
            $feedback += 1;
            header("location: view-account.php?viewing=$id&feedback=$feedback)");
        }
    }

    header("location: view-account.php?viewing=$id&feedback=$feedback");
    exit();
}
