<?php
    require_once "../inc/dbconn.inc.php";
    require_once "../inc/session-start.inc.php";


    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $licenseNumber = $_POST["student-ln-input"];
        $instructorID = $_SESSION["userID"];
        $sql = "SELECT id FROM Users WHERE licenseNo = '$licenseNumber';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $learnerID = $row["id"];
                $sql = "SELECT * FROM InstructorLearners WHERE learnerID = '$learnerID';";
                mysqli_free_result(($result));
                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        header("location: students.php?feedback=1");
                    } else {
                        $sql = "INSERT INTO InstructorLearners(instructorID, learnerID) VALUES('$instructorID', '$learnerID');";
                        try {
                            mysqli_query($conn, $sql);
                            header("location: students.php?feedback=3");
                        } catch (mysqli_sql_exception) {
                            header("location: students.php?feedback=0");
                        }
                    }
                }
                mysqli_free_result($result);
            } else {
                header("location: students.php?feedback=2");
            }
        }
    }
    mysqli_close($conn);
