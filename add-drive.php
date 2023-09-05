<?php 

if (isset($_POST["add_drive"])) {
   require_once "inc/dbconn.inc.php"; 
   
    $sql = "INSERT INTO Drive() VALUES(?);";

    $statement = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($statement, $sql); 
    mysqli_stmt_bind_param($statement, 's', htmlspecialchars($_POST["add"])); 

    if (mysqli_stmt_execute($statement)) {
        header("location: drive.php");
    } else {
        echo "mysqli_error($conn)";
    }
    mysqli_close($conn);
}

?>
