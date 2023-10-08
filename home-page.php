<?php
    require_once "inc/db-session-include.php";

    $id = $_SESSION["userID"];
    $sql = "SELECT learner, instructor, supervisor, government FROM Users WHERE id = '$id';";
    if ($result = mysqli_query($conn, $sql)) {
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["instructor"] == 1) {
          header("location: instructors/instructor-home-page.php");
        } else if ($row["learner"] == 1) {
          header("location: learners/learner-home-page.php");
        } else if ($row["supervisor"] == 1) {
          header("location: qsds/supervisor-home-page.php");
        } else if ($row["government"] == 1) {
          header("location: government/government-home-page.php");
        }
      }
    }
    mysqli_free_result($result);
    mysqli_close($conn);
?>