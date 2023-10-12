<?php

require_once "../inc/db-session-include.php";

foreach (array_keys($_POST) as $id) {
    $sql = "UPDATE InvoiceDetails SET status = 1 WHERE id = '$id';";
    try {
        mysqli_query($conn, $sql);
    } catch (mysqli_sql_exception) {

    }
}

header("location: view-invoices.php");