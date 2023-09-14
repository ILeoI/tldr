<?php
    require_once "inc/session-start.inc.php";
    require_once "inc/dbconn.inc.php";

    $id = $_SESSION["userID"];
    $sql = "SELECT learner, instructor, supervisor FROM Users WHERE id = '$id';";
    if ($result = mysqli_query($conn, $sql)) {
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["instructor"] == 1) {
          require_once "instructor-home-page.php";
        } else if ($row["learner"] == 1) {
          require_once "learners/learner-home-page.php";
        } else if ($row["supervisor"] == 1) {
          require_once "supervisor-home-page.php";
        }
      }
    }
?>