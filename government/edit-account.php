<?php

require_once "../inc/db-session-include.php";
requireUserType($conn, "government");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["id"])) {
    $sql = array();
    $id = $_GET["id"];
    foreach ($_POST as $key => $value)
    {
        if (!empty($value))
        {
            if(str_contains($value, "card")) {
                $sql[] = "UPDATE PaymentDetails SET $key = '$value' WHERE id = '$id';";
            } else {
                $sql[] = "UPDATE Users SET $key = '$value' WHERE id = '$id';";
            }
        }
    }

    foreach ($sql as $var)
    {
        try {
            mysqli_query($conn, $var);
        } catch (mysqli_sql_exception) {

        }
    }

    header("location: view-student.php?viewing=$id");
    exit();
}
