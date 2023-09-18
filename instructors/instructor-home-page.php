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

<body>
    <h1 class="page-title" id="home-page-header">
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
        <label>Home Page</label>
    </h1>
    <?php
    $id = $_SESSION["userID"];
    $sql = "SELECT firstName, lastName FROM Users WHERE id = '$id';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<p>Welcome " . $row["firstName"] . " " . $row["lastName"] . ".</p>";
        }
    }
    ?>

<table>
  
<tr>
<caption>Your Bookings</caption>
    <th>Name</th>
    <th>Time</th>
    <th>Location</th> 
</tr>

<tr> 
    <td>Column 1</td>
    <td>Column 2</td>
    <td>Column 3</td>
  </tr>
  <tr> 
    <td>Column 1</td>
    <td>Column 2</td>
    <td>Column 3</td>
  </tr>
  <tr>
    <td>Column 1</td>
    <td>Column 2</td>
    <td>Column 3</td>
  </tr>
</table>

<div class="button-container">
  <a href="instructors/add-lesson.php">
    <button class="add-lesson-button">Add Lesson</button>
  </a>
</div>



    

</body>

</html>