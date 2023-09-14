<?php
    require_once "inc/session-start.inc.php";
    require_once "inc/dbconn.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Jacob">
    <meta name="description" content="HomePage">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: Home Page</title>
    <link rel="stylesheet" href="style/home-page.css" />
    <script src="scripts/home.js" defer></script>
</head>
<h1 class="page-title" id="home-page-header">
<body>

<div class="dropdown">
  <button class="dropbtn">
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
  
  </button>
  <div class="dropdown-content">
    <a href="drives.php">Drives Log</a>
    <a href="cbta.php">CBTA</a>
    <a href="your-account.php">Account</a>
  </div>
</div>
    

  Home Page</h1>
    <p>Welcome, user</p>
    <h1 class="page-title" id="home-page-header">Home Page</h1>
    <?php
        $id = $_SESSION["userID"];
        $sql = "SELECT firstName, lastName FROM Users WHERE id = '$id';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<p>Welcome " . $row["firstName"] . " " . $row["lastName"] .".</p>";
            }
        }
    ?>
</body>
</html>