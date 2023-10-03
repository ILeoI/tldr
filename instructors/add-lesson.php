<?php
require_once "../inc/dbconn.inc.php";
require_once "../inc/session-start.inc.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/menu-style.css" />
  <script src="../scripts/menu.js" defer></script>
  <title>TLDR: Add A Lesson</title>
</head>

<body>

  <?php
  require_once "instructor-menu.php";
  // Retrieve list of students for the dropdown
  $instructorID = $_SESSION["userID"];
  $sql = "SELECT Users.id, Users.firstName, Users.lastName 
        FROM Users 
        JOIN InstructorLearners ON Users.id = InstructorLearners.learnerID 
        WHERE InstructorLearners.instructorID = '$instructorID';";

  $students = array();

  if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
      $students[] = $row;
    }
  }
  mysqli_free_result($result);
  ?>
  <br>
  <form action="add-lesson.php" method="post">
    <label for="student">Select Student:</label>
    <select id="student" name="student" required>
      <?php
      foreach ($students as $student) {
        echo "<option value='{$student['id']}'>{$student['firstName']} {$student['lastName']}</option>";
      }
      ?>
    </select><br><br>

    <label for="time">Time:</label>
    <input type="datetime-local" id="time" name="time" required><br><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required><br><br>

    <input type="submit" value="Submit">
  </form>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $studentID = $_POST["student"];
  $time = $_POST["time"];
  $location = $_POST["location"];
  $instructorID = $_SESSION["userID"];

  // Insert into bookings table
  $sql = "INSERT INTO bookings (instructorID, learnerID, time, location) VALUES ('$instructorID', '$studentID', '$time', '$location');";

  if (mysqli_query($conn, $sql)) {
    header("location: ../home-page.php"); // Redirect to instructor's homepage
    exit();
  } else {
    header("location: add-lesson.php?feedback=0"); // Redirect with error message
  }
}

mysqli_close($conn);
?>