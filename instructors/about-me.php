<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "instructor");

$id = getID();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $allowedKeys = ["aboutMe", "serviceableArea"];
    foreach ($_POST as $key => $value) {
        if (empty($value) || !in_array($key, $allowedKeys)) {
            continue;
        }
        $sql = "UPDATE InstructorInfo SET $key = ? WHERE instructorID = $id;";
        $statement = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($statement, "s", $value);
        mysqli_stmt_execute($statement);
    }
}

$sql = "SELECT * FROM Users JOIN InstructorInfo ON Users.id = InstructorInfo.instructorID WHERE id = '$id';";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $name = $user["firstName"] . " " . $user["lastName"];
        $dob = date("Y", strtotime($user["dob"]));
        $currentYear = date("Y", time());
        $age = $currentYear - $dob;
        $serviceableArea = $user["serviceableArea"];
        $aboutMe = $user["aboutMe"];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/home-page.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/menu.js" defer></script>
    <script src="../scripts/about-me.js" defer></script>
    <title>TLDR: About Me</title>

    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php require_once "instructor-menu.php"; ?>
    <br>
    <div class="about-me" id="view">
        <br>
        <h2>Your Profile</h2>
        <p>Name: <b><?php echo $name ?></b>, Age: <b><?php echo $age ?></b></p>
        <p>Serviceable Area: <b><?php echo htmlspecialchars($serviceableArea) ?></b></p>
        <label for="about-me"><b>About Me</b></label>
        <p id="about-me-paragraph"><?php echo htmlspecialchars($aboutMe) ?></p>
        <button id="about-me-edit-button" class="about-me-button">Edit</button>
        <br>
        <br>
    </div>
    <br>
    <div class="about-me hidden" id="edit">
        <br>
        <form action="about-me.php" method="post">
            <h2>Your Profile</h2>
            <p>Name: <b><?php echo $name ?></b>, Age: <b><?php echo $age ?></b></p>
            <p>Serviceable Area: <input type="text" name="serviceableArea" placeholder="<?php echo htmlspecialchars($serviceableArea) ?>"></p>
            <label for="about-me"><b>About Me</b></label><br>
            <textarea name="aboutMe" id="about-me-textarea"><?php echo htmlspecialchars($aboutMe) ?></textarea>
            <br>
            <label class="" id="count"></label>
            <br>
            <input type="submit" id="about-me-submit-button" class="about-me-button" value="Save">
        </form>
        <br>
    </div>
    <br>
</body>

</html>