<?php
require_once "../inc/db-session-include.php";
requireUserType($conn, "learner");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: Home Page</title>
    <link rel="stylesheet" href="../style/home-page.css" />
    <link rel="stylesheet" href="../style/menu-style.css" />
    <script src="../scripts/home.js" defer></script>
    <script src="../scripts/menu.js" defer></script>
</head>

<body>
    <?php
    require_once "learner-menu.php";

    $id = $_SESSION["userID"];
    $licenseNo = "";
    $sql = "SELECT firstName, lastName, licenseNo FROM Users WHERE id = '$id';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $licenseNo = $row["licenseNo"];
            echo "<p>Welcome " . $row["firstName"] . " " . $row["lastName"] . ".</p>";
        }
    }
    mysqli_free_result($result);

    $all_minutes = array();

    // Daytime
    $sql = "SELECT sum(hour(duration)), sum(minute(duration)) FROM Drives WHERE learnerLicenseNo = '$licenseNo' AND daytime = '1' AND verified = 1;";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $hours = $row["sum(hour(duration))"];
                $minutes = $row["sum(minute(duration))"];
                $minutes = $minutes + ($hours * 60);
                $all_minutes["day"] = $minutes;
            }
        }
    }
    mysqli_free_result($result);

    // Nighttime
    $sql = "SELECT sum(hour(duration)), sum(minute(duration)) FROM Drives WHERE learnerLicenseNo = '$licenseNo' AND daytime = '0' AND verified = 1;";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $hours = $row["sum(hour(duration))"];
                $minutes = $row["sum(minute(duration))"];
                $minutes = $minutes + ($hours * 60);
                $all_minutes["night"] = $minutes;
            }
        }
    }
    mysqli_free_result($result);

    $all_minutes["total"] = $all_minutes["day"] + $all_minutes["night"];

    $cbta = 0;

    $sql = "SELECT count(*) FROM LogbookCBTA WHERE driverID = '$id' AND completed = '1';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $cbta = $row["count(*)"];
        }
    }
    mysqli_free_result($result);

    ?>
    <ul style="list-style: none; padding-left: 0px; max-height: 350px;">
        <li>
            <!-- Logbook Drives Total Progress -->
            <div class="progress-container">
                <div class="progress-label">Total Progress</div>
                <!-- This div contains the circular progress bar -->
                <!-- radial-gradient() describes a progressive transition between two or more colours
                     in this instance it is describing a gradient that is white till 79%, then transparent from 80% to 100% 
                     this provides the circle mask for the conic gradient -->
                <!-- conic-gradient() makes colour transitions around a central point (hence conic). 
                     The way it is structured the conic gradient is rendered first, then the radial gradient is centred on top of that. 
                     Combined with the radius defined in the stylesheet, this produces an overall look of a circle, but is three different layers -->
                <!-- The styling was put in here so it could be manipulated by PHP at request. We simply set the percent to the calculated percentage. 
                     This is the same for the other three circles, obviously with different colours -->
                <div class="progress-bar" style="
                background: 
                    radial-gradient(closest-side, white 79%, transparent 80% 100%),
                    conic-gradient(green <?php echo round(($all_minutes["total"] / 4500) * 100, 2); ?>%, #d1fff1 0);">
                    <p class="percentage"><?php echo round(($all_minutes["total"] / 4500) * 100, 2); ?>%</p>
                </div>
            </div>
        </li>
        <li>
            <!-- Logbook Drives Night Progress -->
            <div class="progress-container">
                <div class="progress-label">Night Progress</div>
                <div class="progress-bar" style="   
                background: 
                    radial-gradient(closest-side, white 79%, transparent 80% 100%),
                    conic-gradient(#383836 <?php echo round(($all_minutes["night"] / 900) * 100, 2); ?>%, #d1fff1 0);">
                    <p class="percentage"><?php echo round(($all_minutes["night"] / 900) * 100, 2); ?>%</p>
                </div>
            </div>
        </li>
        <li>
            <!-- Logbook CBTA Progress -->
            <div class="progress-container">
                <div class="progress-label">CBTA Progress</div>
                <div class="progress-bar" style="
                background: 
                    radial-gradient(closest-side, white 79%, transparent 80% 100%),
                    conic-gradient(#e6d150 <?php echo round(($cbta / 48) * 100, 2); ?>%, #d1fff1 0);">
                    <p class="percentage"><b><?php echo round(($cbta / 48) * 100, 2); ?>%</b></p>
                </div>
            </div>
        </li>
    </ul>


</body>

</html>

<?php
mysqli_close($conn);
?>