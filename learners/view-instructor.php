<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");

if (isset($_GET["viewing"])) {
    $viewingID = $_GET["viewing"];
} else {
    header("location: find-instructor.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/menu-style.css" />
    <link rel="stylesheet" href="../style/home-page.css" />
    <script src="../scripts/menu.js" defer></script>
    <title>TLDR: Instructor View</title>
</head>

<body>
    <?php 
        require_once "learner-menu.php"; 
        $sql = "SELECT * FROM InstructorInfo JOIN Users ON InstructorInfo.instructorID = Users.id WHERE instructorID = '$viewingID';";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                $name = $user["firstName"] . " " . $user["lastName"];
                $dob = date("Y", strtotime($user["dob"]));
                $currentYear = date("Y", time());
                $age = $currentYear - $dob;
                $serviceableArea = $user["serviceableArea"];
                $aboutMe = $user["aboutMe"];
            } else {
                header("location: find-instructor.php");
                exit();
            }
        }
    ?>

    <br>

    <div class="about-me" id="view">
        <br>
        <h2>Instructor Profile</h2>
        <p>Name: <b><?php echo $name ?></b>, Age: <b><?php echo $age ?></b></p>
        <p>Serviceable Area: <b><?php echo htmlspecialchars($serviceableArea) ?></b></p>
        <label for="about-me"><b>About Me</b></label>
        <p id="about-me-paragraph"><?php echo htmlspecialchars($aboutMe) ?></p>
        <br>
    </div>
</body>

</html>

<?php 
mysqli_close($conn);
?>